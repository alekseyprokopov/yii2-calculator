<?php
//not in use


//
///** @var yii\web\View $this */
//
///** @var  app\models\CalculatorForm $model */
//
//
//use yii\helpers\Html;
//
//$prices = require '../config/prices.php';
//
//$this->title = 'Результат:';
////$this->params['breadcrumbs'][] = $this->title;
//?>
<!--<div class="site-result">-->
<!--    <h1>--><?php //= Html::encode($this->title) ?><!--</h1>-->
<!--    <p>Cырье: --><?php //= $model['type'] ?><!--</p>-->
<!--    <p>Месяц: --><?php //= $model['month'] ?><!--</p>-->
<!--    <p>Тоннаж: --><?php //= $model['tonnage'] ?><!--</p>-->
<!---->
<!--    <table class="table table-bordered border-warning table-hover bg-transparent">-->
<!--        <thead>-->
<!--        <tr>-->
<!--            <th scope="col">#</th>-->
<!--            --><?php //foreach ($prices[$model['type']][$model['tonnage']] as $month => $value): ?>
<!--                <th scope="col">--><?php //= $month ?><!--</th>-->
<!--            --><?php //endforeach; ?>
<!--        </tr>-->
<!--        </thead>-->
<!--        <tbody>-->
<!---->
<!---->
<!--        --><?php //foreach ($prices[$model['type']] as $tonnage => $value): ?>
<!--            <tr>-->
<!--                <th scope="row">--><?php //= $tonnage ?><!--</th>-->
<!---->
<!--                --><?php //foreach ($prices[$model['type']][$tonnage] as $month => $value): ?>
<!--                    <td-->
<!--                        --><?php //if ($tonnage === (int)$model['tonnage'] && $month === $model['month']): ?><!-- class="bg-warning") --><?php //endif; ?><!-->-->
<!--                        --><?php //= $value ?><!--</td>-->
<!--                --><?php //endforeach; ?>
<!---->
<!---->
<!--            </tr>-->
<!--        --><?php //endforeach; ?>
<!---->
<!---->
<!--        </tbody>-->
<!--    </table>-->
<!--    <p>ИТОГО: --><?php //= $prices[$model['type']][$model['tonnage']][$model['month']] . ' тыс. руб.'?><!--</p>-->
<!---->
<!--</div>-->