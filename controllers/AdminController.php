<?php

namespace App\Controllers;

/**
 * Développeur assigné(s) : Seydina
 * Entité : Classe 'AdminController' de la couche Controller
 */

use App\Models\User;
use App\Models\Log;
use App\Models\Role;
use App\Services\ValidationService;
use App\Services\AuthService;

class AdminController
{
    private ValidationService $validator;
    private AuthService $auth;

    public function __construct()
    {
        $this->validator = new ValidationService();
        $this->auth = new AuthService();
    }

    /**
     * Liste tous les utilisateurs
     */
    public function index(): void
    {
        $this->auth->requireAdmin();

        $userModel = new User();
        $users = $userModel->getAll();

        include_once __DIR__ . '/../views/admin/users_list.php';
    }

    /**
     * Active un compte utilisateur
     */
    public function activate(int $userId): void
    {
        $this->auth->requireAdmin();

        $userModel = new User();
        $userModel->activate($userId);

        Log::logAction($_SESSION['user_id'], "Activation du compte utilisateur ID $userId");

        header("Location: /admin/users");
        exit();
    }

    /**
     * Désactive un compte utilisateur
     */
   

    /**
     * Liste des logs système
     */
    
    }
}

?>