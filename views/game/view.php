<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Carousel;
/* @var $this yii\web\View */
/* @var $model app\models\Game */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Search', 'url' => ['search']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="game-view">

    <h1><img src="https://steamcdn-a.akamaihd.net/steamcommunity/public/images/apps/<?= $model->id ?>/<?= $model->img_icon_url ?>.jpg"><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a("<span class=\"glyphicon glyphicon-refresh\"></span> Update", ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-play-circle"></span> Play', "steam://run/" . $model->id, ['class' => 'btn btn-success']) ?>
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
            'update',
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
                'format'=>'html',
                'value' => function($model){
                    $data = "";
                    foreach($model->genre as $genre){
                        $id = "game_genre_".$genre->id;
                        $data .= 
                            "<div class='label label-default' id='$id'>". 
                                $genre->name . 
                            '</div> ';
                    }
                    return $data;
                }
            ],
            [
                'attribute' => 'category',
                'format'=>'html',
                'value' => function($model){
                    $data = "";
                    foreach($model->category as $cat){
                        $id = "game_cat_".$cat->id;
                        $data .= 
                            "<div class='label label-default' id='$id'>". 
                                $cat->name . 
                            '</div> ';
                    }
                    return $data;
                }
            ],
            [
                'attribute' => 'tag',
                "format"=>"html",
                'value' => function($model){
                    $data = "";
                    foreach($model->tag as $tag){
                        $id = "game_tag_".$tag->id;
                        $data .= 
                            "<div class='label label-default' id='$id'>". 
                                $tag->name . 
                            '</div> ';
                    }
                    return $data;
                }
            ],
            [
                'attribute' => 'folder',
                "format"=>"raw",
                'value' => function($model){
                    $data = "";
                    foreach($model->folder as $folder){
                        if($folder->user_id == Yii::$app->user->id){
                            $parent = $folder->parent;
                            $allName = $folder->name ;
                            while($parent->name != "Root"){
                                $allName = $parent->name . " / " . $allName;
                                $parent= $parent->parent;
                            }
                            $parent_id = $folder->folder_id;
                            
                            $id = "game_folder_".$folder->id;
                            $data .= 
                                "<div class='label label-default' id='$id'>". 
                                    $allName. 
                                    
                                    Html::a(
                                        '<span class="glyphicon glyphicon-remove"></span>', 
                                        ["deletefolder","folder"=>$folder->id,"id"=>$model->id], [
                                        'id'=>"folder".$folder->id,
                                        'data' => [
                                            'confirm' => 'Remove folder?',
                                            'method' => 'post',
                                        ],
                                    ]).
                                '</div> ';
                        }
                    }
                    return $data . Html::a("+ Add Folder",["game/addfolder","id"=>$model->id],["class"=>"label label-primary"]);
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
