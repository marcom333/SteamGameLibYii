<?php use yii\helpers\Url; ?>
<?php foreach($games as $game): ?>
    <div class="clickable" onclick="
        $.post('<?= Url::to(["game/view","id"=>$game['id']]); ?>', 
        function( data ) {
            $('#data').html( data );
        });"
    >
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <img src="https://steamcdn-a.akamaihd.net/steamcommunity/public/images/apps/<?= $game['id'] ?>/<?= $game['img_icon_url'] ?>.jpg"> <?= $game['name'] ?>
    </div>
<?php endforeach; ?>