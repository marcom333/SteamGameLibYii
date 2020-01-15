<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Carousel;
/* @var $this yii\web\View */
/* @var $model app\models\Game */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Games', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="game-view">

    <h1><img src="https://steamcdn-a.akamaihd.net/steamcommunity/public/images/apps/<?= $model->id ?>/<?= $model->img_icon_url ?>.jpg"><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Run', "steam://run/" . $model->id, ['class' => 'btn btn-success']) ?>
        <?= Html::a('Steam', "https://store.steampowered.com/app/" . $model->id . "/", ['class' => 'btn btn-success']) ?>
    </p>

    <div class="col-md-offset-3 col-md-6">
        <br>
        <?php 
            $screens = [];
            foreach($model->screenshots as $screen){
                array_push($screens,"<img src='".$screen->path_thumbnail."'>");
            }
            //var_dump($screens);
            //die();
            if(sizeof($screens) > 0){
                echo Carousel::widget(['items' => $screens]);
            }
        ?>
        </br>
    </div>

    <div style="background-color: rgb(200,200,200); padding: 5px; border-radius:10px">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'required_age',
            'controller_support',
            'detailed_description:html',
            'about_the_game:html',
            'pc_requirements_minimum:html',
            'pc_requirements_recomended:html',
            'developers',
            'publishers',
            'price_currency',
            'price',
            'platforms',
            [
                'attribute' => 'genre',
                'value' => function($model){
                    $data = "";
                    foreach($model->genre as $genre){
                        $data .= "[" . $genre->name . "] ";
                    }
                    return $data;
                }
            ],
            [
                'attribute' => 'category',
                'value' => function($model){
                    $data = "";
                    foreach($model->category as $cat){
                        $data .= "[" . $cat->name . "] ";
                    }
                    return $data;
                }
            ]
        ],
    ]) ?>
    </div>

</div>
