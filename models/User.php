<?php
namespace App\Models;
/**
 * Développeur assigné(s) : Pierre
 * Entité : Classe 'User' de la couche 'Models'
 */

use DateTime;
use PDO;
use PDOException;
use App\Config\Config; // Importer la classe de configuration 



class User 
{
    /*************** Propriétés ***************/
    private int $id;
    private string $username;
    private string $password;
    private string $email;
    private float $balance;
    private ?string $registration_token;
    private bool $is_active;
    private ?int $role;
    private DateTime $created_at;
    private DateTime $updated_at;
    private ?DateTime $deleted_at; // soft-delete : est null si le compte n'est pas effacé
     
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
    public function getId() : int {return $this->id;}
    public function getUsername() : string { return $this->username;}
    public function getEmail() : string {return $this->email;}
    public function getBalance() : float {return $this->balance;}
    public function getRegistrationToken(): ?string {return $this->registration_token;}
    public function isActive() : bool { return $this->is_active;}
    public function getRoleId() : ?int {return $this->role;}
    public function getCreatedAt() : DateTime {return $this->created_at;}
    public function getUpdatedAt() : DateTime {return $this->updated_at;}
    public function getDeletedAt() : ?DateTime {return $this->deleted_at;}


    /*************** Setters ***************/
    public function setUsername(string $username) : void 
    {
        $this->username = $username;
    }

    public function setEmail(string $email) : void 
    {
        $this->email = $email;
    }

    /**
     * Fonction qui set le mot de passe et le hash avant de le mettre dans la base données
     * @param string $password Le mot de passe
     * @return void
     */
    public function setPassword(string $password) : void 
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    /*************** Méthodes ***************/
    /**
     * Fonction qui vérifie si le mot de passe entré à celui qui est hashé
     * @param string $password Le mot de passe à vérifier
     * @return bool True si le mot de passe matche celui de la base de données, sinon false
     */
    public function verifyPassword(string $password) : bool 
    {
        return password_verify($password, $this->password);
    }

