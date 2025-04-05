<?php
namespace App\Controllers;
/** 
 * Developpeur assigner Aboubacar 
 * Entite: Class MarketController de la couche controller
*/

use App\Models\Currency;
use App\Models\PriceHistory;

class MarketController {
    private $currencyModel;
    private $priceHistoryModel;


    public function __construct()
    {
        $this -> currencyModel = new CurrencyController();
        $this -> priceHistoryModel = new PriceHistory();

    }

    public function getRealTimePrices()
    {
        // trycatch
        // je vais prendre toutes les currency avec la function findAll
        // je vais utiliser une function qui genere les prix 
        // je vais retourne le prix en temps reel
        // retourner JSON

    }

    public function getPriceHistory($currencyId, $period)
    {
        // trycatch
        // je veux prendre les donnees d'historique
        // je vais envoye une reponse (succes ou echec)
        // retourner JSON

    
    }



}

?>