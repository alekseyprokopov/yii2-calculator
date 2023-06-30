<?php

namespace app\controllers;

use app\models\PricesRepository;
use yii\rest\ActiveController;
use Yii;
use yii\web\Response;

class ApiController extends ActiveController
{
    public $modelClass = 'app\models\CalculatorForm';

    public function actionCalculatePrice()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $repository = new PricesRepository(Yii::$app->params['prices']);

        $month = Yii::$app->request->get('month');
        $type = Yii::$app->request->get('raw_type');
        $tonnage = Yii::$app->request->get('tonnage');

        $price = $repository->getResultPrice($type, $tonnage, $month);

        if (isset($price) == false) {
            return Yii::$app->response->data = ["error" => 404];
        }

        $priceList = $repository->getRawPricesByType($type);
        return Yii::$app->response->data = ['price' => $price, $type => $priceList];
    }
}
