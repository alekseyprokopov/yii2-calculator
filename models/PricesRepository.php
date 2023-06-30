<?php

namespace app\models;

class PricesRepository
{
    private $prices;


    public function __construct(array $prices)
    {
        $this->prices = $prices;
    }

    public function getPrice($type, $tonnage, $month)
    {
        return $this->prices[$type][$tonnage][$month];
    }

    public function getRawTypesList()
    {
        $raws = array_keys($this->prices);
        return array_combine($raws, $raws);
    }

    public function getTonnagesList()
    {
        $randomRaw = $this->getRawTypesList()[array_rand($this->getRawTypesList())];
        $tonnages = array_keys($this->prices[$randomRaw]);
        return array_combine($tonnages, $tonnages);
    }

    public function getMonthsList()
    {
        $randomTonnage = $this->getTonnagesList()[array_rand($this->getTonnagesList())];
        $months = array_keys($this->prices[array_rand($this->prices)][$randomTonnage]);
        return array_combine($months, $months);
    }

    public function getRawPricesByType($type)
    {
        return $this->prices[$type];
    }


}