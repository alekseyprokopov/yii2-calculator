<?php

namespace app\models;

class PricesRepository
{
    private $prices;


    public function __construct(array $prices)
    {
        $this->prices = $prices;
    }

    public function getResultPrice($type, $tonnage, $month)
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


    //hardcode for future fixes:

//    public function getRawTypesList()
//    {
//        $raws = ['шрот', 'жмых', 'соя'];
//        return array_combine($raws, $raws);
//    }
//
//    public function getTonnagesList()
//    {
//        $tonnages = ['25', '50', '75', '100'];
//        return array_combine($tonnages, $tonnages);
//    }
//
//    public function getMonthsList()
//    {
//        $months = ['январь', 'февраль', 'август', 'сентябрь', 'октябрь', 'ноябрь'];
//        return array_combine($months, $months);
//    }


}