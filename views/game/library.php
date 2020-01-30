<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
$this->title = 'Library';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="game-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p><?= Html::a('Update Library', ['create'], ['class' => 'btn btn-primary']) ?> <?= Html::a('Find Game', ['search'], ['class' => 'btn btn-primary']) ?></p>
    <div style="height: 800px !Important; overflow-y: auto;" class="col-md-3">
        <h3>Menu</h3>
        <div id="folder">
            <div class="clickable" id="folder-off" onclick="$('#folder-off').toggleClass('hidden'); $('#folder-on').toggleClass('hidden'); $('#folder-data-on').toggleClass('hidden');"> + Folder</div>
            <div class="clickable hidden" id="folder-on" onclick="$('#folder-off').toggleClass('hidden'); $('#folder-on').toggleClass('hidden'); $('#folder-data-on').toggleClass('hidden');"> - Folder</div>
            <div class="clickable hidden" id="folder-data-on">
                <?php foreach($folders as $folder): ?>
                    <script> folder<?= $folder->id ?>=false; </script>
                    <div class="clickable" onclick="
                        folder<?= $folder->id ?>=!folder<?= $folder->id ?>;
                        if(folder<?= $folder->id ?>){
                            $.post('<?= Url::to(["game/folder","id"=>$folder->id]); ?>', 
                                function( data ) {
                                    $('#<?= 'folder' . $folder->id ?>').html( data );
                                }
                            );
                        }
                        else{
                            $('#<?= 'folder' . $folder->id ?>').html('');
                        }
                    ">&nbsp;&nbsp;&nbsp; + <?= $folder->name ?> </div>
                    <div id="<?= 'folder' . $folder->id ?>"></div>
                <?php endforeach; ?>
            </div>
        </div>

        <div id="genre">
            <div class="clickable" id="genre-off" onclick="$('#genre-off').toggleClass('hidden'); $('#genre-on').toggleClass('hidden'); $('#genre-data-on').toggleClass('hidden');"> + Genre</div>
            <div class="clickable hidden" id="genre-on" onclick="$('#genre-off').toggleClass('hidden'); $('#genre-on').toggleClass('hidden'); $('#genre-data-on').toggleClass('hidden');"> - Genre</div>
            <div class="clickable hidden" id="genre-data-on">
                <?php foreach($genres as $gen): ?>
                    <script>gen<?= $gen->id; ?>=false</script>
                    <div class="clickable" onclick="
                        gen<?= $gen->id; ?>=!gen<?= $gen->id; ?>;
                        if(gen<?= $gen->id; ?>){
                            $.post('<?= Url::to(["game/genre","id"=>$gen->id]); ?>', 
                                function( data ) {
                                    $('#<?= 'gen' . $gen->id ?>').html( data );
                                }
                            );
                        }
                        else{
                            $('#<?= 'gen' . $gen->id ?>').html('');
                        }
                    ">&nbsp;&nbsp;&nbsp; + <?= $gen->name ?> </div>
                    <div id="<?= 'gen' . $gen->id ?>"></div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <div id="tag">
            <div class="clickable" id="tag-off" onclick="$('#tag-off').toggleClass('hidden'); $('#tag-on').toggleClass('hidden'); $('#tag-data-on').toggleClass('hidden');"> + Tag</div>
            <div class="clickable hidden" id="tag-on" onclick="$('#tag-off').toggleClass('hidden'); $('#tag-on').toggleClass('hidden'); $('#tag-data-on').toggleClass('hidden');"> - Tag</div>
            <div class="clickable hidden" id="tag-data-on">
                <?php foreach($tags as $tag): ?>
                    <script>tag<?= $tag->id; ?>=false</script>
                    <div class="clickable" onclick="
                        tag<?= $tag->id; ?>=!tag<?= $tag->id; ?>;
                        if(tag<?= $tag->id; ?>){
                            $.post('<?= Url::to(["game/tag","id"=>$tag->id]); ?>', 
                                function( data ) {
                                    $('#<?= 'tag' . $tag->id ?>').html( data );
                                }
                            );
                        }
                        else{
                            $('#<?= 'tag' . $tag->id ?>').html('');
                        }
                    ">&nbsp;&nbsp;&nbsp; + <?= $tag->name ?> </div>
                    <div id="<?= 'tag' . $tag->id ?>"></div>
                <?php endforeach; ?>
            </div>
        </div>

        <div id="category">
            <div class="clickable" id="category-off" onclick="$('#category-off').toggleClass('hidden'); $('#category-on').toggleClass('hidden'); $('#category-data-on').toggleClass('hidden');"> + Category</div>
            <div class="clickable hidden" id="category-on" onclick="$('#category-off').toggleClass('hidden'); $('#category-on').toggleClass('hidden'); $('#category-data-on').toggleClass('hidden');"> - Category</div>
            <div class="clickable hidden" id="category-data-on">
                <?php foreach($categories as $cat): ?>
                    <script>cat<?= $cat->id; ?>=false</script>
                    <div class="clickable" onclick="
                        cat<?= $cat->id; ?>=!cat<?= $cat->id; ?>;
                        if(cat<?= $cat->id; ?>){
                            $.post('<?= Url::to(["game/category","id"=>$cat->id]); ?>', 
                                function( data ) {
                                    $('#<?= 'category' . $cat->id ?>').html( data );
                                }
                            );
                        }
                        else{
                            $('#<?= 'category' . $cat->id ?>').html('');
                        }
                    ">&nbsp;&nbsp;&nbsp; + <?= $cat->name ?> </div>
                    <div id="<?= 'category' . $cat->id ?>"></div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>
    
    <div class="col-md-9" id="data"></div>
</div>
