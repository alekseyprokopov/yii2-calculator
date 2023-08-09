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
        $data = Yii::$app->request->get();

        $repository = new PricesRepository();
        $model = new CalculatorForm();

        $model->month_id = $repository->getMonthIdByName($data['month']);
        $model->raw_type_id = $repository->getRawTypeIdByName($data['raw_type']);
        $model->tonnage_id = $repository->getTonnageIdByValue($data['tonnage']);;

        if ($model->validate()) {
            $price = $repository->getResultPrice($model->raw_type_id, $model->tonnage_id, $model->month_id);
            $priceList = $repository->getRawPricesByType($model->raw_type_id);
            return ['price' => $price, $data['raw_type'] => $priceList];
        }

        return ["error" => 404];
    }
}
