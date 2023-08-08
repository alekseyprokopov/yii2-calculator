<?php

namespace app\controllers;

use app\models\History;
use app\models\PricesRepository;
use app\models\CalculatorForm;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

class CalculatorController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $model = new CalculatorForm();
        $repository = new PricesRepository();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {

            if (Yii::$app->user->isGuest === false) {
//                $model->saveToQueue();
                $history = new History();
                $history->snapshot($model);
            };

            return $this->renderAjax('result', [
                'model' => $model,
                'repository' => $repository,
            ]);
        }

        return $this->render('index', [
            'model' => $model,
            'repository' => $repository,
        ]);
    }

    public function actionCalculatorValidation()
    {
        $model = new CalculatorForm();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    }

}
