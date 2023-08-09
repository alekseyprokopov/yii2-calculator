<?php

namespace app\models;

use yii\base\Model;

class CalculatorForm extends Model
{
    public $raw_type_id;
    public $month_id;
    public $tonnage_id;

    public function rules(): array
    {
        $rep = new PricesRepository();

        $notInListMessage = 'не найден прайс для значения';
        return [
            [['raw_type_id', 'month_id', 'tonnage_id'], 'required', 'message' => 'Необходимо ввести {attribute}'],
            [['raw_type_id'], 'in', 'range' => array_keys($rep->getRawTypesList()), 'message' => $notInListMessage],
            [['month_id'], 'in', 'range' => array_keys($rep->getMonthsList()), 'message' => $notInListMessage],
            [['tonnage_id'], 'in', 'range' => array_keys($rep->getTonnagesList()), 'message' => $notInListMessage]
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'raw_type_id' => 'Тип сырья',
            'tonnage_id' => 'Тоннаж',
            'month_id' => 'Месяц',
        ];
    }

    public function saveToQueue()
    {
        $basePath = \Yii::getAlias('@runtime') . '/queue.job';
        $data = get_object_vars($this);

        if (file_exists($basePath)) {
            unlink($basePath);
        }

        foreach ($data as $key => $value) {
            file_put_contents($basePath, "{$key} => {$value}" . PHP_EOL, FILE_APPEND);
        }
        return $this;
    }

}
