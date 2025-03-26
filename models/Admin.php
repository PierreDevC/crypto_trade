<?php
namespace App\Models;
/**
 * Développeur assignés(s) : Pierre
 * Entité : Classe 'Admin' de la couche Models
 */

use PDO;
use PDOException;
use DateTime;
use App\Config\Config; // Importer la classe de configuration

class Admin 
{
    /*************** Propriétés ***************/
    private int $id;
    private string $username;
    private string $password;
    private DateTime $created_at;
    private DateTime $updated_at;

    private PDO $db; // connexion à la base de données

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
    public function getId() : int {return $this->id;}
    public function getUsername() : string {return $this->username;}
    public function getCreatedAt() : DateTime {return $this->created_at;}
    public function getUpdatedAt() : DateTime {return $this->updated_at;}


    /*************** Setters ***************/
    public function setPassword(string $password) : void 
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    /*************** Méthodes ***************/
    public function verifyPassword(string $password) : bool
    {
        return password_verify($password, $this->password);
    }

    /** 
     * Fonction qui sauvegarde un admin dans la base de données
     * @return bool
     */
    public function save(): bool 
    {
        $stmt = $this->db->prepare("INSERT INTO admins (username, password, created_at) VALUES (:username, :password, NOW())");
        $stmt->bindParam(':username', $this->username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $this->password, PDO::PARAM_STR);
        return $stmt->execute();
    }


    /**
     * Fonction qui met à jour les information d'un admin existant
     * @return bool
     */
    public function update(): bool 
    {
        $stmt = $this->db->prepare("UPDATE admins SET username = :username, password = :password, updated_at = NOW() WHERE id = :id");
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindParam(':username', $this->username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $this->password, PDO::PARAM_STR);
        return $stmt->execute();
    }


    /**
     * Fonction qui supprime un admin
     * @return bool
     */
    public function delete(): void //sera de type bool au lieu de void
    {
        // implémenter plus tard
    }


    /**
     * Fonction qui trouve un admin avec son id
     * @param int $id
     * @return ?Admin
     */
    public function find(int $id) : ?Admin 
    {
        $stmt = $this->db->prepare("SELECT * FROM admins WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
        return $stmt->fetch();
    }


    /**
     * Fonction qui trouve un admin par son username
     * @param string $username
     * @return ?Admin
     */
    public function findByUserName(string $username) : ?Admin 
    {
        $stmt = $this->db->prepare("SELECT * FROM admins WHERE username = :username");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
        return $stmt->fetch();
    }


    /**
     * Fonction qui ajoute une nouvelle crypto sur la plateforme
     * @param array $currencyData
     * @return bool
     */
    public function addCurrency(array $currencyData) : bool
    {
        $currencyModel = new Currency();
        $currencyModel->setName($currencyData['name']);
        $currencyModel->setSymbol($currencyData['symbol']);
        $currencyModel->setInitialPrice($currencyData['initial_price']);
        $currencyModel->setVolatility($currencyData['volatility']);
        return $currencyModel->save();
    }


    /**
     * Fonction qui gère le compte d'un utilisateur (activation, désactivation, suppression)
     * @param int $userId
     * @param string $action
     * @return bool
     */
    public function manageUser(int $userId, string $action) : bool 
    {
        $userModel = new User();
        $user = $userModel->find($userId);
        if ($user) {
            switch ($action) {
                case 'activate':
                    $user->isActive(true);
                    return $user->update();
                case 'deactivate':
                    $user->isActive(false);
                    return $user->update();
                case 'delete':
                    return $user->delete();
                default:
                    return false;
            }
        }
        return false;
    }

    /**
     * Fonction qui configure la limite de transaction par jour
     * @param int $limit
     * @return bool
     */
    public function configureTransactionLimit(int $limit) : bool 
    {
        $settingModel = new Setting();
        return $settingModel->set('transaction_limit_per_day', $limit);
    }


    /**
     * Fonction qui retourne un array avec les logs
     * @return array
     */
    public function viewLogs() : array 
    {
        $logModel = new Log();
        return $logModel->getAll();
    }


    /**
     * Fonction qui génère un registration token au hasard 
     * @param int $length = 32
     * @return string
     */
    public function generateToken(int $length = 32): string 
    {
        return bin2hex(random_bytes($length / 2));
    }
}