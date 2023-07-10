<?php

namespace app\models;

use yii\base\Model;

class CalculatorForm extends Model
{
    public $raw_type;
    public $month;
    public $tonnage;

    public function __construct($raw_type = null, $month = null, $tonnage = null)
    {
        $this->raw_type = $raw_type;
        $this->month = $month;
        $this->tonnage = $tonnage;
    }

    public function rules()
    {
        $notInListMessage = 'не найден прайс для значения';
        return [
            [['raw_type', 'month', 'tonnage'], 'required', 'message' => 'Необходимо ввести {attribute}'],
            [['raw_type'], 'in', 'range' => ['шрот', 'соя', 'жмых'], 'message' => $notInListMessage],
            [['month'], 'in', 'range' => ['январь', 'февраль', 'август', 'сентябрь', 'октябрь', 'ноябрь'], 'message' => $notInListMessage],
            [['tonnage'], 'in', 'range' => ['25', '50', '75', '100'], 'message' => $notInListMessage]
        ];
    }

    public function attributeLabels()
    {
        return [
            'raw_type' => 'Тип сырья',
            'tonnage' => 'Тоннаж',
            'month' => 'Месяц',
        ];
    }
}
