<?php

declare(strict_types=1);

namespace Application\CommissionTask;

use Application\CommissionTask\Service\FileProcessor;
use Application\CommissionTask\Interfaces\CalculateInterface;
use Application\CommissionTask\Repositories\DataProcessRepository;
use Application\CommissionTask\Service\DataProcessor;
use stdClass;

/**
 * Commision Calculation 
 *
 * Long description for class (if any)...
 *
 * @copyright  2006 Zend Technologies
 * @license    http://www.zend.com/license/3_0.txt   PHP License 3.0
 * @version    Release: @package_version@
 * @link       http://dev.zend.com/package/PackageName
 * @since      Class available since Release 1.2.0
 */ 
class Index implements CalculateInterface
{
    protected $startTime;
    protected $endTime;

    const TEST_ENV = 'test';
    const PROD_ENV = 'production';

    public $commission = [];
    public $inputData = [];
    public $env;

     /**
     * Construct
     *
     * @param $inputData
     * @param $env
     * PROD_ENV = for real input 
     * TEST_ENV =  unit test
     * 
     * @throws Some_Exception_Class If something interesting cannot happen
     * @author Rifat <rifatcse09@gmail.com>
     * set amount after conversion to Euro 
     * set Conversion rate
     * 
     */ 
    public function __construct($inputData, $env = self::PROD_ENV)
    {
        $this->inputData = $inputData;
        $this->env = $env;
    }
     /**
     * Calculation
     *
     * @param    
     * when deposit will be null otherwise will carry value
     * 
     * @throws Some_Exception_Class If something interesting cannot happen
     * @author Rifat <rifatcse09@gmail.com>
     * @return commission 
     * 
     */ 
    public function calculate(): array
    {
        try {
            if (self::TEST_ENV === $this->env) {
                $dataObject = new stdClass();
                $dataObject->data = $this->inputData;
            } else {
                $dataObject = new FileProcessor($this->inputData);
                $dataObject->checkArguments()->loadDataFromFile();
            }
             $dataProcessRepository = new DataProcessRepository();
             $commissionProceess = new DataProcessor($dataProcessRepository);
             $this->commission = $commissionProceess->dataProcess($dataObject);
             return $this->commission;
    
        } catch
        (\Exception $exception) {
            echo "Error caught: " . $exception->getMessage() .PHP_EOL;
        }
        return [];
        
    }

    /**
     * Print result 
     *
     * @param  $message  
     * final collection of commission
     * 
     * @throws Some_Exception_Class If something interesting cannot happen
     * @author Rifat <rifatcse09@gmail.com>
     * @return commission 
     * 
     */ 
    public function showOutput($message)
    {
        echo $message . PHP_EOL;
    }
}