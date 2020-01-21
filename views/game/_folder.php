<?php 
    use yii\helpers\Url; 
    $space = '&nbsp;&nbsp;&nbsp;';
    $totalSpace = "&nbsp;&nbsp;&nbsp;";
    for($i=0;$i<$level;$i++){
        $totalSpace .= $space;
    }
?>

<?php foreach($subFolder as $folder): ?>
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
    "><?= $totalSpace." + ".$folder->name ?> </div>
    <div id="<?= 'folder' . $folder->id ?>"></div>
<?php endforeach; ?>

<?php foreach($games as $game): ?>
    <div class="clickable" onclick="
        $.post('<?= Url::to(["game/view","id"=>$game['id']]); ?>', 
        function( data ) {
            $('#data').html( data );
        });"
    >
        <?= $totalSpace ?> <img src="https://steamcdn-a.akamaihd.net/steamcommunity/public/images/apps/<?= $game['id'] ?>/<?= $game['img_icon_url'] ?>.jpg"> <?= $game['name'] ?>
    </div>
<?php endforeach; ?>