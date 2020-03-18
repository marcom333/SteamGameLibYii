<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Steam Library</h1>

        <p class="lead">This is a nice steam library to see your games.</p>

        <p> <?= Html::a("Get started and make your account",["site/login"],["class"=>"btn btn-lg btn-success"]); ?> </p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Track your games.</h2>
                <p>You can filter your steam games.</p>
            </div>
            <div class="col-lg-4">
                <h2>Don't know what to play?</h2>
                <p>You can play a random game in your library, just click on random.</p>
            </div>
            <div class="col-lg-4">
                <h2>Don't find the game?</h2>
                <p>You can filter the game by tags, categories, genres and custom folders. And the folder can have subfolders.</p>
            </div>
        </div>

    </div>
</div>
