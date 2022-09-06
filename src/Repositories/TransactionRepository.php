<?php
declare(strict_types=1);

namespace Application\CommissionTask\Repositories;

require_once (__DIR__ . '/../Abstracts/TransactionAbstract.php');
require_once (__DIR__ . '/../Repositories/ApiCurrencyRepository.php');
require_once (__DIR__ . '/../Repositories/ConvertCurrencyRepository.php');

use Application\CommissionTask\Abstracts\TransactionAbstract;
use Application\CommissionTask\Repositories\ApiCurrencyRepository;
use Application\CommissionTask\Repositories\ConvertCurrencyRepository;
use Exception;

/**
 * Convert Currency to Euro 
 * And Calcualte Commission
 *
 *
 * @copyright  2006 Zend Technologies
 * @license    http://www.zend.com/license/3_0.txt   PHP License 3.0
 * @version    Release: @package_version@
 * @link       http://dev.zend.com/package/PackageName
 * @since      Class available since Release 1.2.0
 */ 
class TransactionRepository extends TransactionAbstract {

    public $depositeCommissionRate = 0.03;
    public $privateCommisionFreeWithdrawLimit = 1000;
    public $privateCommisionFreeWithdrawCount = 3;
    public $privateWithdrawCommisionRate = 0.3;
    public $businessWithdrawCommisionRate = 0.5;
    public $date;
    public $userId;
    public $accountType;
    public $transactionType;
    public $amount;
    public $currency;
    public $amountInEuro;
    public $conversionRate;
    
     /**
     * Convert currency to Euro
     *
     * @param $date
     * @param $userId
     * @param $accountType
     * @param $transactionType
     * @param $amount
     * @param $currency
     * 
     * @throws Some_Exception_Class If something interesting cannot happen
     * @author Rifat <rifatcse09@gmail.com>
     * set amount after conversion to Euro 
     * set Conversion rate
     * 
     */ 
    public function convertCurrency($data)
    {
        try {
            if (empty($data)) {
                throw new Exception("Input Data Error");
            } 
            $this->date = $data[0];
            $this->userId = $data[1];
            $this->accountType = $data[2];
            $this->transactionType = $data[3];
            $this->amount = $data[4];
            $this->currency = $data[5];
            if (!in_array($this->currency, ['EUR', 'eur'])) {
                $apiCurrencyRepository = new ApiCurrencyRepository();
                $convertCurrencyRepository = new ConvertCurrencyRepository($apiCurrencyRepository);
                $conversionResponse = $convertCurrencyRepository->convertCurrency((string)$this->currency, (float)$this->amount);
                $this->amountInEuro = $conversionResponse['amount'];
                $this->conversionRate = $conversionResponse['rate'];
            } else {
                $this->amountInEuro = $this->amount;
                $this->conversionRate = 1;
            }

        } catch
        (\Exception $exception) {
            echo "Error caught: " . $exception->getMessage() .PHP_EOL;
        }
  
    }
    
    /**
     * Commission Calculation
     *
     * @param commissionApplicableAmount   
     * when deposit will be null otherwise will carry value
     * 
     * @throws Some_Exception_Class If something interesting cannot happen
     * @author Rifat <rifatcse09@gmail.com>
     * @return commission 
     * 
     */ 
    public function calculateCommission($commissionApplicableAmount = null) {
        try {
            if (is_null($commissionApplicableAmount)) {
                $commissionApplicableAmount = $this->amountInEuro;
                $commissionRate = $this->depositeCommissionRate;
            } else {
                $commissionRate = (strtolower($this->accountType) === 'private') ?
                $this->privateWithdrawCommisionRate :
                $this->businessWithdrawCommisionRate;
            }
            $commissionInEuro = ($commissionApplicableAmount * $commissionRate) / 100;

            return round($commissionInEuro * $this->conversionRate, 2);
            
        } catch
        (\Exception $exception) {
            echo "Error caught: " . $exception->getMessage() .PHP_EOL;
        }    
    }
}

?>