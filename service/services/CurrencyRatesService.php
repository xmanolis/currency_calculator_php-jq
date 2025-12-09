<?php
/**
 * @author Manolis Xatziemmanouil <manolis@xman.gr>
 * @date July 2025
 *
 * This class is responsible for taking user values, convert them and return them, and run the web service
 *
 * There is no auth process but if it were to be, JWT is a quick win
 */

// be brave :D
declare(strict_types=1);

namespace Services\CurrenciesRates;

// Free rates are down, don't use it anymore
//include 'api/CurrencyConverterApi.php';
//use Api\CurrenciesRates\CurrencyConverterApi as Currencies;

include 'api/ExchangeRateApi.php';
use Api\CurrenciesRates\ExchangeRateApi as Currencies;

class CurrencyRatesService
{
    /**
     * The allowed currencies. Would it better to have them into a database for this test? I think it's too much.
     * I would use PDO by the way, if I had to use db. Or better the magic of a framework
     *
     * @var array
     */
    private const ALLOWED_CURRENCIES = ["EUR", "USD", "CHF", "GBP", "JPY", "CAD"];

    /**
     * @return string
     */
    public function availableCurrencies(): array
    {
        return self::ALLOWED_CURRENCIES;
    }

    /**
     * @description Calculate and return the conversion
     * @param $multiplier
     * @param $fromCurrency
     * @param $toCurrency
     *
     * @return array
     */
    public function calculateCurrencies(): array
    {
        $amount       = $_GET['AMOUNT'] ?? '';
        $fromCurrency = $_GET['FROM_CURRENCY'] ?? '';
        $toCurrency   = $_GET['TO_CURRENCY'] ?? '';

        if (!$this->checkInputs($amount, $fromCurrency, $toCurrency)) {
            /*
            * I didn't want to return just the result of the conversion.
            * I want it to have the ability to return multiple messages.
            *
            * It would be necessary if I am going to show the user what
            * possible mistakes has done when they filled their inputs.
            */
            return [
                'result'  => 'Fail',
                'message' => 'Service could not recognise your inputs'
            ];
        }

        $currencies = new Currencies($fromCurrency, $toCurrency);
        $result = $currencies->getRate() * $amount;

        return [
            'result' => 'Success',
            'value'  => number_format($result, 4),
        ];
    }

    /**
     * @description Basic Check for User Inputs. Always check user's inputs.
     * @param $amount
     * @param $fromCurrency
     * @param $toCurrency
     *
     * @return bool
     */
    protected function checkInputs($amount, $fromCurrency, $toCurrency)
    {
        $validationFlag = false;
        if (is_numeric($amount) &&
            $amount > 0 &&
            in_array($fromCurrency, self::ALLOWED_CURRENCIES) &&
            in_array($toCurrency, self::ALLOWED_CURRENCIES)
        ) {
            $validationFlag = true;
        }

        return $validationFlag;
    }
}
// EOF
