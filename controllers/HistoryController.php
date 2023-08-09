<?php

namespace app\controllers;

use app\models\History;
use app\models\HistorySearch;

use app\models\User;
use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class HistoryController extends Controller
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
        $searchModel = new HistorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * @throws ForbiddenHttpException
     */
    public function actionView($id)
    {
        $model = History::findOne($id);
        $owner_id = User::find()->select('id')->where(['email' => $model->email])->scalar();
        if (Yii::$app->user->can('viewProfile', ['owner_id' => $owner_id])) {
            return $this->renderAjax('view', ['model' => $model]);
        }
        throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));

    }

    public function actionDelete($id)
    {
        History::findOne($id)->delete();
        return $this->redirect('index');
    }

}