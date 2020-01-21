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
        <?= Html::a('Play', "steam://run/" . $model->id, ['class' => 'btn btn-success']) ?>
        <?= Html::a( Html::img("@web/img/steam-logo.png",["height"=>"20px"]) . " Store ", "https://store.steampowered.com/app/" . $model->id . "/",["class"=>"btn btn-default"]) ?>
        <?= Html::a( Html::img("@web/img/steam-db-logo.png",["height"=>"20px"]) . "DB" , "https://steamdb.info/app/$model->id/" , ["class"=>"btn btn-default"]); ?>
    </p>

    <div class="col-md-offset-3 col-md-6">
        <?php 
            $screens = [];
            foreach($model->screenshots as $screen){
                array_push($screens,"<img src='".$screen->path_thumbnail."' style='width: 100%'>");
            }
            if(sizeof($screens) > 0){
                echo Carousel::widget(['items' => $screens,"id"=>"previews"]);
            }
        ?>
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
            'platforms',
            [
                'attribute' => 'price',
                'value' => function($model){
                    return "$" .  $model->price . " " . $model->price_currency;
                }
            ],
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
            ],
            [
                'attribute' => 'tag',
                'value' => function($model){
                    $data = "";
                    foreach($model->tag as $cat){
                        $data .= "[" . $cat->name . "] ";
                    }
                    return $data;
                }
            ]
        ],
    ]) ?>
    </div>
<script>
    (function() {
        var link = document.querySelector("link[rel*='icon']") || document.createElement('link');
        link.type = 'image/x-icon';
        link.rel = 'shortcut icon';
        link.href = '<?= "https://steamcdn-a.akamaihd.net/steamcommunity/public/images/apps/".$model->id."/" . $model->img_logo_url . ".jpg" ?>';
        document.getElementsByTagName('head')[0].appendChild(link);
    })();
</script>

</div>
