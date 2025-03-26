<?php
namespace App\Models;

/**
 * Développeur assigné(s) : Pierre
 * Entité : Classe 'User' de la couche Models
 */



use PDO;
use PDOException;
use App\Config\Config; // Importer la classe de configuration 

class Setting 
{
    /*************** Propriétés ***************/
    private int $id;
    private string $name;
    private string $value;

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

    /*************** Getters ***************/
    //...


    /*************** Setters ***************/

    public function set() : bool
    {   
        // à implémenter...
        return True;
    }
}