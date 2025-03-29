<?php

/**
 * Développeur assigné(s) : Pierre
 * Entité : Classe 'Currency' de la couche 'Models'
 */

namespace App\Models;

use PDO;
use PDOException;
use App\Config\Config; 

class Setting
{
    private int $id;
    private string $key;
    private string $value;

    private PDO $db;

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
    public function getId(): int{return $this->id;}
    public function getKey(): string {return $this->key;}
    public function getValue(): string {return $this->value;}

    /*************** Setters ***************/
    public function setId(int $id): void{$this->id = $id;}
    public function setKey(string $key): void{$this->key = $key;}
    public function setValue(string $value): void {$this->value = $value;}
    
        /**
     * Met à jour un setting dans la base de données.
     *
     * @param string $key The setting key.
     * @param mixed $value The setting value.
     * @return bool True on success, false on failure.
     */
    public function set(string $key, $value): bool
    {
        $query = "UPDATE settings SET value = :value WHERE key = :key";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':key', $key);
        $stmt->bindParam(':value', $value);

        return $stmt->execute();
    }
    /**
     * Ajouter un nouveau setting à la base de données.
     *
     * @return bool
     */
    public function save(): bool
    {
        $stmt = $this->db->prepare("INSERT INTO settings (`key`, `value`) VALUES (:key, :value)");
        $stmt->bindParam(':key', $this->key, PDO::PARAM_STR);
        $stmt->bindParam(':value', $this->value, PDO::PARAM_STR);
        return $stmt->execute();
    }

    /**
     * Modifier un setting dans la base de données.
     *
     * @return bool
     */
    public function update(): bool
    {
        $stmt = $this->db->prepare("UPDATE settings SET `value` = :value WHERE id = :id");
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindParam(':value', $this->value, PDO::PARAM_STR);
        return $stmt->execute();
    }

    /**
     * Trouver un setting avec son id.
     *
     * @param int $id
     * @return ?Setting
     */
    public function find(int $id): ?Setting
    {
        $stmt = $this->db->prepare("SELECT * FROM settings WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
        return $stmt->fetch();
    }

    /**
     * Trouver un setting avec sa clé.
     *
     * @param string $key
     * @return ?Setting
     */
    public static function findByKey(string $key): ?Setting
    {
        try {
            $db = new PDO("mysql:host=" . Config::DB_HOST . ";dbname=" . Config::DB_NAME, Config::DB_USER, Config::DB_PASS);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }

        $stmt = $db->prepare("SELECT * FROM settings WHERE `key` = :key");
        $stmt->bindParam(':key', $key, PDO::PARAM_STR);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        return $stmt->fetch();
    }

    /**
     * Mettre à jour la valeur d'un setting avec sa clé.
     *
     * @param string $key
     * @param string $value
     * @return bool
     */
    public static function updateValueByKey(string $key, string $value): bool
    {
        try {
            $db = new PDO("mysql:host=" . Config::DB_HOST . ";dbname=" . Config::DB_NAME, Config::DB_USER, Config::DB_PASS);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }

        $stmt = $db->prepare("UPDATE settings SET `value` = :value WHERE `key` = :key");
        $stmt->bindParam(':key', $key, PDO::PARAM_STR);
        $stmt->bindParam(':value', $value, PDO::PARAM_STR);
        return $stmt->execute();
    }

    /**
     * Supprimer un setting à partir de son ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM settings WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}