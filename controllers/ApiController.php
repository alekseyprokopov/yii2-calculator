<?php

namespace app\controllers;

use app\models\PricesRepository;
use yii\rest\ActiveController;
use Yii;

class ApiController extends ActiveController
{
    public $modelClass = 'app\models\CalculatorForm';

    public function actionCalculatePrice()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $data = require '../config/prices.php';
        $pricesRep = new PricesRepository($data);

        $month = Yii::$app->request->get('month');
        $type = Yii::$app->request->get('raw_type');
        $tonnage = Yii::$app->request->get('tonnage');

        $price = $pricesRep->getPrice($type, $tonnage, $month);

        if (isset($price) == false) {
            return json_encode(["error" => 404], JSON_UNESCAPED_UNICODE);
        }

        $priceList = $pricesRep->getRawPricesByType($type);
        return json_encode(['price' => $price, $type => $priceList], JSON_UNESCAPED_UNICODE);
    }
}
