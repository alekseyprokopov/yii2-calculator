<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var  app\models\CalculatorForm $model */

/** @var  app\models\PricesRepository $repository */

use yii\bootstrap5\Modal;

?>



<?php
Modal::begin(['title' => 'Расчет',
    'id' => 'resultModal',
    'size' => Modal::SIZE_LARGE,
    'clientOptions' => ['show' => true],
    'options' => ['class' => 'text-dark']]);

?>
<div class="site-result">
    <p>Cырье: <?= $model->raw_type ?></p>
    <p>Тоннаж: <?= $model->tonnage ?></p>
    <p>Месяц: <?= $model->month ?></p>

    <table class="table table-bordered border-warning table-hover bg-transparent">
        <thead>
        <tr>
            <?
            $months = [];
            $tableRows = [];

            foreach ($repository->getRawPricesByType($model->raw_type) as $month => $item) {
                $months[] = "<th scope='col'>  " . $month . "  </th>";
                foreach ($item as $tonnage => $price) {
                    $tableRows['<th scope="row">' . $tonnage . '</th>'][] =
                        '<td '
                        . (((string)$tonnage === $model->tonnage && $month === $model->month) ? 'class="bg-warning">' : '>')
                        . $price . '</td>';;
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
        <b><?= $repository->getResultPrice($model->raw_type, $model->tonnage, $model->month) . ' тыс. руб.' ?> </b>
    </p>
</div>
<?php Modal::end() ?>
