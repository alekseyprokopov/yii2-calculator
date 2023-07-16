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
                        <?= $repository->getResultPrice($model->raw_type, $tonnage, $month) ?></td>
                <?php endforeach; ?>

            </tr>
        <?php endforeach; ?>

        </tbody>
    </table>
    <p>ИТОГО:
        <b><?= $repository->getResultPrice($model->raw_type, $model->tonnage, $model->month) . ' тыс. руб.' ?> </b>
    </p>
</div>
<?php Modal::end() ?>
