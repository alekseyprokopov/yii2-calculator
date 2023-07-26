<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;


/**
 * @property int $id
 * @property int $user_id
 * @property string $raw_type
 * @property string $month
 * @property int $tonnage
 * @property int $price
 * @property string $table_data
 */
class History extends ActiveRecord
{
    public static function tableName()
    {
        return 'history';
    }

    public function rules()
    {
        return [
            [['user_id', 'raw_type', 'month', 'tonnage', 'price', 'table_data'], 'required'],
            [['user_id', 'tonnage', 'price'], 'integer'],
            [['raw_type', 'month'], 'string', 'max' => 255],
            [['table_data'], 'string', 'max' => 1000]
        ];
    }

    public function getUsers()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getRawPrices()
    {
        return json_decode($this->table_data);
    }

    public function getUserName()
    {
        return User::find()->select('name')->where(['id' => $this->user_id])->scalar();
    }

    public function getCalculationData()
    {
        return User::find()->select('created_at')->where(['id' => $this->user_id])->scalar();
    }

    public function snapshot(CalculatorForm $model)
    {
        $repository = new PricesRepository();
        $this->user_id = Yii::$app->user->identity->getId();
        $this->month = $model->month;
        $this->tonnage = $model->tonnage;
        $this->raw_type = $model->raw_type;
        $this->price = $repository->getResultPrice($model->raw_type, $model->tonnage, $model->month);
        $this->table_data = json_encode($repository->getRawPricesByType($model->raw_type));
        $this->save();
    }


}