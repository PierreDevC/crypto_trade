<?php
use PDO;
use App\Config\Config; // Importer la classe de configuration 
require_once __DIR__ . '/../config/Config.php';   // référence à la connexion de la base de données


class User {
    /*************** Propriétés ***************/
    private int $id;
    private string $username;
    private string $password;
    private string $email;
    private float $balance;
    private ?string $registration_token;
    private bool $is_active;
    private ?int $role;
    private DateTime $createdAt;
    private DateTime $updatedAt;
    private DateTime $deletedAt; // soft-delete
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

    
    /*************** Les getters ***************/
    public function getId() : int {return $this->id;}
    public function getUsername() : string { return $this->username;}
    public function getEmail() : string {return $this->email;}
    public function getBalance() : float {return $this->balance;}
    public function getRegistrationToken(): ?string {return $this->registration_token;}
    public function isActive() : bool { return $this->is_active;}
    public function getRoleId() : ?int {return $this->role;}
    public function getCreatedAt() : DateTime {return $this->createdAt;}
    public function getUpdatedAt() : DateTime {return $this->updatedAt;}
    public function getDeletedAt() : DateTime {return $this->deletedAt;}


    /*************** Les setters ***************/
    public function setUsername(string $username) : void {
        $this->username = $username;
    }

    public function setEmail(string $email) : void {
        $this->email = $email;
    }

    /*************** Méthodes ***************/

    /**
     * Set le mot de passe, le hash avant de le mettre dans la base données
     * @param string $password Le mot de passe
     * @return void
     */
    public function setPassword(string $password) : void {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Vérifie si le mot de passe entré à celui qui est hashé
     * @param string $password Le mot de passe à vérifier
     * @return bool True si le mot de passe matche celui de la base de données, sinon false
     */
    public function verifyPassword(string $password) : bool {
        return password_verify($password, $this->password);
    }

    /**
     * Sauvegarde un nouvel utilisateur dans la base de données
     * @return bool True si c'est un succès, False si ça a pas réussi
     **/
    public function save() : bool {
        $stmt = $this->db->prepare("INSERT INTO users (username, password, email, balance, registration_token, is_active, role, created_at) VALUES (:username, :password, :email, :balance, :registration_token, :is_active, :role, NOW())");
        $stmt->bindParam(':username', $this->username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $this->username, PDO::PARAM_STR);
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindParam(':balance', $this->balance, PDO::PARAM_STR);
        $stmt->bindParam(':registration_token', $this->registration_token, PDO::PARAM_STR);
        $stmt->bindParam(':is_active', $this->is_active, PDO::PARAM_STR);
        $stmt->bindParam(':role', $this->role, PDO::PARAM_INT);
        return $stmt->execute();
    }
}


?>