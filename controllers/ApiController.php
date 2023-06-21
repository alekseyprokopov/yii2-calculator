<?php

namespace app\controllers;

use yii\rest\ActiveController;
use Yii;
use yii\web\Controller;
use app\models\CalculatorForm;

class ApiController extends ActiveController
{
    public $modelClass = 'app\models\CalculatorForm';

    public function actionCalculatePrice()
    {
        $calculator = new CalculatorForm();

        $calculator->month = Yii::$app->request->get('month');
        $calculator->type = Yii::$app->request->get('raw_type');
        $calculator->tonnage = Yii::$app->request->get('tonnage');

        $price = $calculator->getPrice();

        if (isset($price) == false) {
            return json_encode(["error" => 404], JSON_UNESCAPED_UNICODE);
        }

        $priceList = $calculator->getRawPrice();
        return json_encode(['price' => $price, [$calculator->type => $priceList]], JSON_UNESCAPED_UNICODE);

    }
}
