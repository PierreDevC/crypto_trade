<?php
namespace App\Models;
/**
 * Développeur assigné(s) : Seydina
 * Entité : Classe 'Alert' de la couche Models
 */


use PDO;
use PDOException;
use DateTime;
use App\Config\Config; // Importer la classe de configuration 

class Alert
{
    private int $id;
    private int $user_id;
    private int $currency_id;
    private string $threshold_type; // ENUM('increase', 'decrease')
    private float $threshold_value;
    private bool $is_active;

    private PDO $db;

    public function __construct()
    {
        try {
            $this->db = new PDO(
                "mysql:host=" . Config::DB_HOST . ";dbname=" . Config::DB_NAME,
                Config::DB_USER,
                Config::DB_PASS
            );
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connexion à la base de données échouée : " . $e->getMessage());
        }
    }

    /********** Getters **********/

    public function getId(): int {return $this->id;}
    public function getUserId(): int {return $this->user_id;}
    public function getCurrencyId(): int {return $this->currency_id;}
    public function getThresholdType(): string {return $this->threshold_type;}
    public function getThresholdValue(): float {return $this->threshold_value;}
    public function isActive(): bool {return $this->is_active;}

    /********** Setters **********/
    public function setId(int $id): void {$this->id = $id;}
    public function setUserId(int $user_id): void {$this->user_id = $user_id;}
    public function setCurrencyId(int $currency_id): void {$this->currency_id = $currency_id;}
    public function setThresholdType(string $threshold_type): void {$this->threshold_type = $threshold_type;}
    public function setThresholdValue(float $threshold_value): void {$this->threshold_value = $threshold_value;}
    public function setIsActive(bool $is_active): void {$this->is_active = $is_active;}

    /********** Méthodes **********/
    /**
     * Ajoute une nouvelle alerte à la base de données
     * @return bool
     */
    public function save(): bool
    {
        $stmt = $this->db->prepare("INSERT INTO alerts (user_id, currency_id, threshold_type, threshold_value, is_active) VALUES (:user_id, :currency_id, :threshold_type, :threshold_value, :is_active)");
        $stmt->bindParam(':user_id', $this->user_id, PDO::PARAM_INT);
        $stmt->bindParam(':currency_id', $this->currency_id, PDO::PARAM_INT);
        $stmt->bindParam(':threshold_type', $this->threshold_type, PDO::PARAM_STR);
        $stmt->bindParam(':threshold_value', $this->threshold_value, PDO::PARAM_STR);
        $stmt->bindParam(':is_active', $this->is_active, PDO::PARAM_BOOL);
        return $stmt->execute();
    }

    public function update(): bool
    /**
     * @Met à jour une alerte dans la base de données
     * @return bool
     */
    {
        $stmt = $this->db->prepare("UPDATE alerts SET user_id = :user_id, currency_id = :currency_id, threshold_type = :threshold_type, threshold_value = :threshold_value, is_active = :is_active WHERE id = :id");
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $this->user_id, PDO::PARAM_INT);
        $stmt->bindParam(':currency_id', $this->currency_id, PDO::PARAM_INT);
        $stmt->bindParam(':threshold_type', $this->threshold_type, PDO::PARAM_STR);
        $stmt->bindParam(':threshold_value', $this->threshold_value, PDO::PARAM_STR);
        $stmt->bindParam(':is_active', $this->is_active, PDO::PARAM_BOOL);
        return $stmt->execute();
    }

    /**
     * Trouve une alerte avec son id
     * @param int $id
     * @return ?Alert
     */
    public function find(int $id): ?Alert
    {
        $stmt = $this->db->prepare("SELECT * FROM alerts WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
        return $stmt->fetch();
    }

    /**
     * Trouve toutes les alertes pour un utilisateur spécifique
     * @param int $userId
     * @return array<Alert>
     */
    public function findAllByUserId(int $userId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM alerts WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, __CLASS__);
    }

    /**
     * Supprime une alerte à partir de son id
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM alerts WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Trouve alertes active à partir de l'id d'une crypto spécifique
     * @param int $currencyId
     * @return array<Alert>
     */
    public static function findActiveByCurrencyId(int $currencyId): array
    {
        try {
            $db = new PDO("mysql:host=" . Config::DB_HOST . ";dbname=" . Config::DB_NAME, Config::DB_USER, Config::DB_PASS);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }

        $stmt = $db->prepare("SELECT * FROM alerts WHERE currency_id = :currency_id AND is_active = TRUE");
        $stmt->bindParam(':currency_id', $currencyId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, self::class);
    }
}
