<?php
declare(strict_types=1);

namespace Application\CommissionTask\Abstracts;

abstract class TransactionAbstract {
    public $depositeCommissionRate;
    public $businessWithdrawCommisionRate;
    public $privateCommisionFreeWithdrawCount;
    public $privateWithdrawCommisionRate;
    public $privateCommisionFreeWithdrawLimit;
    abstract public function calculateCommission($commissionApplicableAmount = null);
    abstract public function convertCurrency($data);
}

?>