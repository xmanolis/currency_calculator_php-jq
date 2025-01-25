<?php

/**
 * @author Xatziemmanouil Manolis
 * @date July 2014
 *
 * This class is responsible for taking currencies rates from internet and return them
 */
namespace Services\CurrenciesRates;

class freeRating
{
    private $service_currencies = 'https://free.currconv.com/api/v7/convert?q=%s&compact=ultra&apiKey=no_sharing';

    private $fromCurrency;

    private $toCurrency;

    /**
     * freeRating constructor.
     *
     * @param $fromCurrency
     * @param $toCurrency
     */
    public function __construct($fromCurrency, $toCurrency)
    {
        $this->fromCurrency       = $fromCurrency;
        $this->toCurrency         = $toCurrency;
        $this->service_currencies = sprintf( $this->service_currencies, $fromCurrency . '_' . $toCurrency );
    }

    /**
     * Get the rate
     * @return float
     */
    public function getRate()
    {
        $serviceResponse = file_get_contents( $this->service_currencies );
        $results         = json_decode( $serviceResponse, true );

        return $results[ $this->fromCurrency . '_' . $this->toCurrency ];
    }
}

// EOF
