<?php
namespace App\Services;

use App\Models\User;
use App\Models\Admin;

/**
 * Développeur assigné(s)
 * Entité : Classe 'AuthService' de la couche 
 * Description : Service d'authentification gérant les sessions PHP pour utilisateurs et administrateurs.
 */

class AuthService 
{
    private string $userSessionKey = 'user_id';
    private string $adminSessionKey = 'admin_id';

    public function __construct() 
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Fonction qui authentifie l'utilisateur en settant le user ID dans la session
     * Utilise la fonction unset pour s'assurer qu'il n'y ait pas d'admin connecté en même temps
     * @param User $user Instance d'un objet de la classe User
     * @return void
     */
    public function login(User $user) : void 
    {
        $SESSION[$this->userSessionKey] = $user->getId();
        unset($_SESSION[$this->adminSessionKey]); 
    }

    /**
     * Fonction qui authentifie l'admin en settant le adminID dans la session
     * Utilise la fonction unset pour s'assurer qu'il n'y ait pas de user connecté en même temps
     * @param Admin $admin Instance d'un objet de la classe Admin
     * @return void
     */
    public function loginAdmin(Admin $admin): void 
    {
        $SESSION[$this->adminSessionKey] = $admin->getId();
        unset($SESSION[$this->userSessionKey]); 
    }

    /**
     * Déconnecte l'admin ou le user connecté en détruisant la session
     * @return void
     */
    public function logout(): void 
    {
        session_destroy();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Retourne le modèle de l'objet de l'utilisateur connecté (si disponible)
     * @return ?User L'objet de l'utilisateur connecté, sinon null si aucun utilisateur est connecté
     */
    public function getCurrentUser(): ?User 
    {
        if(isset($_SESSION[$this->userSessionKey])) 
        {
            $userModel = new User();
            return $userModel->find($_SESSION[$this->userSessionKey]);
        }
        return null;
    }

    /**
     * Méthode qui retourne le modèle de l'objet de l'admin connecté (si disponible)
     * @return ?Admin L'objet de l'admin connecté, sinon null si aucun admin est connecté
     */
    public function getCurrentAdmin(): ?Admin 
    {
        if(isset($SESSION[$this->adminSessionKey])) 
        {
            $adminModel = new Admin();
            return $adminModel->find($_SESSION[$this->adminSessionKey]);
        }
        return null;
    }

    /**
     * Méthode qui vérifie si un utilisateur régulier est connecté
     * @return bool True si un utilisateur est connecté, sinon False
     */
    public function isLoggedIn() : bool 
    {
        return isset($_SESSION[$this->userSessionKey]);
    }

    /**
     * Méthode qui vérifie si un admin est connecté
     * @return bool Retourne True si un admin est connecté, sinon False
     */
    public function isAdminLoggedIn(): bool 
    {
        return isset($_SESSION[$this->adminSessionKey]);
    }

    /**
     * Méthode qui démarre la session PHP si elle n'a pas déja été commencée
     * @return void
     */
    private function startSession(): void 
    {
        if(session_status() === PHP_SESSION_NONE) 
        {
            session_start();
        }
    }

    /**
     * Détruit la session PHP actuelle
     * @return void
     */
    private function destroySession(): void 
    {
        session_destroy();
    }
}


?>