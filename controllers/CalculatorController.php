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
            $session = Yii::$app->session;
            $session->close();

            if (Yii::$app->user->isGuest === false) {
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






//if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
//            Yii::$app->response->format = Response::FORMAT_JSON;
//            return ActiveForm::validate($model);
//
//            //Save to Queue
//            $basePath = \Yii::getAlias('@runtime') . '/queue.job';
//            $data = $model->getAttributes();
//
//            if (file_exists($basePath)) {
//                unlink($basePath);
//            }
//
//            foreach ($data as $key => $value) {
//                file_put_contents($basePath, "{$key} => {$value}" . PHP_EOL, FILE_APPEND);
//            }