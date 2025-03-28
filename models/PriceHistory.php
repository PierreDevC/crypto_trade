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

    /*************** Getters ***************/

    public function getId(): int { return $this->id;}
    public function getCurrencyId(): int {return $this->currency_id;}
    public function getPrice(): float {return $this->price;}
    public function getTimestamp() {return $this->timestamp;}


    /*************** Setters ***************/
    public function setId(int $id): void{$this->id = $id;}
    public function setCurrencyId(int $currency_id): void {$this->currency_id = $currency_id;}
    public function setPrice(float $price): void {$this->price = $price;}
    public function setTimestamp(DateTime $timestamp): void{$this->timestamp = $timestamp;}

     /*************** Méthodes ***************/

    public function save(): bool 
    {
        $stmt = $this->db->prepare("INSERT INTO price_history (currency_id, price, timestamp) VALUES (:currency_id, :price, :timestamp)");
        $stmt->bindParam(':currency_id', $this->currency_id, PDO::PARAM_INT);
        $stmt->bindParam(':price', $this->price, PDO::PARAM_STR);
        $stmt->bindParam(':timestamp', $this->timestamp, PDO::PARAM_STR);
        return $stmt->execute();
    }

    /**
     * Mettre à jour historique de prix
     */
    public function update(): bool 
    {
        $stmt = $this->db->prepare("UPDATE price_history SET currency_id = :currency_id, price = :price, timestamp = :timestamp WHERE id = :id");
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindParam(':currency_id', $this->currency_id, PDO::PARAM_INT);
        $stmt->bindParam(':price', $this->price, PDO::PARAM_STR);
        $stmt->bindParam(':timestamp', $this->timestamp, PDO::PARAM_STR);
        return $stmt->execute();
    }

    /**
     * Trouver un historique de prix avec son id
     */
    public function find(int $id): ?PriceHistory 
    {
        $stmt = $this->db->prepare("SELECT * FROM price_history WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
        return $stmt->fetch();
    }

    /**
     * Trouver l'historique de prix en utilisant l'id de cryptomonnaie
     */
    public function findByCurrencyId(int $currencyId, int $limit = 100): array
    {
        $stmt = $this->db->prepare("SELECT * FROM price_history WHERE currency_id = :currency_id ORDER BY timestamp DESC LIMIT :limit");
        $stmt->bindParam(':currency_id', $currencyId, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, __CLASS__);
    }

    /**
     * Supprimer un historique de prix avec son ID
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM price_history WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

     

}









?>