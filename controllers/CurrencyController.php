<?php
namespace App\Controllers;
/** 
 * Developpeur assigner Aboubacar 
 * Entite: Class currencyController de la couche controller
*/

use App\Models\Currency;
use App\Models\PriceHistory;

class CurrencyController {
    private $currencyModel;
    private $priceHistoryModel;


    public function __construct()
    {
        $this -> currencyModel = new CurrencyController();
        $this -> priceHistoryModel = new PriceHistory();

    }

    public function listCurrenties()
    {
        // Trycatch 
        // je veux utiliser findAll de la class currency 
        // Afficher les currency dans le view

        try {
            // Appel a la methode findAll() de la classe Currency
            $currencies = $this->currencyModel->findAll();
    
            // Affichage des donnees dans la vue
            include_once $_SERVER['DOCUMENT_ROOT'] . '/crypto_trade/views/currency/list.php';
    
        } catch (\Exception $e) {
            echo "Erreur lors de l'affichage des devises : " . $e->getMessage();
        }

    
    }

    public function viewCurrencyDetails($currencyId)
    {
        // Trycatch
        // je veux utiliser find de la class currency 
        // Afficher le currency dans le view

        try {
            // Appel a la methode find() de la classe Currency
            $currency = $this->currencyModel->find($currencyId);
    
            // Affichage des donnees dans la vue
            include_once $_SERVER['DOCUMENT_ROOT'] . '/crypto_trade/views/currency/details.php';
    
        } catch (\Exception $e) {
            echo "Erreur lors de l'affichage des détails de la devise : " . $e->getMessage();
        }

    }



}


?>