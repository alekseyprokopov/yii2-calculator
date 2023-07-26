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
                        'template' => '{delete}',
                        'visible' => Yii::$app->user->can('adminPermission'),
                        'urlCreator' => function ($action, $model, $key, $index) {
                            return [$action . '-history', 'id' => $model->id,];
                        },

                    ]
                    // ...
                ],
            ]) ?>
            <div class="modal fade" id="modalContent" tabindex="-1" aria-labelledby="modalContent" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalContentLabel">Информация</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

<?php
$js = <<<JS

    $('.grid-view tbody tr td:not(:last-child)').on('click', function (){
        console.log('succ')
        let data = $(this).closest('tr').attr('data-key')
        $('#modalContent').find('.modal-title').text('ID расчёта: ' +data)
        $('#modalContent').find('.modal-body').load('/calculator/history-result?id=' + data, function() {
        })
        $('.modal-footer').find('input').attr('form','update-profile-form')
        $('#modalContent').modal('show')
        return false;
    })
    
       
 

JS;

$this->registerJs($js);

?>