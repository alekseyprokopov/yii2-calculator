<?php

namespace app\models;

use yii\base\Model;

class CalculatorForm extends Model
{
    public $type;
    public $month;
    public $tonnage;

    public function __construct($type = null, $month = null, $tonnage = null)
    {
        $this->type = $type;
        $this->month = $month;
        $this->tonnage = $tonnage;
    }

    public function rules()
    {
        $notInListMessage = 'не найден прайс для значения';
        return [
            [['type', 'month', 'tonnage'], 'required', 'message' => 'Необходимо ввести {attribute}'],
            [['type'], 'in', 'range' => ['шрот', 'соя', 'жмых'], 'message' => $notInListMessage],
            [['month'], 'in', 'range' => ['январь', 'февраль', 'август', 'сентябрь', 'октябрь', 'ноябрь'], 'message' => $notInListMessage],
            [['tonnage'], 'in', 'range' => ['25', '50', '75', '100'], 'message' => $notInListMessage]
        ];
    }


    public function attributeLabels()
    {
        return [
            'type' => 'Тип сырья',
            'tonnage' => 'Тоннаж',
            'month' => 'Месяц',
        ];
    }

//    public function isCorrectPrice($tonnage, $month): bool
//    {
//        return (string)$tonnage === $this->tonnage && $month === $this->month;
//    }

}