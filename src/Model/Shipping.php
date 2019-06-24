<?php

namespace Model;

use GuzzleApi;
use Cache;

class Shipping
{
    //guzzle
    private $guzzleClient;
    private $cache;
    private $config;
    //recepient variables
    private $address1;
    private $countryCode;
    private $city;
    private $county;
    private $county_code;
    private $state_code;
    private $zip;

    // items variables
    private $items;

    public function __construct(GuzzleApi $guzzleClient, $address, $items, Cache $cache, $config)
    {
        $this->guzzleClient = $guzzleClient;
        $this->cache = $cache;
        $this->config = $config;
        $this->address1 = ($address['address1'] != null ? $address['address1'] : null);
        $this->city = ($address['city'] != null ? $address['city'] : null);
        $this->county = ($address['county'] != null ? $address['county'] : null);
        $this->zip = ($address['zip'] != null ? $address['zip'] : null);
        $this->items = $items;
    }

    public function cacheResult($data)
    {
        $cache_expires = $this->config->cache_duration;
        foreach ($data as $result) {
            $this->cache->set($result->id, $result, $cache_expires);
        }
    }

    public function getShippingRates() {
        $method = $this->config->shipping_rate['method'];
        $url = $this->config->shipping_rate['url'];
        $parameters = $this->getRequestParameters();
        try {
            return $this->guzzleClient->request($method, $url, $parameters);
        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }
    }

    private function getRequestParameters()
    {
        $this->getCountyCodeByCountyName();

        return array(
            "recipient" => [
                "address1" => $this->getAddress1(),
                "city" => $this->getCity(),
                "country_code" => $this->getCountryCode(),
                "state_code" => $this->getStateCode(),
                "zip" => $this->getZip()
            ],
            "items" => $this->getItems()
        );
    }

    private function getCountyCodeByCountyName()
    {
        $method = $this->config->country_request['method'];
        $url = $this->config->country_request['url'];
        try {
            $countries = $this->guzzleClient->request($method, $url);

            $countryCode = null;
            $stateCode = null;

            foreach ($countries as $country) {
                if ($country->states) {
                    foreach ($country->states as $state) {
                        if ($state->name == $this->getCounty()) {
                            $this->setCountyCode($state->code);
                            $this->setCountryCode($country->code);
                        }
                    }
                }
            }
        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }
    }

    public function setAddress1($address1)
    {
        $this->address1 = $address1;
    }

    public function getAddress1()
    {
        return $this->address1;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCountyCode($county_code)
    {
        $this->county_code = $county_code;
    }

    public function getCountyCode()
    {
        return $this->county_code;
    }

    public function setStateCode($state_code)
    {
        $this->state_code = $state_code;
    }

    public function getStateCode()
    {
        return $this->state_code;
    }

    public function setZip($zip)
    {
        $this->zip = $zip;
    }

    public function getZip()
    {
        return $this->zip;
    }

    public function setCounty($county)
    {
        $this->county = $county;
    }

    public function getCounty()
    {
        return $this->county;
    }

    public function getItems()
    {
        return $this->items;
    }

    public function setItems($items)
    {
        $this->items = $items;
    }

    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;
    }

    public function getCountryCode()
    {
        return $this->countryCode;
    }


}