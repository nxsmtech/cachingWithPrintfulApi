<?php

require '../vendor/autoload.php';

$apiKey = base64_encode('77qn9aax-qrrm-idki:lnh0-fm2nhmp0yca7');
$headers = $headers = [
    'Authorization' => 'Basic ' . $apiKey,
    'Accept' => 'application/json',
];
$client = new GuzzleHttp\Client();

$address = '11025 Westlake Dr, Charlotte, North Carolina, 28273';
$product_variant_id = 7679;
$quantity = 2;

$addressArr = explode(',', $address);
$address1 = trim($addressArr[0]);
$city = trim($addressArr[1]);
$stateName = trim($addressArr[2]);
$zip = trim($addressArr[3]);

$countriesRequest = $client->request('GET', 'https://api.printful.com/countries', [
    'headers' => $headers
]);
$countriesResult = json_decode($countriesRequest->getBody());
$countries = $countriesResult->result;


$countryCode = null;
$stateCode = null;

foreach ($countries as $country) {
    if ($country->states) {
        foreach ($country->states as $state) {
            if ($state->name == $stateName) {
                $stateCode = $state->code;
                $countryCode = $country->code;
            }
        }
    }
}

$requestParameters = array(
    "recipient" => [
        "address1" => $address1,
        "city" => $city,
        "country_code" => $countryCode,
        "state_code" => $stateCode,
        "zip" => $zip
    ],
    "items" => [
        [
            "quantity" => $quantity,
            "variant_id" => $product_variant_id
        ],
    ]
);

$params = json_encode($requestParameters);
$shippingRateRequest = $client->request('POST', 'https://api.printful.com/shipping/rates', [
        'body' => $params,
        'headers' => $headers]
);

$shippingResults = json_decode($shippingRateRequest->getBody());
$shippingRates = $shippingResults->result;

echo "name";