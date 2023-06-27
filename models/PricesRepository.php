<?php

namespace app\models;

class PricesRepository
{
    private $prices;


    public function __construct()
    {
        $this->prices = require '../config/prices.php';
    }

    public function getPrice($type, $tonnage, $month)
    {
        return $this->prices[$type][$tonnage][$month];
    }

    public function getRawTypesList()
    {
        return array_keys($this->prices);
    }

    public function getTonnagesList()
    {
        $randomRaw = $this->getRawTypesList()[array_rand($this->getRawTypesList())];
        return array_keys($this->prices[$randomRaw]);
    }

    public function getMonthsList()
    {
        $randomTonnage = $this->getTonnagesList()[array_rand($this->getTonnagesList())];
        return array_keys($this->prices[array_rand($this->prices)][$randomTonnage]);
    }

    public function getRawPricesByType($type)
    {
        return $this->prices[$type];
    }


}