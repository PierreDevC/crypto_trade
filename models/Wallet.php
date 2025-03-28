<?php

namespace App\Models;

use PDO;
use PDOException;
use App\Config\Config;

class Wallet
{
    private PDO $db; // Connexion à la base de données

    private int $id; // Identifiant unique du portefeuille
    private int $user_id; // Identifiant de l'utilisateur
    private int $currency_id; // Identifiant de la devise
    private float $quantity; // Quantité de crypto-monnaie détenue

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

    /*************** Getters et Setters ***************/

    // Retourne l'identifiant du portefeuille
    public function getId(): int
    {
        return $this->id;
    }

    // Définit l'identifiant de l'utilisateur
    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    // Définit l'identifiant de la devise
    public function setCurrencyId(int $currency_id): void
    {
        $this->currency_id = $currency_id;
    }

    // Définit la quantité de crypto-monnaie détenue
    public function setQuantity(float $quantity): void
    {
        $this->quantity = $quantity;
    }

    /*************** Sauvegarde en base de données ***************/
    public function save(): bool
    {
        // Prépare la requête SQL pour insérer un nouveau portefeuille
        $sql = "INSERT INTO wallets (user_id, currency_id, quantity) VALUES (:user_id, :currency_id, :quantity)";
        $stmt = $this->db->prepare($sql);
        
        // Exécute la requête avec les valeurs associées
        return $stmt->execute([
            ':user_id' => $this->user_id,
            ':currency_id' => $this->currency_id,
            ':quantity' => $this->quantity
        ]);
    }

    /*************** Mise à jour en base de données ***************/
    public function update(): bool
    {
        // Prépare la requête SQL pour mettre à jour un portefeuille existant
        $sql = "UPDATE wallets SET quantity = :quantity WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        
        // Exécute la requête avec les nouvelles valeurs
        return $stmt->execute([
            ':quantity' => $this->quantity,
            ':id' => $this->id
        ]);
    }
}

?>
