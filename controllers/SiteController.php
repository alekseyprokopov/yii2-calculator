<?php

namespace app\controllers;

use app\models\PricesRepository;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\CalculatorForm;
use yii\web\Response;
use yii\widgets\ActiveForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new CalculatorForm();
        $repository = new PricesRepository();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
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



    public function actionValidation()
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