<?php
namespace App\Models;
/**
 * Développeur assigné(s) : Pierre
 * Entité : Classe 'Permission' de la couche Models
 */

use PDO;
use PDOException;
use App\Config\Config;


class Permission 
{
    /*************** Propriétés ***************/
    private int $id;
    private string $name;

    private PDO $db; // connexion à la base de données

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
    
    /*************** Les getters ***************/
    public function getId(): int {return $this->id;}
    public function getName(): string {return $this->name;}

    /**
     * Fonction qui sauvegarde une nouvelle permission dans la base de données
     * @return bool 
     */
    public function save() : bool 
    {
        $stmt = $this->db->prepare("INSERT INTO permissions (name) VALUES (:name)");
        $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
        return $stmt->execute();
    }

    /**
     * Fonction qui met à jour les informations d'une permission existante
     * @return bool
     */
    public function update() : bool 
    {
        $stmt = $this->db->prepare("UPDATE permissions SET name = :name WHERE id = :id");
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
        return $stmt->execute();
    }

    /**
     * Fonction qui supprime une permission (seulement si aucun utilisateur a cette permission assignée)
     * @return bool
     */
    public function delete(int $id) : bool 
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE permission = :permission_id");
        $stmt->bindParam(':permission_id', $id, PDO::PARAM_INT);
        $userCount = $stmt->fetchColumn();

        if($userCount > 0) {return false;} // prévenir suppression

        $stmt = $this->db->prepare("DELETE FROM permissions WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Fonction qui trouve une permission avec son id
     * @param int $id
     * @return ?Permission
     */
    public function find(int $id) : ?Permission 
    {
        $stmt = $this->db->prepare("SELECT * FROM permissions WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
        return $stmt->fetch();
    }
    
    /**
     * Fonction qui trouve une permission avec son nom
     * @param string $name
     * @return ?Permission
     */
    public function findByName(string $name) : ?Permission 
    {
        $stmt = $this->db->prepare("SELECT * FROM permissions WHERE name = :name");
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
        return $stmt->fetch();
    }
}
?>