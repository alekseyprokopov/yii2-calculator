<?php

namespace app\models;

use yii\base\Model;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\helpers\ArrayHelper;

class PricesRepository extends ActiveRecord
{
    public static function tableName()
    {
        return 'price';
    }

    public function getResultPrice($raw_type, $tonnage, $month)
    {
        return (new Query())
            ->select('price.value')
            ->from('price')
            ->innerJoin('tonnage', 'price.tonnage_id = tonnage.id')
            ->innerJoin('month', 'price.month_id = month.id')
            ->innerJoin('raw_type', 'price.raw_type_id = raw_type.id')
            ->where('raw_type.name=:raw_type AND tonnage.value=:tonnage AND month.name=:month',
                [':raw_type' => $raw_type, ':tonnage' => $tonnage, ':month' => $month])
            ->scalar();
    }

    public function getRawTypesList(): array
    {
        $data = (new Query())
            ->select('name')
            ->from('raw_type')
            ->all();
        return ArrayHelper::map($data, 'name', 'name');
    }

    public function getMonthsList(): array
    {
        $data = (new Query())
            ->select('name')
            ->from('month')
            ->all();
        return ArrayHelper::map($data, 'name', 'name');
    }

    public function getTonnagesList(): array
    {
        $data = (new Query())
            ->select('value')
            ->from('tonnage')
            ->all();
        return ArrayHelper::map($data, 'value', 'value');
    }

    public function getRawPricesByType($type)
    {
        $data = (new Query())
            ->select('month.name as month, tonnage.value as tonnage, price.value as price')
            ->from('price')
            ->innerJoin('tonnage', 'price.tonnage_id = tonnage.id')
            ->innerJoin('month', 'price.month_id = month.id')
            ->innerJoin('raw_type', 'price.raw_type_id = raw_type.id')
            ->where('raw_type.name=:type',
                [':type' => $type])
            ->orderBy('price.id')
            ->all();

        $result = [];
        foreach ($data as $item) {
            $result[$item['month']][$item['tonnage']] = $item['price'];
        }

        return $result;
    }

    public function getPriceId($raw_type, $month, $tonnage)
    {
        return (new Query())
            ->select('price.id')
            ->from('price')
            ->innerJoin('tonnage', 'price.tonnage_id = tonnage.id')
            ->innerJoin('month', 'price.month_id = month.id')
            ->innerJoin('raw_type', 'price.raw_type_id = raw_type.id')
            ->where('raw_type.name=:raw_type AND tonnage.value=:tonnage AND month.name=:month',
                [':raw_type' => $raw_type, ':tonnage' => $tonnage, ':month' => $month])
            ->scalar();
    }


}