<?php

namespace app\models;

use yii\base\Model;

class CalculatorForm extends Model
{
    public $type;
    public $month;
    public $tonnage;

   

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
            'tonnage' => 'Тоннаж:',
            'month' => 'Месяц:',
        ];
    }


}