<?php

namespace app\controllers;

use app\models\History;
use app\models\HistorySearch;
use app\models\PricesRepository;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\CalculatorForm;
use yii\web\Response;
use yii\widgets\ActiveForm;

class CalculatorController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'validation'],
                        'allow' => true,
                        'roles' => ['performCalculation'],
                    ],
                    [
                        'actions' => ['history', 'profile'],
                        'allow' => true,
                        'roles' => ['writeHistory'],
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
            //snapshot

            if (Yii::$app->user->can('writeHistory')) {
                $history = new History();

                $history->user_id = Yii::$app->user->identity->getId();
                $history->month = $model->month;
                $history->tonnage = $model->tonnage;
                $history->raw_type = $model->raw_type;
                $history->price = $repository->getResultPrice($model->raw_type, $model->tonnage, $model->month);
                $history->table_data = json_encode($repository->getRawPricesByType($model->raw_type));
                $history->save();
//
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


    public function actionHistory()
    {
        $searchModel = new HistorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('history', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }


    public function actionProfile()
    {
        return $this->render('profile');
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