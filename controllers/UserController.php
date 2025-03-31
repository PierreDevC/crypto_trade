<?php

namespace App\Controllers;
/**
 * Développeur assigné(s) : Pierre
 * Entité : Classe 'UserController' de la couche Controller
 */

use App\Models\User;
use App\Services\AuthService;
use App\Services\ValidationService;

class UserController
{
    private User $userModel;
    private AuthService $authService;
    private ValidationService $validationService;

    public function __construct()
    {
        $this->userModel = new User();
        $this->authService = new AuthService();
        $this->validationService = new ValidationService();
    }

    public function registerForm()
    {
        include __DIR__ . '/../Views/auth/register.php';
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];

            $errors = $this->validationService->validateRegistration($username, $email, $password, $confirmPassword);

            if (empty($errors)) {
                if ($this->userModel->findByUsername($username)) {
                    $errors['username'] = 'Username already exists.';
                }
                if ($this->userModel->findByEmail($email)) {
                    $errors['email'] = 'Email already exists.';
                }
            }

            if (empty($errors)) {
                $user = new User();
                $user->setUsername($username);
                $user->setEmail($email);
                $user->setPassword($password);
                $user->setRegistrationToken(bin2hex(random_bytes(32))); // Generate a registration token
                $user->isActive(true); // User needs to activate their account (optional)
                $user->setBalance(0.00); // Set initial balance

                if ($user->save()) {
                    // Optionally send an activation email using the registration token
                    // Redirect to a success page or login page
                    header('Location: /login');
                    exit();
                } else {
                    // Gérer erreurs de base de données
                    $errors['general'] = 'Registration failed. Veuillez réessayer.';
                }
            }

            // If there are errors, re-display the registration form with error messages
            include __DIR__ . '/../Views/auth/register.php';
        } else {
            // Redirect to the registration form if accessed via GET
            header('Location: /register');
            exit();
        }
    }

}

?>