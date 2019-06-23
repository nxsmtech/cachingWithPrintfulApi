<?php
require '../vendor/autoload.php';
include '../src/Model/Shipping.php';
include '../src/GuzzleApi.php';

$address = array(
    'address1' => '11025 Westlake Dr',
    'city' => 'Charlotte',
    'county' => 'North Carolina',
    'zip' => '28273');

$items = array(
    [
        'quantity' => 2,
        'variant_id' => 7679
    ],
);

$guzzleApi = new GuzzleApi();
$shipping = new \Model\Shipping($guzzleApi, $address, $items);
$rates = $shipping->getShippingRates();




echo "name";