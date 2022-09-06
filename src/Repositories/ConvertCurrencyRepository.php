<?php
declare(strict_types=1);

namespace Application\CommissionTask\Repositories;

require_once (__DIR__ . '/../Interfaces/ApiConnectInterface.php');
require_once (__DIR__ . '/../Interfaces/ConvertCurrencyInterface.php');

use Application\CommissionTask\Interfaces\ConvertCurrencyInterface;
use Application\CommissionTask\Interfaces\ApiConnectInterface;
use Exception;

/**
 * Convert Currency 
 *
 * Long description for class (if any)...
 *
 * @copyright  2006 Zend Technologies
 * @license    http://www.zend.com/license/3_0.txt   PHP License 3.0
 * @version    Release: @package_version@
 * @link       http://dev.zend.com/package/PackageName
 * @since      Class available since Release 1.2.0
 */ 
class ConvertCurrencyRepository implements ConvertCurrencyInterface {

    public function __construct(ApiConnectInterface $apiCurrency)
    {
        $this->apiCurrency = $apiCurrency;
    
    }
 
     /**
     * Convert Currency as API rate
     *
     * @param baseCurrency   
     * input currency
     * @param amount   
     * input amount
     * 
     * @throws Some_Exception_Class If something interesting cannot happen
     * @author Rifat <rifatcse09@gmail.com>
     * @return array of rate and amount 
     * 
     */ 
    public function convertCurrency(string $baseCurrency, float $amount): array {
        try {
            $currencyResponse = $this->apiCurrency->getCurrencyExchange();
            
            if (!$currencyResponse) {
                throw new Exception("Currency Response error");
            } else {
                $conversionRate = round($currencyResponse['rates'][$baseCurrency], 2);
                return [
                    'rate' => $conversionRate,
                    'amount' => round($amount / $conversionRate, 2)
                ];
            }
        }
        catch
        (\Exception $exception) {
             echo "Error caught: " . $exception->getMessage().PHP_EOL;
             return [
                'rate' => 0.00,
                'amount' => 0.00
            ];
        } 
    }
}

?>