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
    /*************** Propriétés ***************/
     public int $role_id;
     public int $permission_id;
 
     private PDO $db;
    
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
      * Fonction qui sauvegarde une nouvelle role-permission dans la base de données
      * @return bool
      */
     public function save(): bool
     {
         $stmt = $this->db->prepare("INSERT INTO role_permissions (role_id, permission_id) VALUES (:role_id, :permission_id)");
         $stmt->bindParam(':role_id', $this->role_id, PDO::PARAM_INT);
         $stmt->bindParam(':permission_id', $this->permission_id, PDO::PARAM_INT);
         return $stmt->execute();
     }
 
     /**
      * Supprime une association spécifique de role-permission
      * @param int $roleId
      * @param int $permissionId
      * @return bool
      */
     public static function delete(int $roleId, int $permissionId): bool
     {
         try {
             $db = new PDO("mysql:host=" . Config::DB_HOST . ";dbname=" . Config::DB_NAME, Config::DB_USER, Config::DB_PASS);
             $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         } catch (PDOException $e) {
             die("Database connection failed: " . $e->getMessage());
         }
 
         $stmt = $db->prepare("DELETE FROM role_permissions WHERE role_id = :role_id AND permission_id = :permission_id");
         $stmt->bindParam(':role_id', $roleId, PDO::PARAM_INT);
         $stmt->bindParam(':permission_id', $permissionId, PDO::PARAM_INT);
         return $stmt->execute();
     }
 
     /**
      * Supprime toutes les permission associées à un role spécifique
      * @param int $roleId
      * @return bool
      */
     public static function deleteByRoleId(int $roleId): bool
     {
         try {
             $db = new PDO("mysql:host=" . Config::DB_HOST . ";dbname=" . Config::DB_NAME, Config::DB_USER, Config::DB_PASS);
             $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         } catch (PDOException $e) {
             die("Database connection failed: " . $e->getMessage());
         }
 
         $stmt = $db->prepare("DELETE FROM role_permissions WHERE role_id = :role_id");
         $stmt->bindParam(':role_id', $roleId, PDO::PARAM_INT);
         return $stmt->execute();
     }
 
     /**
      * Supprime tous les roles associées à une permission spécifique
      * @param int $permissionId
      * @return bool
      */
     public static function deleteByPermissionId(int $permissionId): bool
     {
         try {
             $db = new PDO("mysql:host=" . Config::DB_HOST . ";dbname=" . Config::DB_NAME, Config::DB_USER, Config::DB_PASS);
             $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         } catch (PDOException $e) {
             die("Database connection failed: " . $e->getMessage());
         }
 
         $stmt = $db->prepare("DELETE FROM role_permissions WHERE permission_id = :permission_id");
         $stmt->bindParam(':permission_id', $permissionId, PDO::PARAM_INT);
         return $stmt->execute();
     }
 
     /**
      * Trouve tous les permission ID associées à un role ID
      * @param int $roleId
      * @return array
      */
     public static function findPermissionIdsByRoleId(int $roleId): array
     {
         try {
             $db = new PDO("mysql:host=" . Config::DB_HOST . ";dbname=" . Config::DB_NAME, Config::DB_USER, Config::DB_PASS);
             $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         } catch (PDOException $e) {
             die("Database connection failed: " . $e->getMessage());
         }
 
         $stmt = $db->prepare("SELECT permission_id FROM role_permissions WHERE role_id = :role_id");
         $stmt->bindParam(':role_id', $roleId, PDO::PARAM_INT);
         $stmt->execute();
         return $stmt->fetchAll(PDO::FETCH_COLUMN);
     }
 
     /**
      * Trouve tous les role ID associées à un permission ID
      * @param int $permissionId
      * @return array
      */
     public static function findRoleIdsByPermissionId(int $permissionId): array
     {
         try {
             $db = new PDO("mysql:host=" . Config::DB_HOST . ";dbname=" . Config::DB_NAME, Config::DB_USER, Config::DB_PASS);
             $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         } catch (PDOException $e) {
             die("Database connection failed: " . $e->getMessage());
         }
 
         $stmt = $db->prepare("SELECT role_id FROM role_permissions WHERE permission_id = :permission_id");
         $stmt->bindParam(':permission_id', $permissionId, PDO::PARAM_INT);
         $stmt->execute();
         return $stmt->fetchAll(PDO::FETCH_COLUMN);
     }
 }

?>