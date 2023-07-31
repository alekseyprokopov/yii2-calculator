<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Авторизация';
?>
<section class="ftco-section">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="login-wrap p-4 p-md-5">

                    <h2 class="text-center mb-4"><?= Html::encode($this->title) ?></h2>
                    <?php $form = ActiveForm::begin([
                        'id' => 'user-form',

                    ]); ?>

                    <?= $form->field($model, 'email')->textInput(['autofocus' => true])->input('email', ['placeholder' => "Email"])->label(false) ?>

                    <?= $form->field($model, 'password')->passwordInput()->input('password', ['placeholder' => "Пароль"])->label(false) ?>

                    <?= $form->field($model, 'rememberMe')->checkbox([
                        'template' => "<div class=\"custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
                    ]) ?>
                    <div class="d-grid gap-2 mb-3">
                        <?= Html::submitButton('Войти', ['class' => 'btn btn-warning  btn-block ', 'name' => 'user-button']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                    <div>
                        <p class="mb-0  text-end">Нет
                            аккаунта? <?= Html::a('Зарегистрируйтесь', ['user/signup'], ['class' => 'link-warning fw-bold']) ?> </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

