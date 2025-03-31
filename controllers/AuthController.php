<?php
namespace App\Controllers;
/**
 * Développeur assigné(s) : Pierre
 * Entité : Classe 'AuthController' de la couche 'Controller'
 */

use App\Models\User;
use App\Services\AuthService;

class AuthController 
{
    private User $userModel;
    private AuthService $authService;

    public function __construct() 
    {
        $this->userModel = new User();
        $this->authService = new AuthService();
    }

    /**
     * Affiche le formulaire de login
     */
    public function loginForm() 
    {
        // Render le login form view
        include __DIR__ . '/../Views/auth/login.php';
    }

    /**
     * Authentifie l'utilisateur
     */
    public function login() 
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = $this->userModel->findByUsername($username);

            if ($user && $user->verifyPassword($password) && $user->isActive()) {
                // Authentication est un succès
                $this->authService->login($user);
                header('Location: /dashboard'); // Rediriger vers le dashboard
                exit();
            } else {
                // Erreur d'authentification
                $error = 'Nom d\'utilisateur ou mot de passe incorrect.';
                include __DIR__ . '/../Views/auth/login.php';
            }
        } else {
            // Rediriger vers le login form via GET
            header('Location: /login');
            exit();
        }
    }

    /**
     * Gère le logout
     */
    public function logout() 
    {
        $this->authService->logout();
        header('Location: /login'); // Rediriger vers la page de login après le logout
        exit();
    }

    // à implémenter (optionnellement) : 
    // - forgotPasswordForm()
    // - forgotPassword()
    // - resetPasswordForm()
    // - resetPassword()
}
?>