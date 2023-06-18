<?php

namespace app\models;

use yii\base\Model;

class CalculatorForm extends Model
{
    public $type;
    public $month;
    public $tonnage;

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

}