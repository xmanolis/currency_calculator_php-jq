$(document).ready(function () {
    get_available_currencies();
});

function get_currency_rate() {
    const fromCurrency = $('#from_currency').val();
    const toCurrency = $('#to_currency').val();
    const amount = $('#from_number').val();

    const resultDiv = $('#result');
    const loader = $('#image_loader');
    loader.removeClass('d-none');
    $.ajax('/proxy/get_currency_conversion.php',
        {
            method: "GET",
            data: {
                'AMOUNT': amount,
                'FROM_CURRENCY': fromCurrency,
                'TO_CURRENCY': toCurrency
            },
            success: function (response) {
                resultDiv.html('');

                if (response['result'] === "Success") {
                    resultDiv.html(response['value']);
                    $('input#to_number').val(response['value'])
                } else if (response['result'] === "Fail") {
                    resultDiv.html(response['message'])
                } else {
                    resultDiv.html('Something went wrong. Please try again later.')
                }
            },
            error: function () {
                resultDiv.html('Error when communicating to web service.');
            },
            complete: function () {
                loader.addClass('d-none');
            }
        });
}

function get_available_currencies() {
    $.ajax('/proxy/get_currencies.php',
        {
            method: "GET",
            success: function (response) {
                const fromCurrency = document.getElementById('from_currency');
                const toCurrency = document.getElementById('to_currency');

                for (var i = 0; i < response.data.length; i++) {
                    fromCurrency.options[fromCurrency.length] = new Option(response.data[i], response.data[i]);
                    toCurrency.options[toCurrency.length] = new Option(response.data[i], response.data[i]);
                }

                toCurrency.value = "USD";
            },

            error: function () {
                $('#result').html('Error when communicating to web service.');
            }
        });
}
