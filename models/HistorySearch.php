<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
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
class HistorySearch extends History
{
    public static function tableName()
    {
        return 'history';
    }

    public function rules()
    {
        return [
            [['tonnage'], 'integer'],
            [['month', 'raw_type'], 'safe'],
        ];
    }

    public function search($params)
    {
        $isAdmin = Yii::$app->user->can('administrator');
        $query = $isAdmin ? History::find() : History::find()->where(['user_id' => Yii::$app->user->identity->getId()]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        // load the search form data and validate
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // adjust the query by adding the filters
        $query->andFilterWhere(['like', 'tonnage', $this->tonnage])
            ->andFilterWhere(['like', 'month', $this->month])
            ->andFilterWhere(['like', 'raw_type', $this->raw_type]);

        return $dataProvider;
    }

}