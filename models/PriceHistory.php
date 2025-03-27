<?php
namespace App\Models;
/**
 * Développeur assigné(s) : Aboubacar
 * Entité : Classe 'PriceHistory' de la couche Models
 */

use DateTime;
use PDO;
use PDOException;
use App\Config\Config; // Importer la classe de configuration 

class PriceHistory
{
    private int $id;
    private int $currency_id;
    private float $price;
    private DateTime $timestamp;

    private PDO $db; // connexion de la base de données


    /*************** Constructeur ***************/
    public function __construct()
    {
        try {
            $this->db = new PDO("mysql:host=" . Config::DB_HOST . ";dbname=" . Config::DB_NAME, Config::DB_USER, Config::DB_PASS);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
     /*************** Méthodes ***************/

     public function save(): bool {
        
     }

}









?>