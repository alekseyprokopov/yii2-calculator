<?php

namespace app\models;

use yii\base\Model;

class CalculatorForm extends Model
{
    public $type;
    public $month;
    public $tonnage;

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