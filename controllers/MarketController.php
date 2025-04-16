<?php
namespace App\Controllers;
/** 
 * Développeur assigné : Aboubacar 
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
     * Affiche la vue du marché avec les cryptomonnaies
     */
    public function index(): void
    {
        try {
            $currencies = $this->currencyModel->findAll();

            $cryptos = [];

            foreach ($currencies as $currency) {
                $cryptos[] = [
                    'id' => $currency->getId(),
                    'name' => $currency->getName(),
                    'symbol' => $currency->getSymbol(),
                    'price' => $this->generatePrice($currency->getId()),
                    'variation' => rand(-5, 5) // Variation aléatoire simulée
                ];
            }

            // Charger la vue
            include_once __DIR__ . '/../views/market/index.php';

        } catch (Exception $e) {
            echo "Erreur lors de l'affichage du marché : " . $e->getMessage();
        }
    }

    /**
     * Récupération des prix en temps réel
     */
    public function getRealTimePrices(): string
    {
        try {
            $currencies = $this->currencyModel->findAll();

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
     * Récupération de l'historique des prix
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
     * Générer un prix fictif
     */
    private function generatePrice(int $currencyId): float
    {
        return round(mt_rand(100, 5000) / 100, 2); // prix entre 1.00 et 50.00
    }
}
?>
