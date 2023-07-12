<?php

namespace app\models;

use yii\base\Model;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\helpers\ArrayHelper;

class PricesRepository extends ActiveRecord
{
    public function getResultPrice($raw_type, $tonnage, $month)
    {
        $data = (new Query())
            ->select('price')
            ->from('prices')
            ->innerJoin('tonnages', 'prices.tonnage_id = tonnages.id')
            ->innerJoin('months', 'prices.month_id = months.id')
            ->innerJoin('raw_types', 'prices.raw_type_id = raw_types.id')
            ->where('raw_types.name=:raw_type AND tonnages.value=:tonnage AND months.name=:month',
                ['raw_type' => $raw_type, ':tonnage' => $tonnage, ':month' => $month])
            ->one();

        return $data['price'];
    }

    public function getRawTypesList(): array
    {
        $data = (new Query())
            ->select('name')
            ->from('raw_types')
            ->all();
        return ArrayHelper::map($data, 'name', 'name');
    }

    public function getMonthsList(): array
    {
        $data = (new Query())
            ->select('name')
            ->from('months')
            ->all();
        return ArrayHelper::map($data, 'name', 'name');
    }

    public function getTonnagesList(): array
    {
        $data = (new Query())
            ->select('value')
            ->from('tonnages')
            ->all();
        return ArrayHelper::map($data, 'value', 'value');
    }

    public function getRawPricesByType($type)
    {
        $data = (new Query())
            ->select('months.name as month, tonnages.value as tonnage, price ')
            ->from('prices')
            ->innerJoin('tonnages', 'prices.tonnage_id = tonnages.id')
            ->innerJoin('months', 'prices.month_id = months.id')
            ->innerJoin('raw_types', 'prices.raw_type_id = raw_types.id')
            ->where('raw_types.name=:type',
                [':type' => $type])
            ->orderBy('prices.id')
            ->all();

        $result = [];
        foreach ($data as $item) {
            $result[$item['month']][$item['tonnage']] = $item['price'];
        }

        return $result;
    }


}