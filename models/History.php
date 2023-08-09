<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;


/**
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $raw_type
 * @property string $month
 * @property int $tonnage
 * @property int $price
 * @property string $table_data
 */
class History extends ActiveRecord
{
    public function rules()
    {
        return [
            [['username', 'email', 'raw_type', 'month', 'tonnage', 'price', 'table_data'], 'required'],
            [['tonnage', 'price'], 'integer'],
            [['username', 'email', 'raw_type', 'month'], 'string', 'max' => 255],
            [['table_data'], 'string', 'max' => 1000]
        ];
    }

    public function getRawPrices()
    {
        return json_decode($this->table_data);
    }


    public function getCalculationData()
    {
        return $this::find()->select('created_at')->where(['id' => $this->id])->scalar();
    }

    public function snapshot(CalculatorForm $model)
    {
        $repository = new PricesRepository();
        $this->username = Yii::$app->user->identity->username;
        $this->email = Yii::$app->user->identity->email;
        $this->month = $repository->getMonthById($model->month_id);
        $this->tonnage = $repository->getTonnageById($model->tonnage_id);
        $this->raw_type = $repository->getRawTypeById($model->raw_type_id);
        $this->price = $repository->getResultPrice($model->raw_type_id, $model->tonnage_id, $model->month_id);
        $this->table_data = json_encode($repository->getRawPricesByType($model->raw_type_id));
        $this->save();
    }


}