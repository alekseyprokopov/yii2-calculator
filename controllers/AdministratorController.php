<?php

namespace app\controllers;

use app\models\History;
use app\models\HistorySearch;
use app\models\PricesRepository;
use app\models\SignupForm;
use app\models\User;
use app\models\UserSearch;
use app\models\UserUpdateForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\CalculatorForm;
use yii\web\Response;
use yii\widgets\ActiveForm;

class AdministratorController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['user-management', 'delete-history', 'update-user', 'create-user'],
                        'allow' => true,
                        'roles' => ['adminPermission'],
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

    public function actionUserManagement()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('users', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }


    public function actionDeleteHistory($id)
    {
        History::findOne($id)->delete();
        return $this->redirect('history');
    }


    public function actionUpdateUser($id)
    {
        $user = User::findOne($id);
        $model = new UserUpdateForm($user);

        if ($model->load(Yii::$app->request->post())) {
            $model->updateProfile();
            return $this->redirect('users');
        }

        return $this->renderAjax('update-profile', [
            'model' => $model]);
    }

    public function actionUpdateUserValidation()
    {
        $model = new UserUpdateForm();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    }

    public function actionCreateUser()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            return $this->redirect('users');
        }
        return $this->renderAjax('//user/signup', [
            'model' => $model]);
    }

    public function actionDeleteUser($id)
    {
        User::findIdentity($id)->delete();
        return $this->redirect('users');
    }


}





