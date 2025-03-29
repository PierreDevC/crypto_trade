<?php

namespace App\Models;
/**
 * Développeur assigné(s): Aboubacar
 * Entité : Classe 'Transaction' de la couche 'Models'
 */

use PDO;
use PDOException;
use App\Config\Config;

class Transaction
{
    private int $id;
    private int $user_id;
    private int $currency_id;
    private string $type; // ENUM('buy', 'sell')
    private float $amount;
    private float $price_at_transaction;
    private string $transaction_date;

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
    // Getters
    public function getId(): int {return $this->id;}
    public function getUserId(): int {return $this->user_id;}
    public function getCurrencyId(): int {return $this->currency_id;}
    public function getType(): string {return $this->type;}
    public function getAmount(): float {return $this->amount;}
    public function getPriceAtTransaction(): float{return $this->price_at_transaction;}
    public function getTransactionDate(): string{return $this->transaction_date;}

    // Setters
    public function setId(int $id): void {$this->id = $id;}
    public function setUserId(int $user_id): void {$this->user_id = $user_id;}
    public function setCurrencyId(int $currency_id): void {$this->currency_id = $currency_id;}
    public function setType(string $type): void {$this->type = $type;}
    public function setAmount(float $amount): void {$this->amount = $amount;}
    public function setPriceAtTransaction(float $price_at_transaction): void {$this->price_at_transaction = $price_at_transaction;}
    public function setTransactionDate(string $transaction_date): void {$this->transaction_date = $transaction_date;}

    /**
     * Ajoute une nouvelle transaction dans la base de données.
     * @return bool
     */
    public function save(): bool
    {
        $stmt = $this->db->prepare("INSERT INTO transactions (user_id, currency_id, type, amount, price_at_transaction, transaction_date) VALUES (:user_id, :currency_id, :type, :amount, :price_at_transaction, NOW())");
        $stmt->bindParam(':user_id', $this->user_id, PDO::PARAM_INT);
        $stmt->bindParam(':currency_id', $this->currency_id, PDO::PARAM_INT);
        $stmt->bindParam(':type', $this->type, PDO::PARAM_STR);
        $stmt->bindParam(':amount', $this->amount, PDO::PARAM_STR);
        $stmt->bindParam(':price_at_transaction', $this->price_at_transaction, PDO::PARAM_STR);
        return $stmt->execute();
    }

    /**
     * Mettre à jour une transaction existance dans la base de données.
     * @return bool
     */
    public function update(): bool
    {
        $stmt = $this->db->prepare("UPDATE transactions SET user_id = :user_id, currency_id = :currency_id, type = :type, amount = :amount, price_at_transaction = :price_at_transaction, transaction_date = :transaction_date WHERE id = :id");
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $this->user_id, PDO::PARAM_INT);
        $stmt->bindParam(':currency_id', $this->currency_id, PDO::PARAM_INT);
        $stmt->bindParam(':type', $this->type, PDO::PARAM_STR);
        $stmt->bindParam(':amount', $this->amount, PDO::PARAM_STR);
        $stmt->bindParam(':price_at_transaction', $this->price_at_transaction, PDO::PARAM_STR);
        $stmt->bindParam(':transaction_date', $this->transaction_date, PDO::PARAM_STR);
        return $stmt->execute();
    }

    /**
     * Trouver une transaction avec son id.
     * @param int $id
     * @return ?Transaction
     */
    public function find(int $id): ?Transaction
    {
        $stmt = $this->db->prepare("SELECT * FROM transactions WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
        return $stmt->fetch();
    }

    /**
     * Trouver toutes les transactions d'un utilisateur spécifique.
     * @param int $userId
     * @return array<Transaction>
     */
    public function findAllByUserId(int $userId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM transactions WHERE user_id = :user_id ORDER BY transaction_date DESC");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, __CLASS__);
    }

    /**
     * Trouver toutes les transaction d'une certaine crypto.
     * @param int $currencyId
     * @return array<Transaction>
     */
    public function findAllByCurrencyId(int $currencyId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM transactions WHERE currency_id = :currency_id ORDER BY transaction_date DESC");
        $stmt->bindParam(':currency_id', $currencyId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, __CLASS__);
    }

    /**
     * Effacer une transaction avec son id.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM transactions WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}