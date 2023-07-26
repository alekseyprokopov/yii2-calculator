<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var  UserUpdateForm $model */

use app\models\UserUpdateForm;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\Url;


$this->title = 'Редактировать профиль';
?>

<div class="update-profile">
    <section>
        <?php $form = ActiveForm::begin([
            'layout' => 'horizontal',
            'id' => 'update-profile-form',
            'validateOnBlur' => false,
            'enableAjaxValidation' => true,
            'validationUrl' => Url::toRoute('calculator/update-profile-validation'),
            'fieldConfig' => [
                'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                'horizontalCssClasses' => [
                    'label' => 'col-sm-3',
//                    'offset' => 'col-sm-offset-4',
                    'wrapper' => 'col-sm-9',
                    'error' => '',
                    'hint' => '',
                ],
            ]]); ?>
        <div class="container">
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
                            <?=
                            $form->field($model, 'role')
                                ->dropDownList(
                                    ['administrator' => 'Администратор', 'user' => 'Пользователь'],
                                    ['class' => 'role-input']
                                )->label(false);
                            ?>
                        </div>

                    </div>

                </div>
                <div class="col-lg-8">

                    <div class="card mb-4">
                        <div class="card-body">

                            <?= $form->field($model, 'id')->textInput([
                                'readonly' => true, 'class' => 'form-control-plaintext'
                            ]) ?>
                            <hr>
                            <?= $form->field($model, 'name')->textInput(['class' => 'form-control', 'autofocus' => false]) ?>


                            <hr>
                            <?= $form->field($model, 'email')->textInput(['autofocus' => false]) ?>

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
        <?php $form = ActiveForm::end() ?>

    </section>

</div>
<?php
$js = <<<JS
$('#update-profile-form').yiiActiveForm('remove', 'userupdateform-role');
JS;

$this->registerJs($js);

?>


