<?php
/**
 * @author Created by Xatziemmanouil Manolis
 * @date July 2014
 *
 * This class is responsible for taking user values, convert them and return them, and run the web service
 *
 * NuSoap is a free nice group of classes for Soap, downloaded from http://sourceforge.net/
 */

include "nusoap/nusoap.php";
include 'services/freeRating.php';

// By using namespaces like this, it's then piece of case to replace freeRating class with something else
use Services\CurrenciesRates\freeRating as Currencies;

class CurrenciesWebService
{
    /**
     * The allowed currencies. Would it better to have them into a database for this test? I think it's too much.
     * I would use PDO by the way, if I had to use db.
     * @var array
     */
    public $aAllowedCurrencies = ["EUR", "USD", "CHF", "GBP", "JPY", "CAD"];

    /**
     * Holds the results
     * @var array
     */
    public $aFinalResult = [];

    /**
     * @description Calculate and return the conversion
     * @param $multiplier
     * @param $fromCurrency
     * @param $toCurrency
     *
     * @return array
     */
    public function calculateCurrencies($multiplier, $fromCurrency, $toCurrency)
    {
        /*
        * I didn't want to return just the result of the conversion.
        * I want it to have the ability to return multiple messages.
        *
        * It would be necessary if I am going to show the user what
        * possible mistakes has done when he/she filled his/her inputs.
        */

        if (!$this->checkInputs($multiplier, $fromCurrency, $toCurrency)) {
            $this->aFinalResult['result'] = "Fail";
            $this->aFinalResult['value'] = "Service couldn't recognise your inputs";

            return $this->aFinalResult;
        }

        $currencies = new Currencies($fromCurrency, $toCurrency);
        $this->aFinalResult['result'] = "Success";
        $this->aFinalResult['value'] = $currencies->getRate() * $multiplier;

        return $this->aFinalResult;
    }

    /**
     * @return string
     */
    public function availableCurrencies()
    {
        return implode(',', $this->aAllowedCurrencies);
    }

    /**
     * description Basic Check for User Inputs
     * @param $fromValue
     * @param $fromCurrency
     * @param $toCurrency
     *
     * @return bool
     */
    protected function checkInputs($fromValue, $fromCurrency, $toCurrency)
    {
        $validationFlag = false;
        if (is_numeric($fromValue) &&
            $fromValue > 0 &&
            in_array($fromCurrency, $this->aAllowedCurrencies) &&
            in_array($toCurrency, $this->aAllowedCurrencies)
        ) {
            $validationFlag = true;
        }

        return $validationFlag;
    }


    /**
     * @description Let's make this Currency Converter a web service. WSDL is nice and anyone can communicate with it.
     */
    public function registerCurrenciesCalculatorService()
    {
        $server = new soap_server();
        $server->configureWSDL("CurrenciesWebService", "urn:CurrenciesWebService");

        $server->wsdl->addComplexType(
            'Result',
            'complexType',
            'array',
            'all',
            '',
            array(
                'result' => array('name' => 'result', 'type' => 'xsd:string'),
                'value' => array('name' => 'value', 'type' => 'xsd:string')
            )
        );

        // Register Service for Currency Converter
        $server->register(
            "CurrenciesWebService.calculateCurrencies",
            ["from_value" => "xsd:string", "from_curr" => "xsd:string", "to_curr" => "xsd:string"],
            ["return" => "tns:Result"],
            "CurrenciesWebService",
            "urn:CurrenciesWebService",
            "rpc",
            "encoded",
            "a.. description of currency converter"
        );

        // Register Service for available currencies
        $server->register(
            "CurrenciesWebService.availableCurrencies",
            [],
            ["return" => "xsd:string"],
            "CurrenciesWebService",
            "urn:CurrenciesWebService",
            "rpc",
            "encoded",
            "a.. description of available currencies"
        );

        @$server->service(file_get_contents("php://input"));
    }
}

// EOF
