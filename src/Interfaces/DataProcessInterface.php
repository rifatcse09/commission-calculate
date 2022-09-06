<?php
declare(strict_types=1);

namespace Application\CommissionTask\Interfaces;

interface DataProcessInterface {
    public function lineWiseDataProcess($dataObject):array;
}

?>