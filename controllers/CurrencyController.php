<?php
namespace App\Controllers;
/** 
 * Développeur assigne : Aboubacar 
 * Entité : Classe CurrencyController de la couche controller
*/

use App\Models\Currency;
use App\Models\PriceHistory;
use Exception;

class CurrencyController
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
     * Liste de toutes les cryptomonnaies
     */
    public function listCurrencies(): string
    {
        try {
            $currencies = $this->currencyModel->findAll();

            return json_encode([
                'status' => 'success',
                'data' => $currencies
            ]);
        } catch (Exception $e) {
            return json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * les details d'une cryptomonnaie par son ID
     */
    public function viewCurrencyDetails(int $currencyId): string
    {
        try {
            $currency = $this->currencyModel->find($currencyId);

            if ($currency) {
                return json_encode([
                    'status' => 'success',
                    'data' => $currency
                ]);
            } else {
                return json_encode([
                    'status' => 'error',
                    'message' => "Devise non trouvée avec l'ID $currencyId"
                ]);
            }

        } catch (Exception $e) {
            return json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
?>
