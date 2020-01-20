<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GameSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Library';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="game-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <div style="height: 600px !Important; overflow-y: auto" class="col-md-3">
        <div id="folder" onclick="$.post('<?= Url::to(["game/folder","id"=>-1]); ?>', function( data ) {$('#folder').html( data );});"> + Folder </div>

        <div class="" id="genre-off" onclick="$('#genre-off').toggleClass('hidden'); $('#genre-on').toggleClass('hidden'); $('#genre-data-on').toggleClass('hidden');"> + Genre</div>
        <div class="hidden" id="genre-on" onclick="$('#genre-off').toggleClass('hidden'); $('#genre-on').toggleClass('hidden'); $('#genre-data-on').toggleClass('hidden');"> - Genre</div>
        <div class="hidden" id="genre-data-on">
            <?php foreach($genres as $gen): ?>
                <div onclick="
                    $.post('<?= Url::to(["game/genre","id"=>$gen->id]); ?>', 
                        function( data ) {
                            $('#<?= 'gen' . $gen->id ?>').html( data );
                        });">&nbsp;&nbsp;&nbsp; + <?= $gen->name ?> </div>
                <div id="<?= 'gen' . $gen->id ?>"></div>
            <?php endforeach; ?>
        </div>

        <div id="tag"> 
            + Tags 
            <?php foreach($tags as $tag): ?>
                <div id="<?= 'tag' . $tag->id ?>">&nbsp;&nbsp;&nbsp; + <?= $tag->name ?> </div>
            <?php endforeach; ?>
        </div>

        <div id="category"> 
            + Category 
            <?php foreach($categories as $cat): ?>
                <div id="<?= 'cat' . $cat->id ?>">&nbsp;&nbsp;&nbsp; + <?= $cat->name ?> </div>
            <?php endforeach; ?>
        </div>

        </div>
    </div>
    
    <div style="height: 600px !Important; overflow-y: auto" class="col-md-9" id="data">
    </div>

</div>
