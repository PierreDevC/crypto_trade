<?php
namespace App\Models;
/**
 * Développeur assigné(s) : Moses
 * Entité : Classe 'Currency' de la couche Models
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
    private string $volatility;

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
    public function setSymbol(string $symbol): void{$this->symbol = $symbol;}
    public function setInitialPrice(float $initialPrice): void {$this->initial_price = $initialPrice;}
    public function setVolatility(string $volatility): void {$this->volatility = $volatility;}

    /*************** Méthodes ***************/
    public function save(): bool 
    {
        $stmt = $this->db->prepare("INSERT INTO currencies (name, symbol, initial_price, volatility) VALUES (:name, :symbol, :initial_price, :volatility)");
        $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindParam(':symbol', $this->symbol, PDO::PARAM_STR);
        $stmt->bindParam(':initial_price', $this->initial_price, PDO::PARAM_STR);
        $stmt->bindParam(':volatility', $this->volatility, PDO::PARAM_STR);
        return $stmt->execute();
    }

    // implémenter les méthodes suivantes...
    // public function update(): bool
    // public function delete(): bool
    // public function getCurrentPrice 
    // public function getHistoricalPrices
}


?> 