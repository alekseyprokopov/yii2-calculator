<?php

/** @var yii\web\View $this */

/** @var string $content */

use app\assets\AppAsset;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\Html;

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
        <?= Html::csrfMetaTags() ?>
        <?php $this->head() ?>
    </head>

    <body class="d-flex flex-column h-100">

    <?php $this->beginBody() ?>

    <header id="header" class="py-1">
        <?php
        NavBar::begin([
            'brandLabel' => Html::tag('div', '', ['class' => 'logo']),
            'brandUrl' => Yii::$app->homeUrl,
            'options' => ['class' => 'navbar-expand-md navbar-dark'],
            'containerOptions' => ['class' => ' justify-content-end']
        ]);

        $items = [
            ['label' => 'Расчет доставки', 'url' => ['/calculator/index']],
            ['label' => 'Войти в систему', 'url' => ['/user/login'], 'visible' => Yii::$app->user->isGuest],
            ['label' => Yii::$app->user->identity->username,
                'items' => [
                    ['label' => 'Профиль', 'url' => ['/user/profile?id=' . Yii::$app->user->id]],
                    ['label' => 'История расчётов', 'url' => ['/history/index']],
                    ['label' => 'Пользователи', 'url' => ['/admin/user'], 'visible' => Yii::$app->user->can('administrator')],
                    ['label' => 'Выход', 'url' => ['/user/logout'], 'linkOptions' => ['data-method' => 'post']],
                ],
                'visible' => Yii::$app->user->isGuest === false
            ]
        ];
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav nav navbar-right d-flex gap-3'],
            'items' => $items
        ]);
        NavBar::end();
        ?>
    </header>

    <main id="main" class="flex-shrink-0 text-light" role="main">
        <div class="container mb-3">

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