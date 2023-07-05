<?php

namespace app\controllers;

use app\models\CalculatorForm;
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
        $model = new CalculatorForm();
        
        $model->load(Yii::$app->request->get(), '');
        $price = $repository->getResultPrice($model->type, $model->tonnage, $model->month);

        if (isset($price) == false) {
            return Yii::$app->response->data = ["error" => 404];
        }

        $priceList = $repository->getRawPricesByType($model->type);
        return Yii::$app->response->data = ['price' => $price, $model->type => $priceList];
    }
}
