# currency_calculator_php-jq
Currency Converter is a small simple php application, developed for any person concerned who would like to see the quality of my code.

# Server Side
Server Side makes available its service through wsdl file. It connects to free.currencyconverterapi.com and submits all queries that receives from client. The way that this application is developed, make it too easy to add/remove currencies. Server uses 2 classes. Class "currencies" is responsible for taking currencies rates from internet and return them. Class "currency_service" is responsible for taking user values, convert them and return them. It's also responsible for running the web service. Available currencies can change from "currency_service" class.

# Client Side
Client connects to Server through SOAP using PHP. The usage of PHP happens because I had to predict the chance of the client being into a different server and I wouldn't like to make cross-domain ajax connections.
When page loads, it connects to Server, for to take the available currencies and put them into the select menus. Then, when user wants a currency conversion, client posts data to server and then the result is displayed.

Both Server and Client Sides uses NuSoap Tools.

# 
In case you would like to use it for yourself for whatever reason, be advised that the service responsible for the actual ratings requires frequently updating. You can get an API KEY from https://www.currencyconverterapi.com/ and place it in /Server/services/freeRating.php file, in $service_currencies variable.
