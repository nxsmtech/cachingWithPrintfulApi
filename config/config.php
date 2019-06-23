<?php

return (object) array(
        'printful_api_key' => base64_encode('77qn9aax-qrrm-idki:lnh0-fm2nhmp0yca7'),

        //TODO Use these variables in Shipping
        'country_request' => [
            'method' => 'GET',
            'url' => 'https://api.printful.com/countries',
        ],
        'shipping_rate' => [
            'method' => 'POST',
            'url' => 'https://api.printful.com/shipping/rates',
        ]
);