<?php

namespace Model;

use GuzzleApi;

class Shipping
{
    //guzzle
    private $guzzleClient;
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

    public function __construct(GuzzleApi $guzzleClient, $address, $items)
    {
        $this->guzzleClient = $guzzleClient;
        $this->address1 = ($address['address1'] != null ? $address['address1'] : null);
        $this->city = ($address['city'] != null ? $address['city'] : null);
        $this->county = ($address['county'] != null ? $address['county'] : null);
        $this->zip = ($address['zip'] != null ? $address['zip'] : null);
        $this->items = $items;
    }

    public function getShippingRates() {
        $parameters = $this->getRequestParameters();
        try {
            return $this->guzzleClient->request('POST', 'https://api.printful.com/shipping/rates', $parameters);
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
        try {
            $countries = $this->guzzleClient->request('GET', 'https://api.printful.com/countries');

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