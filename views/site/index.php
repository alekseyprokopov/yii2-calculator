<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var  app\models\CalculatorForm $model */

/** @var  app\models\PricesRepository $repository */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Modal;

$this->title = 'Калькулятор стоимости доставки сырья';
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

        <?=
        $form->field($model, 'type')
            ->dropDownList(
                $repository->getRawTypesList(),
                ['prompt' => 'Не выбрано'],
            );
        ?>

        <?=
        $form->field($model, 'tonnage')
            ->dropDownList(
                $repository->getTonnagesList(),
                ['prompt' => 'Не выбрано'],
            );
        ?>

        <?=
        $form->field($model, 'month')
            ->dropDownList(
                $repository->getMonthsList(),
                ['prompt' => 'Не выбрано']
            );
        ?>

        <div class="mb-2 d-flex justify-content-between">
            <?= Html::submitButton('Рассчитать', ['class' => 'btn btn-warning mt-2 btn-block',
                'name' => 'calculator-button']) ?>

            <?php if (empty($model->type) === false): ?>
                <?php
                Modal::begin(['title' => 'Расчет',
                    'toggleButton' => ['label' => 'Посмотреть результат', 'class' => 'btn btn-success mt-2 btn-block'],
                    'size' => Modal::SIZE_LARGE,
                    'options' => ['class' => 'text-dark']]);
                ?>
                <div class="site-result">
                    <p>Cырье: <?= $model->type ?></p>
                    <p>Тоннаж: <?= $model->tonnage ?></p>
                    <p>Месяц: <?= $model->month ?></p>

                    <table class="table table-bordered border-warning table-hover bg-transparent">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <?php foreach ($repository->getMonthsList() as $month): ?>
                                <th scope="col"><?= $month ?></th>
                            <?php endforeach; ?>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($repository->getTonnagesList() as $tonnage): ?>
                            <tr>
                                <th scope="row"><?= $tonnage ?></th>
                                <?php foreach ($repository->getMonthsList() as $month): ?>
                                    <td
                                        <?php if ((string)$tonnage === $model->tonnage && $month === $model->month): ?> class="bg-warning") <?php endif; ?>>
                                        <?= $repository->getResultPrice($model->type, $tonnage, $month) ?></td>
                                <?php endforeach; ?>

                            </tr>
                        <?php endforeach; ?>

                        </tbody>
                    </table>
                    <p>ИТОГО:
                        <b><?= $repository->getResultPrice($model->type, $model->tonnage, $model->month) . ' тыс. руб.' ?> </b>
                    </p>
                </div>
                <?php Modal::widget();
                Modal::end() ?>
            <?php endif; ?>
        </div>

        <?php $form = ActiveForm::end() ?>
    </div>

</div>


