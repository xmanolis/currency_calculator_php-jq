$(document).ready(function () {
    get_available_currencies();
});

function take_currency() {
    var sel_from_curr = $('#from_currency').val();
    var sel_to_curr = $('#to_currency').val();
    var sel_from_value = $('#from_number').val();

    $('#result').html('<img height="50" src="images/ajax.GIF" />');
    $.ajax('client.php',
        {
            method: "POST",
            data: {
                'action': 'get_currency_conversion',
                'from_value': sel_from_value,
                'from_curr': sel_from_curr,
                'to_curr': sel_to_curr
            },
            success: function (data) {
                $('#result').html('');
                var myData = JSON.parse(data);
                if (myData[0] === "Success") {
                    $('#to_number').val(myData[1]);
                } else if (myData[0] == "Fail") {
                    $('#result').html(myData[1])
                } else {
                    $('#result').html(myData)
                }
            },
            error: function () {
                $('#result').html('Error when communicating to web service.');
            }
        });
}

function get_available_currencies() {
    $.ajax('client.php',
        {
            method: "POST",
            data: {
                'action': 'get_available_currencies'
            },
            success: function (data) {
                var myData = JSON.parse(data);
                var select_from = document.getElementById('from_currency');
                var select_to = document.getElementById('to_currency');

                var curr_array = myData.split(',');

                for (var i = 0; i < curr_array.length; i++) {
                    select_from.options[select_from.length] = new Option(curr_array[i], curr_array[i]);
                    select_to.options[select_to.length] = new Option(curr_array[i], curr_array[i]);
                }

                select_to.value = "USD";
            },

            error: function () {
                $('#result').html('Error when communicating to web service.');
            }
        });
}
