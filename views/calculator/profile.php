<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var  app\models\CalculatorForm $model */

/** @var  app\models\PricesRepository $repository */

use yii\bootstrap5\Html;


$this->title = 'Профиль';
?>

<div class="calculator-profile">
    <h1><?= Html::encode($this->title) ?></h1>

    <section >
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp"
                                 alt="avatar"
                                 class="rounded-circle img-fluid" style="width: 150px;">
                            <h5 class="my-3"><?= Yii::$app->user->identity->name ?></h5>
                            <p class="text-muted mb-2"><?= Yii::$app->user->can('adminPermission') ? 'Администратор' : 'Пользователь' ?></p>
                            <?= Html::a('Журнал расчётов', ['calculator/history'], ['class' => 'btn btn-primary mb-2']) ?>
                            <?= Html::beginForm(['user/logout']) . Html::submitButton('Выход', ['class' => 'btn btn-danger']) . Html::endForm() ?>

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
                                    <p class="text-muted mb-0"><?= Yii::$app->user->identity->name ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Email</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?= Yii::$app->user->identity->email ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Дата регистрации</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?= date('d.m.Y', strtotime(Yii::$app->user->identity->getRegistrationData())) ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Количество расчётов</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?= Yii::$app->user->identity->getCalculationsCount() ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </section>

</div>



