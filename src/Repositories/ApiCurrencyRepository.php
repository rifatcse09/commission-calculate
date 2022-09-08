<?php
declare(strict_types=1);

namespace Application\CommissionTask\Repositories;

use Application\CommissionTask\Interfaces\ApiConnectInterface;
use Exception;

class ApiCurrencyRepository implements ApiConnectInterface {

    const API_PATH = 'https://developers.paysera.com/tasks/api/currency-exchange-rates';
    
    public function getCurrencyExchange(): array {
        try {
            $curlClient = curl_init(self::API_PATH);
            curl_setopt($curlClient, CURLOPT_RETURNTRANSFER, true);
            $responseJson = curl_exec($curlClient);
            curl_close($curlClient); 

            if (!$responseJson) {
                throw new Exception("Api Connection Error");
            }  else {
                return json_decode($responseJson, true);
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