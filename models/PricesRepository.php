<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\Query;
use yii\helpers\ArrayHelper;

class PricesRepository extends ActiveRecord
{
    public static function tableName()
    {
        return 'price';
    }

    public function getResultPrice($raw_type_id, $tonnage_id, $month_id)
    {
        return (new Query())
            ->select('price.value')
            ->from('price')
            ->andWhere(['raw_type_id' => $raw_type_id, 'tonnage_id' => $tonnage_id, 'month_id' => $month_id,])
            ->scalar();
    }

    public function getRawTypesList(): array
    {
        $data = (new Query())
            ->select('id, name')
            ->from('raw_type')
            ->all();
        return ArrayHelper::map($data, 'id', 'name');
    }

    public function getMonthsList(): array
    {
        $data = (new Query())
            ->select('id, name')
            ->from('month')
            ->all();
        return ArrayHelper::map($data, 'id', 'name');
    }

    public function getTonnagesList(): array
    {
        $data = (new Query())
            ->select('id, value')
            ->from('tonnage')
            ->all();
        return ArrayHelper::map($data, 'id', 'value');
    }

    public function getRawPricesByType($raw_type_id)
    {
        $data = (new Query())
            ->select('month.name as month, tonnage.value as tonnage, price.value as price')
            ->from('price')
            ->innerJoin('tonnage', 'price.tonnage_id = tonnage.id')
            ->innerJoin('month', 'price.month_id = month.id')
            ->innerJoin('raw_type', 'price.raw_type_id = raw_type.id')
            ->andWhere(["raw_type.id" => $raw_type_id])
            ->orderBy('price.id')
            ->all();

        $result = [];
        foreach ($data as $item) {
            $result[$item['month']][$item['tonnage']] = $item['price'];
        }

        return $result;
    }

    public function getRawTypeById($raw_type_id)
    {
        return (new Query())
            ->select('name')
            ->from('raw_type')
            ->andWhere(["id" => $raw_type_id])
            ->scalar();
    }

    public function getMonthById($month_id)
    {
        return (new Query())
            ->select('name')
            ->from('month')
            ->andWhere(["id" => $month_id])
            ->scalar();
    }

    public function getTonnageById($tonnage_id)
    {
        return (new Query())
            ->select('value')
            ->from('tonnage')
            ->andWhere(["id" => $tonnage_id])
            ->scalar();
    }

    public function getTonnageIdByValue($tonnage)
    {
        return (new Query())
            ->select('id')
            ->from('tonnage')
            ->andWhere(["value" => $tonnage])
            ->scalar();
    }

    public function getMonthIdByName($month)
    {
        return (new Query())
            ->select('id')
            ->from('month')
            ->andWhere(["name" => $month])
            ->scalar();
    }

    public function getRawTypeIdByName($raw_type)
    {
        return (new Query())
            ->select('id')
            ->from('raw_type')
            ->andWhere(["name" => $raw_type])
            ->scalar();
    }


}