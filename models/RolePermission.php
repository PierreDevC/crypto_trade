<?php
namespace App\Models;
/**
 * Développeur assigné(s) : Pierre
 * Entité : Classe 'RolePermission' de la couche Models
 */

 use PDO;
 use PDOException;
 use App\Config\Config; // Importer la classe de configuration 

 class RolePermission 
 {
    private int $role_id;
    private int $permission_id;

    private PDO $db; // variable pour la connexion de la base de données

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

    //save
    //delete
    //deleteByRoleId
    //public static function findPermissionIdsByRoleId(int $roleId): array
    //public static function findPermissionIdsByRoleId(int $roleId): array
    //public static function findRoleIdsByPermissionId(int $permissionId): array
 }

?>