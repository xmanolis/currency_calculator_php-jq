<?php

/*
* Created by Xatziemmanouil Manolis
* July 2014
*
* This class is responsible for taking user values, send them to the server and return its response
*
*/

final class connect_to_webservice
{

    private $client;

    public function __construct()
    {
        $this->client = new nusoap_client("http://currencyconverter.xman.gr/Server/index.php?wsdl");
    }

    // Check for errors and faults
    private function clientError()
    {
        // Check for faults... and if there are, just show a hint that it's a fault. Do not show user the exact fault
        if ($this->client->fault) {
            echo "<h2>Fault</h2><pre>";
            //print_r($result);
            echo "</pre>";
            return false;
        }
        // Check for Errors.. and if there are, just show a hint that it's an error. Do not show user the exact error
        elseif ($this->client->getError())
        {
            echo "<h2>Error</h2><pre>";
            //print_r($client->getError());
            echo "</pre>";
            return false;
        }
        return true;
    }

    // Get Available Currencies
    public function getAvailableCurrencies()
    {
        $result = $this->client->call("currency_service.available_currencies");
        if (!$this->clientError()) {
            return 'Error';
        }
        $enc_result = json_encode($result);
        return $enc_result;
    }

    // Get currency convertion
    public function getCurrencyConversion()
    {
        // Indeed, I am not checking here the inputs. But the service does.
        // We should not trust client side for checking things.
        $from_value = $_POST['from_value'];
        $from_curr = $_POST['from_curr'];
        $to_curr = $_POST['to_curr'];

        // if ($from_curr==$to_curr) {
        //        $same_curr = json_encode("Service cannot do any convertions between the same currency");
        //        return $same_curr;
        // }

        $result = $this->client->call(
            "currency_service.calculate_curr",
            array(
                "from_value" => "$from_value",
                "from_curr" => "$from_curr",
                "to_curr" => "$to_curr"
        ));

        if (!$this->clientError()) {
            return 'Error';
        }
        $enc_result = json_encode($result);
        return $enc_result;
    }
}

// EOF
