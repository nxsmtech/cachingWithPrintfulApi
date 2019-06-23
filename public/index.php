<?php
require '../vendor/autoload.php';
include '../src/Model/Shipping.php';
include '../src/GuzzleApi.php';
include '../src/Cache.php';

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

$cache = new Cache();
$guzzleApi = new GuzzleApi();
$shipping = new \Model\Shipping($guzzleApi, $address, $items, $cache);
$shippingRates = $shipping->getShippingRates();
$shipping->cacheResult($shippingRates);

echo "name";