    /**
     * Fonction qui sauvegarde un nouvel utilisateur dans la base de données
     * @return bool True si c'est un succès, False si ça a pas réussi
     **/
    public function save() : bool 
    {
        $stmt = $this->db->prepare("INSERT INTO users (username, password, email, balance, registration_token, is_active, role, created_at) VALUES (:username, :password, :email, :balance, :registration_token, :is_active, :role, NOW())");
        $stmt->bindParam(':username', $this->username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $this->password, PDO::PARAM_STR);
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindParam(':balance', $this->balance, PDO::PARAM_STR);
        $stmt->bindParam(':registration_token', $this->registration_token, PDO::PARAM_STR);
        $stmt->bindParam(':is_active', $this->is_active, PDO::PARAM_BOOL);
        $stmt->bindParam(':role', $this->role, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Fonction qui met à jour les informations existantes d'un utilisateur dans la base de données
     * @return bool Retourne vrai en cas de succès, faux en cas d'échec.
     */
    public function update(): bool
    {
        $stmt = $this->db->prepare("UPDATE users SET username = :username, password = :password, email = :email, balance = :balance, registration_token = :registration_token, is_active = :is_active, role = :role, updated_at = NOW() WHERE id = :id");
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindParam(':username', $this->username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $this->password, PDO::PARAM_STR);
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindParam(':balance', $this->balance, PDO::PARAM_STR);
        $stmt->bindParam(':registration_token', $this->registration_token, PDO::PARAM_STR);
        $stmt->bindParam(':is_active', $this->is_active, PDO::PARAM_BOOL);
        $stmt->bindParam(':role', $this->role, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Fonction qui soft-delete un user en enregistrant le moment auquel il a été delete
     * @return bool Retourne vrai en cas de succès, faux en cas d'échec.
     */
    public function delete(): bool 
    {
        $stmt = $this->db->prepare("UPDATE users SET deleted_at = NOW() WHERE id = :id");
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Fonction qui retourne toutes les transactions de l'utilisateur actuel
     * @return array Un array avec les données de transactions
     */
    public function getTransactions(): array 
    {
        $stmt = $this->db->prepare("
            SELECT t.*, c.name AS currency_name, c.symbol AS currency_symbol
            FROM transactions t
            JOIN currencies c ON t.currency_id = c.id
            WHERE t.user_id = :user_id
            ORDER BY t.transaction_date DESC
        ");
        $stmt->bindParam(':user_id', $this->id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Fonction qui retourne les informations du portefeuille de l'utilisateur actuel
     * @return array Un array avec les données du portefeuille
     */
    function getWallet(): array 
    {
        $stmt = $this->db->prepare("
            SELECT w.*, c.name AS currency_name, c.symbol AS currency_symbol
            FROM wallets w
            JOIN currencies c ON w.currency_id = c.id
            WHERE w.user_id = :user_id
        ");
        $stmt->bindParam(':user_id', $this->id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Fonction qui vérifie si l'utilisateur a une permission spécifique selon le role assigné
     * @param string $permissionName Le nom de la permission à vérifier
     * @return bool Retourne vrai en cas de succès, faux en cas d'échec.
     */
    public function hasPermission(string $permissionName): bool 
    {
        if($this->role === null) {
            return false; // pas de role assigné
        }

        $stmt = $this->db->prepare("
            SELECT COUNT(p.id)
            FROM permissions p
            JOIN role_permissions rp ON p.id = rp.permission_id
            WHERE rp.role_id = :role_id AND p.name = :permission_name
        ");
        $stmt->bindParam(':role_id', $this->role, PDO::PARAM_INT);
        $stmt->bindParam(':permission_name', $permissionName, PDO::PARAM_STR);
        $stmt->execute();
        return (bool) $stmt->fetchColumn();
    }

    /**
     * Fonction qui trouve le user selon l'id entré
     * hydratation de l'objet => Peuple les information de l'instance actuelle de l'objet avec les informations trouvées dans la base de données ($this)
     * @param int $id L'id de l'utilisateur à trouver
     * @return ?User L'object User, si il est trouvé, sinon retourne null (ternary operator)
     */
    public function find(int $id): ?User 
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id AND deleted_at IS NULL");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_INTO, $this); // hydrater l'objet actuel
        $user = $stmt->fetch();
        return $user ? $this : null;
    }

    /**
     * Fonction qui trouve le user selon le username entré
     * hydratation de l'objet => Peuple les information de l'instance actuelle de l'objet avec les informations trouvées dans la base de données ($this)
     * @param string $username Le nom d'utilisateur de l'utilisateur à trouver
     * @return ?User L'object User, si il est trouvé, sinon retourne null (ternary operator)
     */
    public function findByUsername(string $username): ?User
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username AND deleted_at IS NULL");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_INTO, $this); // hydratation de l'objet 
        $user = $stmt->fetch();
        return $user ? $this : null;
    }

    /**
     * Fonction qui trouve le user selon l'email entré
     * @param string $email L'email de l'utilisateur à trouver
     * @return ?User L'object User, si il est trouvé, sinon retourne null (ternary operator)
     */
    public function findByEmail(string $email): ?User
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email AND deleted_at IS NULL");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_INTO, $this);
        $user = $stmt->fetch();
        return $user ? $this : null;
    }

    /**
     * Fonction qui trouve le user selon le registration token
     *
     * @param string $token Le registration token.
     * @return ?User L'object User, si il est trouvé, sinon retourne null (ternary operator)
     */
    public function findByRegistrationToken(string $token): ?User
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE registration_token = :token AND deleted_at IS NULL");
        $stmt->bindParam(':token', $token, PDO::PARAM_STR);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_INTO, $this);
        $user = $stmt->fetch();
        return $user ? $this : null;
    }
}
?>