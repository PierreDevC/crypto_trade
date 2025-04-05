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

    }

    public function viewCurrencyDetails($currencyId)
    {
        // Trycatch
        // je veux utiliser find de la class currency 
        // Afficher le currency dans le view


    }


}










?>