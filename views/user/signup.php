<?php
//
///** @var yii\web\View $this */
///** @var yii\bootstrap5\ActiveForm $form */
//
/** @var app\models\SignupForm $model */

//
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

//
$this->title = 'Регистрация';
//?>

    <div class="user-signup">
        <h1><?= Html::encode($this->title) ?></h1>

        <p>Пожалуйста, заполните поля ниже, чтобы зарегистрироваться:</p>

        <div class="row mt-5">
            <div class="col-lg-6">

                <?php $form = ActiveForm::begin([
                    'layout' => 'horizontal',
                    'id' => 'signup-form',
                    'fieldConfig' => [
                        'enableAjaxValidation' => true,
                        'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                        'horizontalCssClasses' => [
                            'label' => 'col-sm-3',
                            'offset' => 'col-sm-offset-4',
                            'wrapper' => 'col-sm-8',
                            'error' => '',
                            'hint' => '',
                        ],
                    ]]); ?>


                <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
                <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'password_repeat')->passwordInput() ?>



                <div class="form-group d-flex justify-content-between align-items-center">
                    <div>
                        <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-warning mt-2 mb-2 btn-block', 'name' => 'user-button']) ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>


<?php //= Html::checkbox('reveal-password', false, ['id' => 'reveal-password']) ?><!-- --><?php //= Html::label('Show password', 'reveal-password') ?>
    <!---->
<?php
//$this->registerJs("jQuery('#reveal-password').change(function(){jQuery('#signupform-password').attr('type',this.checked?'text':'password');})");
//?>