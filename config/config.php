<?php

define('DB_HOST', 'localhost'); // Désigner le host -> Localhost
define('DB_USER', 'root');      // Désigner le username dans XAMPP (par défaut -> root )
define('DB_PASS', '');          // Vide par défaut sur XAMPP
define('DB_NAME', 'crypto_trade'); // Nom de la base de données (crypto_trade)

// Reporter les erreur de développement
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Url de base l'application
$base_url = 'http://localhost/crypto_trade/public/';
define('BASE_URL', $base_url);

?>