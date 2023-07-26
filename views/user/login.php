<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Вход';
?>
<div class="user-login text-light">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Пожалуйста, заполните поля ниже, чтобы войти:</p>

    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin([
                'id' => 'user-form',
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'labelOptions' => ['class' => 'col-lg-3 col-form-label mr-lg-3'],
                    'inputOptions' => ['class' => 'col-lg-3 form-control'],
                    'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
                ],
            ]); ?>

            <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'rememberMe')->checkbox([
                'template' => "<div class=\"custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
            ]) ?>

            <div class="form-group d-flex justify-content-between align-items-center">
                <div>
                    <?= Html::submitButton('Вход', ['class' => 'btn btn-warning mt-2 btn-block', 'name' => 'user-button']) ?>
                </div>
                <?= Html::a('Регистрация', ['user/signup'], ['class' => 'btn btn-success mt-2 link-light']) ?>
            </div>
            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
