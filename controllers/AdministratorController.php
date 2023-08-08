<?php

namespace app\controllers;

use app\models\SignupForm;
use app\models\User;
use app\models\UserUpdateForm;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

class AdministratorController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionUpdateUser($id)
    {
        $user = User::findOne($id);
        $model = new UserUpdateForm($user);

        if ($model->load(Yii::$app->request->post())) {
            $model->updateProfile();
            return $this->redirect('/admin/user');
        }

        return $this->renderAjax('user/update', [
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
            return $this->redirect('/admin/user');
        }
        return $this->renderAjax('user/create', [
            'model' => $model]);
    }


}





