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

    public function actionCalculatePrice(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $repository = new PricesRepository();
        $model = new CalculatorForm();

        $model->load(Yii::$app->request->get(), '');
        $price = $repository->getResultPrice($model->raw_type, $model->tonnage, $model->month);

        if (isset($price) === false) {
            return ["error" => 404];
        }

        $priceList = $repository->getRawPricesByType($model->raw_type);
        return ['price' => $price, $model->raw_type => $priceList];
    }
}
