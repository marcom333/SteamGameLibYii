<?php use yii\helpers\Url; ?>
<?php foreach($games as $game): ?>
    <div onclick="
        $.post('<?= Url::to(["game/view","id"=>$game['id']]); ?>', 
        function( data ) {
            $('#data').html( data );
        });"
    >
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; + <?= $game['name'] ?>
    </div>
<?php endforeach; ?>