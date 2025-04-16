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

// Fonction de routage simple
function route($path)
{
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

        case '/market':
            $controller = new \App\Controllers\MarketController();
            $controller->index();
            break;

        case '/market/prices':
            $controller = new \App\Controllers\MarketController();
            echo $controller->getRealTimePrices();
            break;

        case (preg_match('#^/market/history/(\d+)/(daily|weekly|monthly)$#', $path, $matches) ? true : false):
            $controller = new \App\Controllers\MarketController();
            $currencyId = (int) $matches[1];
            $period = $matches[2];
            echo $controller->getPriceHistory($currencyId, $period);
            break;

        default:
            header("HTTP/1.0 404 Not Found");
            require_once ROOT_PATH . '/views/errors/404.php';
            break;
    }
}

// Récupération du chemin de l'URL
$request_uri = $_SERVER['REQUEST_URI'];
$base_path = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
$path = str_replace($base_path, '', $request_uri);
$path = strtok($path, '?'); // Supprime les paramètres GET

// Appel de la fonction de routage
route($path);
