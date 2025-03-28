<?php
namespace App\Services;
/**
 * Développeur assigné(s): Pierre
 * Entité : Classe 'ValidationService' de la couche 'Service'
 */

class ValidationService 
{   
    /**
     * Valide l'input de l'utilisateur avec les paramètres suivants... et retourne un array avec les messages d'erreur
     * @param string $username
     * @param string $email
     * @param string $password
     * @param string $confirmPassword
     * @return array Un array avec les messages d'erreur
     */
    public function validateRegistration(string $username, string $email, string $password, string $confirmPassword) : array 
    {
        $errors = [];

        if (!$this->isNonEmptyString($username)) {
            $errors['username'] = 'Nom utilisateur requis';
        } elseif (strlen($username) < 3 || strlen($username) > 50) {
            $errors['username'] = 'Le nom utilisateur doit être en 3 et 50 caractères.';
        } 

        if (!$this->isNonEmptyString($email)) {
            $errors['email'] = 'Email requis';
        } elseif (!$this->isValidEmail($email)) {
            $errors['email'] = 'Format email invalide';
        }

        if (!$this->isNonEmptyString($password)) {
            $errors['password'] = 'Mot de passe requis';
        } elseif (!$this->isValidPassword($password)) {
            $errors['password'] = 'Le mot de passe doit contenir au moins 8 caractères et inclure au minimum une lettre majuscule, une lettre minuscule et un chiffre.';
        }

        if (!$this->isNonEmptyString($confirmPassword)) {
            $errors['confirm_password'] = 'Confirmation de mot de passe requis';
        } elseif (!$this->arePasswordsMatch($password, $confirmPassword)) {
            $errors['confirm_password'] = 'Les mots de passe ne matchent pas';
        }
        return $errors;
    }

    /**
     * Valide l'input pour la mise à jour du profil
     * 
     * @param string $username
     * @param string $email
     * @return array Un array avec les messages d'erreur
     */
    public function validateProfileUpdate(string $username, string $email): array 
    {
        $errors = [];

        if (!$this->isNonEmptyString($username)) {
            $errors['username'] = 'Username is required.';
        } elseif (strlen($username) < 3 || strlen($username) > 50) {
            $errors['username'] = 'Username must be between 3 and 50 characters.';
        }

        if (!$this->isNonEmptyString($email)) {
            $errors['email'] = 'Email is required.';
        } elseif (!$this->isValidEmail($email)) {
            $errors['email'] = 'Invalid email format.';
        }

        return $errors;
    }

    /**
     * Fonction qui valide la cryptomonnaie avant l'ajout
     * @param array $currencyData Un tableau associatif containant 'name', 'symbol', 'initial_price', 'volatility'.
     * @return array Retourne un array avec les messages d'erreurs
     */
    public function validateCurrency(array $currencyData): array 
    {
        $errors=[];

        if (!isset($currencyData['name']) || !$this->isNonEmptyString($currencyData['name'])) {
            $errors['name'] = 'Nom de la cryptomonnaie requise.';
        } elseif (strlen($currencyData['name']) > 50) {
            $errors['name'] = 'Le nom de la cryptomonnaie ne peut pas excéder 50 caractères';
        }

        if (!isset($currencyData['symbol']) || !$this->isNonEmptyString($currencyData['symbol'])) {
            $errors['symbol'] = 'Symbole de la cryptomonnaie requis.';
        } elseif (strlen($currencyData['symbol']) > 10) {
            $errors['symbol'] = 'Le symbole de la cryptomonnaie ne peut pas excéder 10 caractères.';
        }

        if (!isset($currencyData['initial_price']) || !$this->isNumeric($currencyData['initial_price'])) {
            $errors['initial_price'] = 'Prix intial doit être un nombre valide';
        } elseif ($currencyData['initial_price'] <= 0) {
            $errors['initial_price'] = 'Le prix initial doit être plus grand que zéro';
        }

        if (!isset($currencyData['volatility']) || !in_array($currencyData['volatility'], ['low', 'medium', 'high'])) {
            $errors['volatility'] = 'Volatilité doit être soit: low, medium, high.';
        }

        return $errors;
    }

    /**
     * Fonction qui valide l'input de la transaction
     * @param array $transactionData Un tableau associatif containant les détails de la transaction (e.g., 'currency_id', 'amount', 'type').
     * @return array Un array avec des messages d'erreurs
     */
    public function validateTransaction (array $transactionData): array 
    {
        $errors=[];

        if (!isset($transactionData['currency_id']) || !$this->isNumeric($transactionData['currency_id']) || $transactionData['currency_id'] <= 0) {
            $errors['currency_id'] = 'Selection de cryptomonnaie invalide';
        }

        if (!isset($transactionData['amount']) || !$this->isNumeric($transactionData['amount']) || $transactionData['amount'] <= 0) {
            $errors['amount'] = 'Le montant de la transaction doit excéder zéro';
        }

        if (!isset($transactionData['type']) || !in_array($transactionData['type'], ['buy', 'sell'])) {
            $errors['type'] = 'Type de transaction invalide';
        }
        
        return $errors;
    }

    /**
     * Helper method qui check si un email est valide
     * @param string $email
     * @return bool
     */
    private function isValidEmail(string $email): bool 
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Helper method qui check si un mot de passe répond à certains critères
     * (Example: au moins 8 caractères, une majuscule, une minuscule, un nombre)
     * @param string $password
     * @return bool
     */
    private function isValidPassword(string $password): bool 
    {
        return strlen($password) >= 8 && // au moins 8 caractères
        preg_match('/[A-Z]/', $password) && // une majuscule
        preg_match('/[a-z]/', $password) && // une minuscule
        preg_match('//', $password); // nombres
    }

    /**
     * Helper method qui check si un string est pas empty
     * @param string $value
     * @return bool
     */
    private function isNonEmptyString(string $value): bool 
    {
        return !empty(trim($value));
    }


    /**
     * Helper method qui check si une valeur est un nombre
     * @param mixed $value
     * @return bool
     */
    private function isNumeric(mixed $value): bool 
    {
        return is_numeric($value);
    }

    /**
     * Helper method qui check si deux mots de passe matchent
     * @param string $password
     * @param string $confirmPassword
     * @return bool
     */
    private function arePasswordsMatch(string $password, string $confirmPassword): bool
    {
        return $password === $confirmPassword;
    }
}

?>