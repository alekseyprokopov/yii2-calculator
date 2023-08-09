<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var  UserUpdateForm $model */

use app\models\UserUpdateForm;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\Url;


$this->title = 'Создать пользователя';
?>

<section class="ftco-section">
    <div class="container">

        <div class="row justify-content-center">
            <div>
                <div class="login-wrap ">

                    <?php $form = ActiveForm::begin([
                        'id' => 'create-user-form',
                        'enableAjaxValidation' => true,
                        'validationUrl' => Url::toRoute('//user/signup-validation'),
                    ]); ?>

                    <?= $form->field($model, 'email')->textInput(['autofocus' => true])->input('email', ['placeholder' => "Email"])->label(false) ?>
                    <?= $form->field($model, 'username')->textInput(['autofocus' => true])->input('text', ['placeholder' => "Имя"])->label(false) ?>
                    <?= $form->field($model, 'password')->passwordInput()->input('password', ['placeholder' => "Пароль"])->label(false) ?>
                    <?= $form->field($model, 'password_repeat')->passwordInput()->input('password', ['placeholder' => "Повторите пароль"])->label(false) ?>

                    <hr>

                    <div class="d-grid gap-2 mb-3">
                        <?= Html::submitButton('Создать пользователя', ['class' => 'btn btn-warning  btn-block ', 'name' => 'user-button']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</section>



