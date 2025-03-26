<?php
namespace App\Models;
/**
 * Développeur assignés(s) : Pierre
 * Entité : Classe Role de la couche Models
 */

use PDO;
use PDOException;
use App\Config\Config; // Importer la classe de configuration


class Role 
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

    /*************** Méthodes ***************/

    /**
     * Fonction qui ajoute un role dans la base de données
     * @return bool
     */
    public function save(): bool
    {
        $stmt = $this->db->prepare("INSERT INTO roles (name) VALUES (:name)");
        $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
        return $stmt->execute();
    }

    /**
     * Fonction qui met à jour les information d'un role existant
     * @return bool
     */
    public function update(): bool 
    {
        $stmt = $this->db->prepare("UPDATE roles SET name = :name WHERE id = :id");
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
        return $stmt->execute();
    }

    /**
     * Fonction qui supprime un role (seulement si aucun utilisateur a ce role assigné)
     * @return bool
     */
    public function delete(int $id): bool
    {
        // Vérifie si un utilisateur a ce role
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE role = :role_id");
        $stmt->bindParam(':role_id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $userCount = $stmt->fetchColumn();

        if ($userCount > 0) {
            // Prévenir la suppression si un utilisateur a le role que l'on veut supprimer
            return false;
        }

        $stmt = $this->db->prepare("DELETE FROM roles WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Fonction qui affiche toutes les permission associées à ce role
     * @return array Un array avec les noms des permissions
     */
    public function getPermissions(): array
    {
        $stmt = $this->db->prepare("
            SELECT p.name
            FROM permissions p
            JOIN role_permissions rp ON p.id = rp.permission_id
            WHERE rp.role_id = :role_id
        ");
        $stmt->bindParam(':role_id', $this->id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN); // Fetcher seulement la colonne 'nom'
        
    }

    /**
     * Fonction qui trouve un role à partir de son ID
     * @param int $id
     *@return ?Role
     */
    public function find(int $id): ?Role 
    {
        $stmt = $this->db->prepare("SELECT * FROM roles WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
        return $stmt->fetch();
    }

    /**
     * Fonction qui trouve un role à partir de son nom
     * @param string $name
     * @return ?Role
     */
    public function findByName(string $name): ?Role 
    {
        $stmt = $this->db->prepare("SELECT * FROM roles WHERE name = :name");
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
        return $stmt->fetch();
    }
}