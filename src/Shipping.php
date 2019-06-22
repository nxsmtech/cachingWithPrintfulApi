<?php

class Shipping
{
    //recepient variables
    private $address1;
    private $city;
    private $county_code;
    private $state_code;
    private $zip;

    // items variables
    private $variant_id;
    private $quantity;

    public function __construct(
        string $address1,
        string $city,
        string $county_code,
        string $state_code,
        int $zip,
        int $variant_id,
        int $quantity)
    {
        $this->address1 = $address1;
        $this->city = $city;
        $this->county_code = $county_code;
        $this->state_code = $state_code;
        $this->zip = $zip;
        $this->variant_id = $variant_id;
        $this->quantity = $quantity;
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

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    public function getQuantity()
    {
        return $this->quantity;
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

    public function getVariantId()
    {
        return $this->variant_id;
    }

    public function setVariantId($variant_id)
    {
        $this->variant_id = $variant_id;
    }

    public function getZip()
    {
        return $this->zip;
    }


}