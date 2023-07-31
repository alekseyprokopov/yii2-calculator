<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mdm\admin\models\searchs\Assignment */
/* @var $usernameField string */
/* @var $extraColumns string[] */

$this->title = Yii::t('rbac-admin', 'Assignments');
$this->params['breadcrumbs'][] = $this->title;

$columns = [
    [
        'attribute' => 'id',
        'label' => 'ID',
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
];
if (!empty($extraColumns)) {
    $columns = array_merge($columns, $extraColumns);
}
$columns[] = [
    'class' => 'yii\grid\ActionColumn',
    'template' => '{view}'
];
?>
<div class="assignment-index">

    <h2><?= Html::encode($this->title) ?></h2>

    <?php Pjax::begin(); ?>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $columns,
    ]);
    ?>
    <?php Pjax::end(); ?>

</div>
