<?php

namespace App\Config;

class Config
{
    // Configuration de la base de données
    public const DB_HOST = 'localhost';
    public const DB_USER = 'root';
    public const DB_PASS = '';
    public const DB_NAME = 'crypto_trade';

    // Configuration de la BASE_URL
    public const BASE_URL = 'http://localhost/crypto_trade/public/';

    // Configuration du error reporting
    public static function initErrorReporting(): void
    {
        // Configuration de l'affichage des erreurs
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        
        // Configuration des logs d'erreurs
        ini_set('log_errors', 1);
        ini_set('error_log', dirname(__DIR__) . '/logs/error.log');
        
        // Configuration du niveau de reporting
        error_reporting(E_ALL);
    }

    // Configuration des sessions
    public static function initSession(): void
    {
        ini_set('session.cookie_httponly', 1);
        ini_set('session.use_only_cookies', 1);
        ini_set('session.cookie_secure', APP_ENV === 'production');
    }
}

// Configuration de l'application
define('APP_NAME', 'Crypto Trade');
define('APP_ENV', 'development'); // development ou production

// Configuration des erreurs
if (APP_ENV === 'development') {
    Config::initErrorReporting();
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Initialisation des sessions
Config::initSession();