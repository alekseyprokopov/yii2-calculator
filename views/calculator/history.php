<?php

/** @var yii\web\View $this */

/** @var $dataProvider */

/** @var $searchModel */

use yii\bootstrap5\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;

$this->title = 'Журнал расчетов'
?>

<div class="calculator-history">
    <div class="row">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'tableOptions' => ['class' => 'table table-bordered  table-hover'],
            'layout' => "{pager}\n{summary}\n{items}",
            'pager' => [
                'class' => 'yii\bootstrap5\LinkPager'
            ],
            'columns' => [
                [
                    'attribute' => 'id',
                    'label' => 'ID',
                    'filter' => false,
                    'sortLinkOptions' => ['class' => 'link-warning link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover'],

                ],
                [
                    'attribute' => 'user_id',
                    'value' => 'users.name',
                    'label' => 'Имя пользователя',
                    'filter' => false,
                    'visible' => Yii::$app->user->can('adminPermission'),
                    'sortLinkOptions' => ['class' => 'link-warning link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover'],

                ],
                [
                    'attribute' => 'raw_type',
                    'label' => 'Тип сырья',
                    'sortLinkOptions' => ['class' => 'link-warning link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover'],

                ],
                [
                    'attribute' => 'month',
                    'label' => 'Месяц',
                    'sortLinkOptions' => ['class' => 'link-warning link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover'],
                ],
                [
                    'attribute' => 'tonnage',
                    'label' => 'Тоннаж',
                    'sortLinkOptions' => ['class' => 'link-warning link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover'],
                ],
                [
                    'attribute' => 'price',
                    'label' => 'Стоимость доставки',
                    'filter' => false,
                    'sortLinkOptions' => ['class' => 'link-warning link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover'],
                ],
                [
                    'attribute' => 'created_at',
                    'format' => ['date', 'php:d-m-Y H:i:s'],
                    'label' => 'Дата',
                    'sortLinkOptions' => ['class' => 'link-warning link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover'],
                ],
                [
                    'class' => ActionColumn::class,
                    'template' => Yii::$app->user->can('adminPermission') ? '{view} {delete}' : '{view}'
                ]
                // ...
            ],
        ]) ?>


    </div>

</div>