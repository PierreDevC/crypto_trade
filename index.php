<?php
// Définition des constantes
define('ROOT_PATH', dirname(__FILE__));
define('BASE_URL', 'http://localhost/crypto_trade');

// Chargement de l'autoloader de Composer
require_once ROOT_PATH . '/vendor/autoload.php';

// Chargement de la configuration
require_once ROOT_PATH . '/config/config.php';

// Démarrage de la session après la configuration
session_start();

// Test de la configuration des erreurs
$undefined_variable; // Cette ligne générera une erreur

// Fonction de routage simple
function route($path) {
    switch ($path) {
        case '/':
        case '':
            require_once ROOT_PATH . '/views/layout/main.php';
            break;
            
        case '/login':
            require_once ROOT_PATH . '/views/auth/login.php';
            break;
            
        case '/register':
            require_once ROOT_PATH . '/views/auth/register.php';
            break;
            
        case '/about':
            require_once ROOT_PATH . '/views/layout/about.php';
            break;
            
        default:
            // Page 404
            header("HTTP/1.0 404 Not Found");
            require_once ROOT_PATH . '/views/errors/404.php';
            break;
    }
}

// Récupération du chemin de l'URL
$request_uri = $_SERVER['REQUEST_URI'];
$base_path = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
$path = str_replace($base_path, '', $request_uri);
$path = strtok($path, '?'); // Supprime les paramètres de requête

// Routage de la requête
route($path);
