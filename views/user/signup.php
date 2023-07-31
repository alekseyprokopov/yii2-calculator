<?php

/** @var app\models\SignupForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\Url;

$this->title = 'Регистрация';
?>

<section class="ftco-section">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="login-wrap p-4 p-md-5">
                    <h2 class="text-center mb-4"><?= Html::encode($this->title) ?></h2>
                    <?php $form = ActiveForm::begin([
                        'id' => 'user-form',
                        'enableAjaxValidation' => true,
                        'validationUrl' => Url::toRoute('/user/signup-validation'),]); ?>
                    <?= $form->field($model, 'email')->textInput(['autofocus' => true])->input('email', ['placeholder' => "Email"])->label(false) ?>
                    <?= $form->field($model, 'username')->textInput(['autofocus' => true])->input('text', ['placeholder' => "Имя"])->label(false) ?>
                    <?= $form->field($model, 'password')->passwordInput()->input('password', ['placeholder' => "Пароль"])->label(false) ?>
                    <?= $form->field($model, 'password_repeat')->passwordInput()->input('password', ['placeholder' => "Повторите пароль"])->label(false) ?>
                    <hr>
                    <div class="d-grid gap-2 mb-3">
                        <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-warning  btn-block ', 'name' => 'user-button']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</section>

