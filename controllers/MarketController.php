<?php
namespace App\Controllers;
/** 
 * Développeur assigne : Aboubacar 
 * Entité : Classe MarketController de la couche controller
 */

use App\Models\Currency;
use App\Models\PriceHistory;
use Exception;

class MarketController
{
    private Currency $currencyModel;
    private PriceHistory $priceHistoryModel;
    private array $request;
    private $response;

    public function __construct(array $request = [])
    {
        $this->currencyModel = new Currency(); 
        $this->priceHistoryModel = new PriceHistory();
        $this->request = $request;
    }

    /**
     * Recuperation des prix en temps reel des cryptomonnaies
     */
    public function getRealTimePrices(): string
    {
        try {
            $currencies = $this->currencyModel->findAll();

            // Simuler les prix en temps réel
            $realTimePrices = [];

            foreach ($currencies as $currency) {
                $realTimePrices[] = [
                    'id' => $currency->getId(),
                    'name' => $currency->getName(),
                    'symbol' => $currency->getSymbol(),
                    'price' => $this->generatePrice($currency->getId())
                ];
            }

            return json_encode([
                'status' => 'success',
                'data' => $realTimePrices
            ]);

        } catch (Exception $e) {
            return json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Recuperation de l'historique des prix d'une cryptomonnaie
     */
    public function getPriceHistory(int $currencyId, string $period): string
    {
        try {
            
            $history = $this->priceHistoryModel->findByCurrencyId($currencyId, 100);

            return json_encode([
                'status' => 'success',
                'currency_id' => $currencyId,
                'period' => $period,
                'data' => $history
            ]);

        } catch (Exception $e) {
            return json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * un prix fictif en temps reel
     */
    private function generatePrice(int $currencyId): float
    {
        return round(mt_rand(100, 5000) / 100, 2); // prix entre 1.00 et 50.00
    }
}
?>
