<?php

/** @var yii\web\View $this */

/** @var string $content */

use yii\helpers\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\bootstrap5\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>


<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>" class="h-100">
    <head>
        <title><?= Html::encode($this->title) ?></title>
<!--        --><?php //= Html::csrfMetaTags() ?>
        <?php $this->head() ?>
    </head>

    <body class="d-flex flex-column h-100">

    <?php $this->beginBody() ?>

    <header id="header" class="py-4">
        <?php
        NavBar::begin([
            'brandLabel' => Html::tag('div', '', ['class' => 'logo']),
            'brandUrl' => Yii::$app->homeUrl,
            'options' => ['class' => 'navbar-expand-md navbar-dark fixed-top'],
            'containerOptions' => ['class' => ' justify-content-end']
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right d-flex gap-3'],
            'items' => [
                ['label' => 'Расчет доставки', 'url' => ['/site/index']],
//                 ['label' => 'Вход', 'url' => ['/login/index']],
            ]
        ]);
        NavBar::end();
        ?>
    </header>

    <main id="main" class="flex-shrink-0" role="main">
        <div class="container">
            <?php if (!empty($this->params['breadcrumbs'])): ?>
                <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
            <?php endif ?>
            <?= $content ?>
        </div>
    </main>


    <footer id="footer" class="mt-auto py-3 bg-light">
        <div class="container">
            <div class="row text-muted">
                <div class="col-md-6 text-center text-md-start">&copy; ЭФКО Стартер 2023</div>
                
            </div>
        </div>
    </footer>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>