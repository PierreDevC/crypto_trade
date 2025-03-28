<?php

namespace App\Models;
/**
 * Développeur assigné(s): Moses
 * Entité : Classe 'Wallet' de la couche 'Models'
 */


use PDO;
use PDOException;
use App\Config\Config;

class Wallet
{
    

    private int $id; // Identifiant unique du portefeuille
    private int $user_id; // Identifiant de l'utilisateur
    private int $currency_id; // Identifiant de la devise
    private float $quantity; // Quantité de crypto-monnaie détenue

    private PDO $db; // Connexion à la base de données

    /*************** Constructeur ***************/
    public function __construct()
    {
        try {
            // Connexion à la base de données avec PDO
            $this->db = new PDO("mysql:host=" . Config::DB_HOST . ";dbname=" . Config::DB_NAME, Config::DB_USER, Config::DB_PASS);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Affichage d'un message d'erreur en cas d'échec de connexion
            die("Database connection failed: " . $e->getMessage());
        }
    }

    /*************** Getters ***************/

    // Retourne l'identifiant du portefeuille
    public function getId(): int {return $this->id;}
    public function getUserId(): int {return $this->user_id;}
    public function getCurrencyId(): int {return $this->currency_id;}
    public function getQuantity(): float {return $this->quantity;}

    /*************** Setters ***************/
    public function setUserId(int $user_id): void{$this->user_id = $user_id;}
    public function setCurrencyId(int $currency_id): void{$this->currency_id = $currency_id;}
    public function setQuantity(float $quantity): void{$this->quantity = $quantity;}

    /*************** Méthodes ***************/


    /*************** Sauvegarde en base de données ***************/
    public function save(): bool
    {
        $stmt = $this->db->prepare("INSERT INTO wallets (user_id, currency_id, quantity) VALUES (:user_id, :currency_id, :quantity)");
        $stmt->bindParam(':user_id', $this->user_id, PDO::PARAM_INT);
        $stmt->bindParam(':currency_id', $this->currency_id, PDO::PARAM_INT);
        $stmt->bindParam(':quantity', $this->quantity, PDO::PARAM_STR);
        return $stmt->execute();
    }

    /*************** Mise à jour en base de données ***************/
    public function update(): bool
    {
        $stmt = $this->db->prepare("UPDATE wallets SET quantity = :quantity WHERE id = :id");
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindParam(':quantity', $this->quantity, PDO::PARAM_STR);
        return $stmt->execute();
    }

    /*************** Recherche en base de données ***************/
    public function find(int $id): ?Wallet 
    {
        $stmt = $this->db->prepare("SELECT * FROM wallets WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
        return $stmt->fetch();
    }

    /*************** Trouver le wallet selon le nom d'utilisateur et la crypto ***************/
    public static function findByUserAndCurrency(int $user_id, int $currency_id): ?Wallet 
    {
        try {
            $db = new PDO("mysql:host=" . Config::DB_HOST . ";dbname=" . Config::DB_NAME, Config::DB_USER, Config::DB_PASS);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }

        $stmt = $db->prepare("SELECT * FROM wallets WHERE user_id = :user_id AND currency_id = :currency_id");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':currency_id', $currencyId, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        return $stmt->fetch();
    }

    /*************** Trouver tous les wallets d'un utilisateur ***************/
    public function findAllByUserId(int $userId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM wallets WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, __CLASS__);
    }

    /*************** Suppression d'un portefeuille avec son ID ****************/
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM wallets WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /*************** Augmenter la quantité d'une crypto dans le portefeuille ***************/
    public function increaseQuantity(float $amount): bool
    {
        $this->quantity += $amount;
        return $this->update();
    }

    /*************** Réduire la quantité d'une crypto dans le portefeuille ***************/
    public function decreaseQuantity(float $amount): bool
    {
        if ($this->quantity >= $amount) {
            $this->quantity -= $amount;
            return $this->update();
        }
        return false; // À ajouter :  Afficher une exception si les fonds sont insuffisants
    }
}

?>
