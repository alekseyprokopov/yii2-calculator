<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var  app\models\History $model */

/** @var  app\models\PricesRepository $repository */

use yii\bootstrap5\Modal;

?>


<div class="site-result">

    <?php if (Yii::$app->user->can('adminPermission')): ?>
        <p>Имя пользователя: <?= $model->getUserName() ?></p>
    <?php endif; ?>

    <p>Cырье: <?= $model->raw_type ?></p>
    <p>Тоннаж: <?= $model->tonnage ?></p>
    <p>Месяц: <?= $model->month ?></p>
    <p>Дата выполнения расчёта: <?= date('d.m.Y H:i:s', strtotime($model->getCalculationData())) ?></p>

    <table class="table table-bordered border-warning table-hover bg-transparent">
        <thead>
        <tr>
            <?
            $months = [];
            $tableRows = [];

            foreach ($model->getRawPrices() as $month => $item) {
                $months[] = "<th scope='col'>  " . $month . "  </th>";
                foreach ($item as $tonnage => $price) {
                    $tableRows['<th scope="row">' . $tonnage . '</th>'][] =
                        '<td '
                        . (($tonnage === (string)$model->tonnage && $month === $model->month) ? 'class="bg-warning">' : '>')
                        . $price . '</td>';
                }
            }
            ?>
            <th scope="col">#</th>
            <?= join('', $months) ?>
        </tr>
        </thead>
        <tbody>

        <?php foreach ($tableRows as $tonnage => $prices): ?>
            <tr>
                <?= $tonnage ?>
                <?= join('', $prices) ?>
            </tr>
        <?php endforeach; ?>

        </tbody>
    </table>
    <p>ИТОГО:
        <b><?= $model->price . ' тыс. руб.' ?> </b>
    </p>
</div>
