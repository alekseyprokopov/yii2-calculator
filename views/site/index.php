<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var  app\models\CalculatorForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;


$this->title = 'Калькулятор';
?>

<div class="site-index">
    <div class="row ">
        <h1><?= Html::encode($this->title) ?></h1>
        <p>Пожалуйста, заполните все поля для отправки:</p>

        <!--        --><?php //Pjax::begin() ?>
        <?php $form = ActiveForm::begin([
            'id' => 'calculator-form',
            'enableClientValidation' => true,
            "options" => [
                'class' => 'col-lg-5',
//                'data-pjax' => true,
            ],
        ]); ?>

        <?= $form->field($model, 'type')
            ->dropDownList([
                'шрот' => 'шрот',
                'жмых' => 'жмых',
                'соя' => 'соя',
            ], [
                'prompt' => 'Не выбрано'
            ]) ?>

        <?= $form->field($model, 'tonnage')
            ->dropDownList([
                '25' => '25',
                '50' => '50',
                '75' => '75',
                '100' => '100',
            ], [
                'prompt' => 'Не выбрано'
            ]) ?>

        <?= $form->field($model, 'month')
            ->dropDownList([
                'январь' => 'январь',
                'февраль' => 'февраль',
                'август' => 'август',
                'сентябрь' => 'сентябрь',
                'октябрь' => 'октябрь',
                'ноябрь' => 'ноябрь',
            ], [
                'prompt' => 'Не выбрано'
            ]) ?>

        <div class="mb-2">
            <?= Html::submitButton('Рассчитать', ['class' => 'btn btn-warning mt-2 btn-block', 'name' => 'calculator-button', 'data-bs-toggle' => Yii::$app->session->hasFlash('success') ? 'modal' : '', 'data-bs-target' => Yii::$app->session->hasFlash('success') ? '#calculateForm' : '']) ?>
        </div>

        <?php $form = ActiveForm::end() ?>
    </div>

</div>

