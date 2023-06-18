<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var  app\models\CalculatorForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Modal;

$prices = require '../config/prices.php';
$types = array_keys($prices);
$tonnages = array_keys($prices[array_rand($prices)]);
$months = array_keys($prices[array_rand($prices)][$tonnages[array_rand($tonnages)]]);

$this->title = 'Калькулятор';
?>

<div class="site-index">
    <div class="row ">
        <h1><?= Html::encode($this->title) ?></h1>
        <p>Пожалуйста, заполните все поля для отправки:</p>

        <?php $form = ActiveForm::begin([
            'id' => 'calculator-form',
            'enableClientValidation' => true,
            "options" => ['class' => 'col-lg-5'],
        ]); ?>

        <?= $form->field($model, 'type')->dropDownList(array_combine($types, $types), [
            'prompt' => 'Не выбрано'
        ]) ?>

        <?= $form->field($model, 'tonnage')->dropDownList(array_combine($tonnages, $tonnages), [
            'prompt' => 'Не выбрано'
        ]) ?>

        <?= $form->field($model, 'month')->dropDownList(array_combine($months, $months), [
            'prompt' => 'Не выбрано'
        ]) ?>

        <div class="mb-2 d-flex justify-content-between">
            <?= Html::submitButton('Рассчитать', [
                'class' => 'btn btn-warning mt-2 btn-block',
                'name' => 'calculator-button'
            ]) ?>
            <?php if (empty($model->type) === false): ?>
                <?php
                Modal::begin([
                    'title' => 'Расчет',
                    'toggleButton' => ['label' => 'Посмотреть результат', 'class' => 'btn btn-success mt-2 btn-block'],
                    'size' => Modal::SIZE_LARGE,
                    'options' => ['class' => 'text-dark']
                ]);
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

                        <?php foreach ($tonnages as $tonnage): ?>
                            <tr>
                                <th scope="row"><?= $tonnage ?></th>
                                <?php foreach ($prices[$model['type']][$tonnage] as $month => $value): ?>
                                    <td
                                        <?php if ((string)$tonnage === $model['tonnage'] && $month === $model['month']): ?> class="bg-warning") <?php endif; ?>>
                                        <?= $value ?></td>
                                <?php endforeach; ?>

                            </tr>
                        <?php endforeach; ?>

                        </tbody>
                    </table>
                    <p>ИТОГО: <b><?= $prices[$model['type']][$model['tonnage']][$model['month']] . ' тыс. руб.' ?> </b>
                    </p>
                </div>
                <?php Modal::widget();
                Modal::end() ?>
            <? endif; ?>
        </div>

        <?php $form = ActiveForm::end() ?>
    </div>

</div>

