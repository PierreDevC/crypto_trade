<?php

namespace App\Config;

class Config
{
    // Database configuration
    public const DB_HOST = 'localhost';
    public const DB_USER = 'root';
    public const DB_PASS = '';
    public const DB_NAME = 'crypto_trade';

    // Base URL configuration
    public const BASE_URL = 'http://localhost/crypto_trade/public/';

    // Error reporting configuration
    public static function initErrorReporting(): void
    {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}