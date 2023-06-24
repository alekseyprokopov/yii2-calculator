<?php

namespace app\models;

use yii\base\Model;

class CalculatorForm extends Model
{
    public $type;
    public $month;
    public $tonnage;
    public $prices;

    public function __construct(/*$type, $tonnage, $month*/)
    {
//        $this->type = $type;
//        $this->month = $month;
//        $this->tonnage = $tonnage;
        $this->prices = require '../config/prices.php';
    }

    public function saveToQueue(): void
    {
        $basePath = \Yii::getAlias('@runtime') . '/queue.job';
        $data = get_object_vars($this);

        if (file_exists($basePath)) {
            unlink($basePath);
        }

        foreach ($data as $key => $value) {
            file_put_contents($basePath, "{$key} => {$value}" . PHP_EOL, FILE_APPEND);
        }
    }

    public function getPrice()
    {
        return $this->prices[$this->type][$this->tonnage][$this->month];
    }

    public function getMonth()
    {
        return $this->month;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getTonnage()
    {
        return $this->tonnage;
    }

    public function getRawPrice()
    {
        return $this->prices[$this->type];
    }

    public function getRawTypes()
    {
        return array_keys($this->prices);
    }

    public function getTonnages()
    {
        $randomRaw = $this->getRawTypes()[array_rand($this->getRawTypes())];
        return array_keys($this->prices[$randomRaw]);
    }

    public function getMonths()
    {
        $randomTonnage = $this->getTonnages()[array_rand($this->getTonnages())];
        return array_keys($this->prices[array_rand($this->prices)][$randomTonnage]);
    }

    public function getMonthPrice($tonnage, $month)
    {
        return $this->prices[$this->type][$tonnage][$month];

    }

    public function isCorrectPrice($tonnage, $month): bool
    {
        return (string)$tonnage === $this->tonnage && $month === $this->month;
    }

    public function rules()
    {
        return [
            [['type', 'month', 'tonnage'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'type' => 'Тип сырья:',
            'month' => 'Месяц:',
            'tonnage' => 'Тоннаж:',
        ];
    }


}