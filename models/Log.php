<?php
namespace App\Models;
/**
 * Développeur assigné(s) : Seydina
 * Entité : Classe 'Log' de la couche Models
 */


use PDO;
use PDOException;
use DateTime;
use App\Config\Config; // Importer la classe de configuration 

class Log 
{
    /*************** Propriétés ***************/
    private int $id;
    private int $user_id;
    private string $action;
    private DateTime $timestamp;
    private string $ip_address;
    private string $user_agent;

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


    /*************** Setters ***************/


    /*************** Méthodes ***************/

    public function getAll() : array 
    {   
        // temporaire : à compléter
        $myarray =[1,2,3];
        return $myarray;
    }
}




?>