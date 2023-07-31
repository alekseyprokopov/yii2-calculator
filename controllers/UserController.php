<?php

namespace app\controllers;

use app\models\LoginForm;
use app\models\SignupForm;
use app\models\User;

use Yii;

use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

class UserController extends Controller
{

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            Yii::$app->session->setFlash('success-login', $model->user->username);
            return $this->goHome();
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionSignup()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            return $this->redirect('login');
        }

        return $this->render('signup', ['model' => $model]);
    }

    public function actionSignupValidation()
    {
        $model = new SignupForm();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    }


    /**
     * @throws ForbiddenHttpException
     */
    public function actionProfile($id)
    {
        if (Yii::$app->user->can('viewProfile', ['owner_id' => $id])) {
            $model = User::findIdentity($id);
            return $this->render('profile', ['model' => $model]);
        }
        throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));

    }

    public function actionAdmin()
    {
        $user = new User();
        $user->username = 'admin';
        $user->email = 'admin@mail.ru';
        $user->password_hash = Yii::$app->security->generatePasswordHash('admin');
        $user->save();

        $auth = Yii::$app->authManager;
        $userRole = $auth->getRole('administrator');
        $auth->assign($userRole, $user->getId());
        echo 'success';
    }
}



