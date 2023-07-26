<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var  User $model */

use app\models\User;
use yii\bootstrap5\Html;


$this->title = 'Информация';
?>

<div class="calculator-profile">
    <h1><?= Html::encode($this->title) ?></h1>


    <section>
        <div class="container py-4">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <img src=
                                 <?= Yii::$app->authManager->checkAccess($model->id, 'adminPermission') ?
                                     "https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1.webp" :
                                     "https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp" ?>
                                 alt="avatar"
                                 class="rounded-circle img-fluid" style="width: 150px;">
                            <h5 class="my-3"><?= $model->name ?></h5>
                            <p class="text-muted mb-2"><?= Yii::$app->authManager->checkAccess($model->id, 'adminPermission') ? 'Администратор' : 'Пользователь' ?></p>
                                <?= Html::a('Журнал расчётов', ['calculator/history'], ['class' => 'btn btn-primary mb-2']) ?>
                                <?=Html::beginForm(['user/logout']) . Html::submitButton('Выход', ['class' => 'btn btn-danger']) . Html::endForm() ?>
                        </div>

                    </div>

                </div>
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Имя</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?= $model->name ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Email</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?= $model->email ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">ID</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?= $model->id ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Дата регистрации</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?= date('d.m.Y', strtotime($model->getRegistrationData())) ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Количество расчётов</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?= $model->getCalculationsCount() ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </section>

</div>



