<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\bootstrap\Modal;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<?php 
    $session = Yii::$app->session;
    $background = $session->get('background');
?>
<body style="background-color: #1b2838; background-image: url('<?= isset($background)?$background:"" ?>');background-position: 0 0;background-size: 100% 100%;background-repeat: no-repeat;background-attachment: fixed;">

<?php 
    $session->remove("background");
    $this->beginBody() 
?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'Random', 'url' => ['/game/random']],
            ['label' => 'Search', 'url' => ['/game/search']],
            ['label' => 'Library', 'url' => ['/game/library']],
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container main">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Who read this? <?= date('Y') ?></p>

        <p class="pull-right">I made this with Yii 2 Framework.</p>
    </div>
</footer>
<?php Modal::begin(['header' => '<h2>Select Folder</h2>',"id"=>"admin"]); ?>
<div id="data_post">
    Cargando ... 
</div>
<?php Modal::end(); ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
