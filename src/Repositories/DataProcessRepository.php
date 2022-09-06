<?php
declare(strict_types=1);

namespace Application\CommissionTask\Repositories;

require_once (__DIR__ . '/../Interfaces/DataProcessInterface.php');
require_once (__DIR__ . '/TransactionRepository.php');
require_once (__DIR__ . '/../Service/Transaction.php');

use Application\CommissionTask\Interfaces\DataProcessInterface;
use Application\CommissionTask\Service\Transaction;
use Application\CommissionTask\Repositories\TransactionRepository;
use Exception;

class DataProcessRepository implements DataProcessInterface {

    private $commission = [];

     /**
     * Input data process
     *
     * @param dataObject   
     * 
     * 
     * @throws Some_Exception_Class If something interesting cannot happen
     * @author Rifat <rifatcse09@gmail.com>
     * @return array of commission 
     * 
     */ 
    public function lineWiseDataProcess($dataObject): array {
        try {
            $transactionHistory = [];
            if (property_exists($dataObject, 'data')) {
                    foreach ($dataObject->data as $data) {
                    $explodedData = explode(',', $data);
        
                    $transactionRepository = new TransactionRepository();
                    $transactionObject = new Transaction($transactionRepository, $explodedData);
                    
                    if (strtolower($transactionObject->transactionType) === 'deposit') {
                        $this->commission[] = $transactionObject->calculateCommission();
                    } else {
                        if (strtolower($transactionObject->accountType) === 'business') {
                            $commissionApplicableAmount = $transactionObject->amountInEuro;
                        } else {
                            if (!array_key_exists($transactionObject->userId, $transactionHistory)) {
                                if ($transactionObject->amountInEuro > $transactionObject->privateCommisionFreeWithdrawLimit) {
                                    $commissionApplicableAmount = $transactionObject->amountInEuro - $transactionObject->privateCommisionFreeWithdrawLimit;
                                } else {
                                    $commissionApplicableAmount = 0;
                                }
                            } else {
                                $previousTotalTransactionAmount = 0;
                                $previousTransactionCount = 0;
                                $firstDate = strtotime($transactionObject->date);
                                foreach ($transactionHistory[$transactionObject->userId] as $historyData) {
                                    $secondDate = strtotime($historyData->date);

                                    if (date('oW', $firstDate) === date('oW', $secondDate)) {
                                        $previousTransactionCount++;
                                        $previousTotalTransactionAmount += $historyData->amountInEuro;
                                    }
                                    if ($previousTransactionCount > $transactionObject->privateCommisionFreeWithdrawCount) {
                                        $commissionApplicableAmount = $transactionObject->amountInEuro;
                                    } else {
                                        if ($previousTotalTransactionAmount >= $transactionObject->privateCommisionFreeWithdrawCount) {
                                            $commissionApplicableAmount = $transactionObject->amountInEuro;
                                        } else {
                                            $totalAmount = $previousTotalTransactionAmount + $transactionObject->amountInEuro;
                                            $remainingQuota = $totalAmount - $transactionObject->privateCommisionFreeWithdrawCount;
                                            $commissionApplicableAmount = ($remainingQuota >= 0) ? $remainingQuota : 0;
                                        }
                                    }
                                }
                            }

                            $transactionHistory[$transactionObject->userId][] = $transactionObject;
                        }
                        $this->commission[] = $transactionObject->calculateCommission($commissionApplicableAmount);
                    }
                }
                return $this->commission;
            } else {
                throw new Exception("No data object");
            }
           
        }
        catch
        (\Exception $exception) {
            echo "Error caught: " . $exception->getMessage() .PHP_EOL;
            return [];
        }     
    }
}

?>