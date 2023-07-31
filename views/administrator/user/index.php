<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use app\models\User;

/* @var $this yii\web\View */
/* @var $searchModel mdm\admin\models\searchs\User */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('rbac-admin', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="user-index">

        <h2><?= Html::encode($this->title) ?></h2>
        <p>
            <button type="button" class="btn btn-warning create-user-button">Создать пользователя</button>
        </p>
        <?=
        GridView::widget([
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
                    'attribute' => 'email',
                    'label' => 'E-mail',
                    'sortLinkOptions' => ['class' => 'link-warning link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover'],
                ],

                [
                    'attribute' => 'username',
                    'label' => 'Имя пользователя',
                    'sortLinkOptions' => ['class' => 'link-warning link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover'],
                ],
                [
                    'attribute' => 'role',
                    'label' => 'Роль',

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
                ]
            ],
        ]);
        ?>
    </div>

    <div class="modal fade text-dark" id="createUserModal" tabindex="-1" aria-labelledby="createUserModal" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createUserModalLabel">Создать пользователя</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade text-dark" id="updateUserModal" tabindex="-1" aria-labelledby="updateUserModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateUserModalLabel">Информация</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" form="user_update_form" value="Сохранить изменения"/>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>

<?php
$js = <<<JS

    $('.grid-view tbody tr td:not(:last-child)').on('click', function (){
        let data = $(this).closest('tr').attr('data-key')
        $('#updateUserModal').find('.modal-body').load('/administrator/update-user?id=' + data)
        $('#updateUserModal').modal('show')
        return false;
    })
    
        $('.create-user-button').on('click', function (){
        $('#createUserModal').find('.modal-body').load('/administrator/create-user')
        $('#createUserModal').modal('show')
        return false;
    })

JS;

$this->registerJs($js);

?>