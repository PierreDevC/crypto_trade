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


        try {
            // Recuperaton de toutes les devises
            $currencies = $this->currencyModel->findAll();

            // Genereration d'un prix aleatoire pour simuler le prix en temps reel
            $realTimePrices = [];

            foreach ($currencies as $currency) {
                $realTimePrices[] = [
                    'id' => $currency['id'],
                    'name' => $currency['name'],
                    'symbol' => $currency['symbol'],
                    'real_time_price' => $this->generateRandomPrice()
                ];
            }

            // Retourner les prix en JSON
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'data' => $realTimePrices]);

        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }

    }

    public function getPriceHistory($currencyId, $period)
    {
        // trycatch
        // je veux prendre les donnees d'historique
        // je vais envoye une reponse (succes ou echec)
        // retourner JSON

        try {
            // Recupereration des donnees historique pour une devise specifique
            $history = $this->priceHistoryModel->getHistoryByCurrency($currencyId, $period);

            // Retour des donnees en JSON
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'data' => $history]);

        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    // Fonction pour generer un prix aleatoire simuler
    private function generateRandomPrice()
    {
        return round(mt_rand(1000, 50000) / 100, 2); // exemple : entre 10.00 et 500.00
    }

    
    }



?>