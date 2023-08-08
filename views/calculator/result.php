<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var  app\models\CalculatorForm $model */

/** @var  app\models\PricesRepository $repository */

use yii\bootstrap5\Modal;

?>

<?php
$selectedRawType = $repository->getRawTypeById($model->raw_type_id);
$selectedTonnage = $repository->getTonnageById($model->tonnage_id);
$selectedMonth = $repository->getMonthById($model->month_id);
?>
<div class="site-result">
    <p>Cырье: <?= $selectedRawType ?></p>
    <p>Тоннаж: <?= $selectedTonnage ?></p>
    <p>Месяц: <?= $selectedMonth ?></p>

    <table class="table table-bordered border-warning table-hover bg-transparent">
        <thead>
        <tr>
            <?
            $months = [];
            $tableRows = [];

            foreach ($repository->getRawPricesByType($model->raw_type_id) as $month => $item) {
                $months[] = "<th scope='col'>  " . $month . "  </th>";
                foreach ($item as $tonnage => $price) {
                    $tableRows['<th scope="row">' . $tonnage . '</th>'][] =
                        '<td '
                        . (((string)$tonnage === $selectedTonnage && $month === $selectedMonth) ? 'class="bg-warning">' : '>')
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
        <b><?= $repository->getResultPrice($model->raw_type_id, $model->tonnage_id, $model->month_id) . ' тыс. руб.' ?> </b>
    </p>
</div>
