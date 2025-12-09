<?php

/**
 * @author Manolis Xatziemmanouil <manolis@xman.gr>
 * @date July 2025
 *
 * This class is responsible for taking currencies rates from internet and return them
 */

namespace Api\CurrenciesRates;

class ExchangeRateApi
{
    private $service_currencies = 'https://v6.exchangerate-api.com/v6/4e13f8189c985641a4feef2b/latest/%s';

    /**
     * freeRating constructor.
     *
     * @param $fromCurrency
     * @param $toCurrency
     */
    public function __construct(public string $fromCurrency, public string $toCurrency)
    {
        $this->service_currencies = sprintf($this->service_currencies, $this->fromCurrency);
    }

    /**
     * Get the rate
     * @return float
     */
    public function getRate(): float
    {
        $serviceResponse = file_get_contents($this->service_currencies);
        $results         = json_decode($serviceResponse, true);

        return $results['conversion_rates'][$this->toCurrency];
    }
}

// EOF
