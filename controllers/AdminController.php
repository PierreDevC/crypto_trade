<?php

namespace App\Controllers;

/**
 * Développeur assigné(s) : Seydina
 * Entité : Classe 'AdminController' de la couche Controller
 */
// helloddd

 use App\Models\Admin;
 use App\Models\User;
 use App\Models\Currency;
 use App\Models\Setting;
 use App\Models\Log;
 use App\Services\AuthService;
 use App\Services\ValidationService;

class AdminController 
{   
    // Couche Models
    private Admin $adminModel;
    private User $userModel;
    private Currency $currencyModel;
    private Setting $settingModel;
    private Log $logModel;

    // Couche Service
    private AuthService $authService;
    private ValidationService $validationService;

    public function __construct()
    {
        // S'assurer que seuls les admins connectés peuvent accéder à ces actions
        $this->authService = new AuthService();
        $loggedInAdmin = $this->authService->getCurrentAdmin();
        if (!$loggedInAdmin) {
            header('Location: /admin/login'); // Rediriger à la page de connexion admin si non connecté
            exit(); 
        }

        $this->adminModel = new Admin();
        $this->userModel = new User();
        $this->currencyModel = new Currency();
        $this->settingModel = new Setting();
        $this->logModel = new Log();
        $this->validationService = new ValidationService();
    }

    public function dashboard() 
    {
        // Fetch l'information pour le dashboard
        include __DIR__ . '/../views/admin/dashboard.php';
    }

    /**
     *  Affiche la liste des utilisateurs
     *  @return void
     */
    public function userList()
    {
        $users = $this->userModel->findAll();
        include __DIR__ . '/../Views/admin/user_list.php';
    }

    /**
     *  Affiche un formulaire qui gère un utilisateur spécifique
     *  @param int $userId L'ID de l'utilisateur à gérer
     *  @return void
     */
    public function manageUserForm(int $userId) 
    {
        $user = $this->userModel->find($userId);
        if ($user) {
            include __DIR__ . '/../Views/admin/manage_user.php';
        } else {
            // Handle user not found error
            echo "User not found.";
        }
    }

    /**
     *  Gère un utilisateur spécifique (ajout, modification, suppression)
     *  @param int $userId L'ID de l'utilisateur à gérer
     *  @return void
     */
    public function manageUser() 
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_POST['user_id'];
            $action = $_POST['action'];

            // Valider l'action
            if ($this->adminModel->manageUser($userId, $action)) {
                header('Location: /admin/users?success=User action successful');
                exit();
            } else {
                // Rediriger vers la liste des utilisateurs avec un message d'erreur
                header('Location: /admin/users?error=User action failed'); 
                exit();
            }
        } else {
            // Rediriger vers la liste des utilisateurs
            header('Location: /admin/users'); 
            exit();
        }
    }

    /**
     *  Affiche la liste des cryptomonnaies
     *  @return void
     */
    public function currencyList() 
    {
        $currencies = $this->currencyModel->findAll();
        include __DIR__ . '/../Views/admin/currency_list.php';
    }

    /**
     *  Affiche un formulaire pour ajouter une nouvelle cryptomonnaie
     *  @return void
     */
    public function addCurrencyForm() 
    {
        include __DIR__ . '/../Views/admin/add_currency.php';
    }

    /**
     *  Gère l'ajout d'une nouvelle cryptomonnaie
     *  @return void
     */
    public function addCurrency() 
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $symbol = $_POST['symbol'];
            $initialPrice = $_POST['initial_price'];
            $volatility = $_POST['volatility'];

            $currencyData = [
                'name' => $name,
                'symbol' => $symbol,
                'initial_price' => $initialPrice,
                'volatility' => $volatility,
            ];

            $errors = $this->validationService->validateCurrency($currencyData); // Assuming you have a validateCurrency method

            if (empty($errors)) {
                if ($this->adminModel->addCurrency($currencyData)) {
                    header('Location: /admin/currencies?success=Currency added successfully');
                    exit();
                } else {
                    header('Location: /admin/currencies/add?error=Failed to add currency');
                    exit();
                }
            } else {
                // Affiche les erreurs sur le formulaire d'ajout de cryptomonnaie
                include __DIR__ . '/../Views/admin/add_currency.php';
                exit();
            }
        } else {
            header('Location: /admin/currencies/add');
            exit();
        }
    }

    /**
     * Affiche un formulaire pour gérer les paramètres d'une application
     * @return void
     */
    public function settingsForm() 
    {
        // $settings = $this->settingModel->findAll(); 
        // include __DIR__ . '/../Views/admin/settings.php';
    }

    /**
     * Gère la mise à jour des paramètres d'une application
     * @return void
     */
    public function updateSettings() 
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Traiter et enregistrer les paramètres soumis
            foreach ($_POST as $key => $value) {
                if ($key !== 'csrf_token') { // Exclure le token CSRF
                    $this->settingModel->set($key, $value);
                }
            }
            header('Location: /admin/settings?success=Settings updated successfully');
            exit();
        } else {
            header('Location: /admin/settings');
            exit();
        }
    }

    /**
     * Affiche la liste des logs d'activité
     * @return void
     */
    public function logList() 
    {
        $logs = $this->logModel->getAll();
        include __DIR__ . '/../Views/admin/logs.php';
    }
}


?>