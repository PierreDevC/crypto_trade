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
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}