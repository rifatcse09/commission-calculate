<?php

declare(strict_types=1);

namespace Application\CommissionTask\Service;
/**
 * File process
 *
 * Long description for class (if any)...
 *
 * @copyright  2006 Zend Technologies
 * @license    http://www.zend.com/license/3_0.txt   PHP License 3.0
 * @version    Release: @package_version@
 * @link       http://dev.zend.com/package/PackageName
 * @since      Class available since Release 1.2.0
 */ 
class FileProcessor
{
    private $arguments;
    private $fileName;
    public $errors = [];
    public $data = [];

    const ACCEPTED_ARGUMENT_COUNT = 2;
    const FILENAME_POSITION = 1;
    const TOO_MANY_ARGUMENTS_MSG = 'Extra Arguments.';
    const INVALID_FILE_EXTENSION_MSG = 'Invalid File Extension.';

    /**
     * @param $arguments
     */
    public function __construct($arguments)
    {
        $this->arguments = $arguments;
    }
    /**
     * Input Argument
     * validation
     * 
     * @param 
     * @param 
     * 
     * @throws Some_Exception_Class If something interesting cannot happen
     * @author Rifat <rifatcse09@gmail.com>
     * set amount after conversion to Euro 
     * set Conversion rate
     * 
     * 
     */ 
    public function checkArguments()
    {
        
        $argumentCount = count($this->arguments);

        if ($argumentCount > self::ACCEPTED_ARGUMENT_COUNT) {
            throw new \Exception(self::TOO_MANY_ARGUMENTS_MSG);
        }

        self::setFileName($this->arguments[$argumentCount - self::FILENAME_POSITION]);

        if (!self::checkFileExtension(self::getFileName())) {
            throw new \Exception(self::INVALID_FILE_EXTENSION_MSG);
        }

        return $this;
    }
     /**
     * Set File Name
     * 
     * 
     * @param $fileName
     * @param 
     * 
     * @throws Some_Exception_Class If something interesting cannot happen
     * @author Rifat <rifatcse09@gmail.com>
     * set amount after conversion to Euro 
     * set Conversion rate
     * 
     * 
     */ 
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
    }
    /**
     * Get File Name
     * 
     * 
     * @param $fileName
     * @param 
     * 
     * @throws Some_Exception_Class If something interesting cannot happen
     * @author Rifat <rifatcse09@gmail.com>
     * set amount after conversion to Euro 
     * set Conversion rate
     * 
     * @return string @fileName
     * 
     */ 
    public function getFileName(): string
    {
        return $this->fileName;
    }
    /**
     * Input file extension 
     * validation
     * 
     * @param 
     * @param 
     * 
     * @throws Some_Exception_Class If something interesting cannot happen
     * @author Rifat <rifatcse09@gmail.com>
     * set amount after conversion to Euro 
     * set Conversion rate
     * 
     * @return $status 
     * 
     */ 
    private function checkFileExtension(string $fileName): bool
    {
        $fileNameArray = explode('.', $fileName);
        $lastIndexOfFileNameArray = count($fileNameArray) - 1;

        return in_array($fileNameArray[$lastIndexOfFileNameArray], ['csv', 'CSV']);
    }
     /**
     * Load data from file
     * convert to array
     *
     * @param 
     * @param 
     * 
     * @throws Some_Exception_Class If something interesting cannot happen
     * @author Rifat <rifatcse09@gmail.com>
     * set amount after conversion to Euro 
     * set Conversion rate
     * 
     */ 
    public function loadDataFromFile()
    {
        $this->data = file(self::getFileName(), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($this->data as $data) {
            $explodedData = explode(',', $data);

            if (count($explodedData) !== 6 && !in_array('', $explodedData)) {
                throw new \Exception('Not Formated Data.');
            }
        }
    }
}