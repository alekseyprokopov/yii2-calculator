<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var  app\models\CalculatorForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Modal;

$prices = require '../config/prices.php';
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


        <?php if (empty($model->type) === false): ?>
        <?php 
        Modal::begin([
            'title' => 'Расчет',
            'toggleButton' => ['label' => 'click me'],
            'size' => Modal::SIZE_LARGE,
            'options' => ['class' => 'text-dark']
        ]);
        // dd($prices);
        ?>
    <div class="site-result">
    <p>Cырье: <?= $model['type'] ?></p>
    <p>Месяц: <?= $model['month'] ?></p>
    <p>Тоннаж: <?= $model['tonnage'] ?></p>

    <table class="table table-bordered border-warning table-hover bg-transparent">
        <thead>
        <tr>
            <th scope="col">#</th>
            <?php foreach ($prices[$model['type']][$model['tonnage']] as $month => $value): ?>
                <th scope="col"><?= $month ?></th>
            <?php endforeach; ?>
        </tr>
        </thead>
        <tbody>


        <?php foreach ($prices[$model['type']] as $tonnage => $value): ?>
            <tr>
                <th scope="row"><?= $tonnage ?></th>

                <?php foreach ($prices[$model['type']][$tonnage] as $month => $value): ?>
                    <td
                        <?php if ($tonnage === (int)$model['tonnage'] && $month === $model['month']): ?> class="bg-warning") <?php endif; ?>>
                        <?= $value ?></td>
                <?php endforeach; ?>


            </tr>
        <?php endforeach; ?>


        </tbody>
    </table>
    <p>ИТОГО: <?= $prices[$model['type']][$model['tonnage']][$model['month']] . ' тыс. руб.'?></p>

</div>

        <?php Modal::end() ?>
        <?endif; ?>
    </div>

</div>

