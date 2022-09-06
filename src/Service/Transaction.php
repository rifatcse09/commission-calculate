<?php

declare(strict_types=1);

namespace Application\CommissionTask\Service;

require_once (__DIR__ . '/../Abstracts/TransactionAbstract.php');

use Application\CommissionTask\Abstracts\TransactionAbstract;

/**
 * Calcualte Every line
 * input for conversion
 * And Calcualte Commission
 *
 * @copyright  2006 Zend Technologies
 * @license    http://www.zend.com/license/3_0.txt   PHP License 3.0
 * @version    Release: @package_version@
 * @link       http://dev.zend.com/package/PackageName
 * @since      Class available since Release 1.2.0
 */ 
class Transaction
{
    public $date;
    public $userId;
    public $accountType;
    public $transactionType;
    public $amount;
    public $currency;
    public $amountInEuro;
    public $conversionRate;

    public $depositCommisionRate;
    public $privateCommisionFreeWithdrawLimit;
    public $privateCommisionFreeWithdrawCount;
  
    function __construct(TransactionAbstract $transactionAbstract, $data)
    {
      $this->transactionAbstract = $transactionAbstract;
      $this->transactionAbstract->convertCurrency($data);  
      $this->accountType = $this->transactionAbstract->accountType;
      $this->transactionType = $this->transactionAbstract->transactionType;
      $this->userId = $this->transactionAbstract->userId;
      $this->amountInEuro = $this->transactionAbstract->amountInEuro;
      $this->date = $this->transactionAbstract->date;
      $this->privateCommisionFreeWithdrawLimit = $this->transactionAbstract->privateCommisionFreeWithdrawLimit;
      $this->privateCommisionFreeWithdrawCount = $this->transactionAbstract->privateCommisionFreeWithdrawCount;
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
      function calculateCommission($commissionApplicableAmount = null){
        return $this->transactionAbstract->calculateCommission($commissionApplicableAmount);
      }
}