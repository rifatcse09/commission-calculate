<?php
declare(strict_types=1);

namespace Application\CommissionTask\Interfaces;

interface ConvertCurrencyInterface {
    public function convertCurrency(string $baseCurrency, float $amount):array;
}

?>