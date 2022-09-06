<?php

declare(strict_types=1);

namespace Application\CommissionTask\Service;

require_once (__DIR__ . '/../Interfaces/DataProcessInterface.php');

use Application\CommissionTask\Interfaces\DataProcessInterface;

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
class DataProcessor
{  
    function __construct(DataProcessInterface $dataProcessInterface)
    {
        $this->dataProcess = $dataProcessInterface;
    }

    /**
     * Data process from input data
     *
     * @param dataObject
     * data object of input
     * @param transactionHistory
     * data object of input
     * 
     * @throws Some_Exception_Class If something interesting cannot happen
     * @author Rifat <rifatcse09@gmail.com>
     * @return array commission 
     * 
     */ 
      function dataProcess($dataObject) {
    
        return $this->dataProcess->lineWiseDataProcess($dataObject);
      }
}