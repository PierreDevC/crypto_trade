<?php

namespace App\Models;

use PDO;
use PDOException;
use App\Config\Config;

class Log
{
    private int $id;
    private ?int $user_id; // Peut être null pour des logs de système
    private string $action;
    private string $timestamp;
    private ?string $ip_address;
    private ?string $user_agent;

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

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    /*************** Getters ***************/
    public function getAction(): string{return $this->action;}
    public function getTimestamp(): string {return $this->timestamp;}
    public function getIpAddress(): ?string {return $this->ip_address;}
    public function getUserAgent(): ?string {return $this->user_agent;}

    /*************** Setters ***************/
    public function setId(int $id): void {$this->id = $id;}
    public function setUserId(?int $user_id): void {$this->user_id = $user_id;}
    public function setAction(string $action): void {$this->action = $action;}
    public function setTimestamp(string $timestamp): void {$this->timestamp = $timestamp;}
    public function setIpAddress(?string $ip_address): void {$this->ip_address = $ip_address;}
    public function setUserAgent(?string $user_agent): void {$this->user_agent = $user_agent;}

    /*************** Méthodes ***************/

    /**
     * Ajouter un nouveau log dans la base de données.
     *
     * @return bool
     */
    public function save(): bool
    {
        $stmt = $this->db->prepare("INSERT INTO logs (user_id, action, timestamp, ip_address, user_agent) VALUES (:user_id, :action, NOW(), :ip_address, :user_agent)");
        $stmt->bindParam(':user_id', $this->user_id, PDO::PARAM_INT);
        $stmt->bindParam(':action', $this->action, PDO::PARAM_STR);
        $stmt->bindParam(':ip_address', $this->ip_address, PDO::PARAM_STR);
        $stmt->bindParam(':user_agent', $this->user_agent, PDO::PARAM_STR);
        return $stmt->execute();
    }

    /**
     * Trouver un log avec son id.
     *
     * @param int $id
     * @return ?Log
     */
    public function find(int $id): ?Log
    {
        $stmt = $this->db->prepare("SELECT * FROM logs WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
        return $stmt->fetch();
    }

    /**
     * Retourner tous les logs, ordonnés par timestamp.
     *
     * @return array<Log>
     */
    public function getAll(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM logs ORDER BY timestamp DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, __CLASS__);
    }

    /**
     * Trouver tous les logs d'un utilisateur, ordonnés par timestamp.
     *
     * @param int $userId
     * @return array<Log>
     */
    public function findAllByUserId(int $userId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM logs WHERE user_id = :user_id ORDER BY timestamp DESC");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, __CLASS__);
    }

    /**
     * Effacer un log à partir de son ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM logs WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}