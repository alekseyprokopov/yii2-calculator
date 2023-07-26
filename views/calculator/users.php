<?php

/** @var yii\web\View $this */

/** @var $dataProvider */

/** @var $searchModel */

use app\models\User;
use yii\bootstrap5\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\helpers\Url;

$this->title = 'Управление пользователями'
?>

    <div class="calculator-users">
        <div class="row">
            <h1><?= Html::encode($this->title) ?></h1>
            <p>
                <button type="button" class="btn btn-success create-user-button">Создать пользователя</button>
            </p>

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
                        'sortLinkOptions' => ['class' => 'link-warning link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover'],

                    ],
                    [
                        'attribute' => 'name',
                        'label' => 'Имя пользователя',
                        'sortLinkOptions' => ['class' => 'link-warning link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover'],

                    ],
                    [
                        'attribute' => 'email',
                        'label' => 'E-mail',
                        'sortLinkOptions' => ['class' => 'link-warning link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover'],

                    ],
                    [
                        'label' => 'Роль',
                        'value' => function ($model) {
                            $roles = ['administrator' => 'Администратор', 'user' => 'Пользователь'];
                            return $roles[User::getRoleById($model->id)];
                        },
                        'sortLinkOptions' => ['class' => 'link-warning link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover'],
                    ],
                    [
                        'attribute' => 'calculationsCount',
                        'label' => 'Количество расчётов',
                        'sortLinkOptions' => ['class' => 'link-warning link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover'],
                    ],
                    [
                        'attribute' => 'created_at',
                        'format' => ['date', 'php:d-m-Y H:i:s'],
                        'label' => 'Дата регистрации',
                        'sortLinkOptions' => ['class' => 'link-warning link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover'],
                    ],
                    [
                        'class' => ActionColumn::class,
                        'template' => '{delete}',
                        'urlCreator' => function ($action, $model, $key, $index) {
                            return [$action . '-user', 'id' => $model->id,];
                        },

                    ]
                    // ...
                ],
            ]) ?>
            <!--            <div id="modal-content"></div> DELETE THIS!!!!-->


        </div>

        <div class="modal fade" id="modalContent" tabindex="-1" aria-labelledby="modalContent" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalContentLabel">Информация</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ...

                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" form="from jquery" value="Сохранить изменения"/>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

<?php
$js = <<<JS

    $('.grid-view tbody tr td:not(:last-child)').on('click', function (){
        let data = $(this).closest('tr').attr('data-key')
        $('#modalContent').find('.modal-title').text('Информация')
        $('#modalContent').find('.modal-body').load('/calculator/update-profile?id=' + data, function() {
        })
        $('.modal-footer').find('input').attr('form','update-profile-form')
        $('#modalContent').modal('show')
        return false;
    })
    
        $('.create-user-button').on('click', function (){
        $('#modalContent').find('.modal-body').load('/calculator/create-user', function(data) {
            $('#modalContent').find('.modal-title').text('Создание пользователя')
            $('#modalContent').find('.signup-header').empty()
            $('#modalContent').find('.signup-header').empty()
            $('#modalContent').find('.signup-button').empty()
            $('#modalContent').find('.row').addClass('d-flex justify-content-center')
        })
            $('.modal-footer').find('input').attr('form','signup-form')
        
        $('#modalContent').modal('show')
        return false;
    })

JS;

$this->registerJs($js);

?>