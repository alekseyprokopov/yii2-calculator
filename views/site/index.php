<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var  app\models\CalculatorForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Modal;

$types = $model->getRawTypes();
$tonnages = $model->getTonnages();
$months = $model->getMonths();

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
                    <p>Cырье: <?= $model->getType() ?></p>
                    <p>Месяц: <?= $model->getMonth() ?></p>
                    <p>Тоннаж: <?= $model->getTonnage() ?></p>

                    <table class="table table-bordered border-warning table-hover bg-transparent">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <?php foreach ($months as $month): ?>
                                <th scope="col"><?= $month ?></th>
                            <?php endforeach; ?>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($tonnages as $tonnage): ?>
                            <tr>
                                <th scope="row"><?= $tonnage ?></th>
                                <?php foreach ($months as $month): ?>
                                    <td
                                        <?php if ($model->isCorrectPrice($tonnage, $month)): ?> class="bg-warning") <?php endif; ?>>
                                        <?= $model->getMonthPrice($tonnage, $month) ?></td>
                                <?php endforeach; ?>

                            </tr>
                        <?php endforeach; ?>

                        </tbody>
                    </table>
                    <p>ИТОГО: <b><?= $model->getPrice() . ' тыс. руб.' ?> </b>
                    </p>
                </div>
                <?php Modal::widget();
                Modal::end() ?>
            <? endif; ?>
        </div>

        <?php $form = ActiveForm::end() ?>
    </div>

</div>

