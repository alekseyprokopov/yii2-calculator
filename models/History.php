<?php

namespace app\models;

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

}