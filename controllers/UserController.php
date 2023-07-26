<?php

namespace app\controllers;

use app\models\LoginForm;
use app\models\SignupForm;
use app\models\User;

use Yii;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'signup', 'signup-validation'],
                        'allow' => true,
                        'roles' => ['guest'],
                    ],
                    [
                        'actions' => ['logout', 'profile'],
                        'allow' => true,
                        'roles' => ['user'],
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'signup' => ['get', 'post'],
                    'login' => ['get', 'post'],
                    'logout' => ['post'],
                    'signup-validation' => ['post'],
                ],
            ],
        ];
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            Yii::$app->session->setFlash('success-login', $model->user->name);
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


    public function actionProfile($id)
    {
        $model = User::findIdentity($id);

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('profile', [
                'model' => $model,
            ]);
        }

        return $this->render('profile', ['model' => $model]);
    }

    public function actionAdmin()
    {
        $user = new User();
        $user->name = 'admin1';
        $user->email = 'admin1@mail.ru';
        $user->password = Yii::$app->security->generatePasswordHash('admin1');
        $user->save();

//            assign role
        $auth = Yii::$app->authManager;
        $userRole = $auth->getRole('administrator');
        $auth->assign($userRole, $user->getId());
        echo 'success';
    }
}



