<?php
function validateNumber($amount)
{
    if (is_numeric($amount) && $amount > 0) {
        return true;
    }

    return false;
}

function validateCurrency($currency)
{
    if (strlen($currency) !== 3) {
        return false;
    }

    return preg_match('/^[A-Za-z]{3}$/', $currency) === 1;
}
