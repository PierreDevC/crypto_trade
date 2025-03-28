<?php
namespace App\Models;
/**
 * Développeur assigné(s) : Pierre
 * Entité : Classe 'Currency' de la couche 'Models'
 */

use PDO;
use PDOException;
use App\Config\Config; // Importer la classe de configuration 

class Currency 
{
    /*************** Propriétés ***************/
    private int $id;
    public string $name;
    private string $symbol;
    private float $initial_price;
    private string $volatility; // low, medium or high (on utilise pas d'enum) -> validation dans ValidationService

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

    /*************** Getters ***************/
    public function getId(): int {return $this->id;}
    public function getName(): string {return $this->name;}
    public function getSymbol() : string {return $this->symbol;}
    public function getInitalPrice() : float {return $this->initial_price;}
    public function getVolatility() : string {return $this->volatility;}

    /*************** Setters ***************/
    public function setName(string $name): void {$this->name = $name;}
    public function setSymbol(string $symbol): void {$this->symbol = $symbol;}
    public function setInitialPrice(float $initialPrice): void {$this->initial_price = $initialPrice;}
    public function setVolatility(string $volatility): void {$this->volatility = $volatility;}

    /*************** Méthodes ***************/
    /**
     * Ajoute une nouvelle crypto dans la base de données
     * @return bool
     */
    public function save(): bool 
    {
        $stmt = $this->db->prepare("INSERT INTO currencies (name, symbol, initial_price, volatility) VALUES (:name, :symbol, :initial_price, :volatility)");
        $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindParam(':symbol', $this->symbol, PDO::PARAM_STR);
        $stmt->bindParam(':initial_price', $this->initial_price, PDO::PARAM_STR);
        $stmt->bindParam(':volatility', $this->volatility, PDO::PARAM_STR);
        return $stmt->execute();
    }

    /**
     * Mettre à jour une crypto dans la base de données
     * @return bool
     */
    public function update(): bool 
    {
        $stmt = $this->db->prepare("UPDATE currencies SET name = :name, symbol = :symbol, initial_price = :initial_price, volatility = :volatility WHERE id = :id");
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindParam(':symbol', $this->symbol, PDO::PARAM_STR);
        $stmt->bindParam(':initial_price', $this->initial_price, PDO::PARAM_STR);
        $stmt->bindParam(':volatility', $this->volatility, PDO::PARAM_STR);
        return $stmt->execute();
    }

    /**
     * Trouver une crypto avec son Id
     * @param int $id
     * @return ?Currency
     */
    public function find(int $id) : ?Currency
    {
        $stmt = $this->db->prepare("SELECT * FROM currencies WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
        return $stmt->fetch();
    }

    /**
     * Retourner toutes les cryptos
     * @return array<Currency>
     */
    public function findAll(): array 
    {
        $stmt = $this->db->prepare("SELECT * FROM currencies");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, __CLASS__);
    }

    /**
     * Supprimer un crypto à partir de son Id
     * @param int $id
     * @return bool
     */
    public function delete(int $id) : bool 
    {
        $stmt = $this->db->prepare("DELETE FROM currencies WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Prendre le prix actuel de la crypto (on pourrait utiliser un API call externe dans le futur)
     * @return float
     */
    public function getCurrentPrice() : float 
    {
        return $this->initial_price;
    }

    /**
     * Prix historiques de la cryptomonnaie (faire un query sur la table price_history)
     * 
     * @param int $limit Nombre de prix historique à retourner
     * @return array
     */
    public function getHistoricalPrices(int $limit = 10): array 
    {
        $stmt = $this->db->prepare("SELECT price, timestamp FROM price_history WHERE currency_id = :currency_id ORDER BY timestamp DESC LIMIT :limit");
        $stmt->bindParam(':currency_id', $this->id, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}


?> 