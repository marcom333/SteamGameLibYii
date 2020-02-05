<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div id="routepanel">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Directory [<?= $current?$current->name:"Root" ?>]</h3>
        </div>
        <div class="panel-body">
            <ul class>
                <?php if($current):?>
                    <li><span class="pointer" onclick="$.get('<?= Url::to(["game/addfolder","id"=>$id, "path"=>$current->folder_id]); ?>', function(data, status){$('#routepanel').html(data);})">
                        <?="Return to: <b>" . $current->parent->name . "</b>"?>
                    </span></li>
                <?php endif;?>
                <?php foreach($folders as $folder): ?>
                    <li>
                        <span class="pointer" onclick="$.get('<?= Url::to(["game/addfolder","id"=>$id, "path"=>$folder->id]); ?>', function(data, status){$('#routepanel').html(data);})">
                            <?= "Go To: <b>" . $folder->name . "</b>"?>
                        </span>
                        <span class='glyphicon glyphicon-check' onclick="
                            $.get('<?= Url::to(["game/selectfolder","id"=>$id, "folder_id"=>$folder->id]); ?>', 
                            function(data, status){
                                if(status == 'success'){
                                    $('#admin').modal('toggle');
                                    $('#game_content').html(data);
                                }
                            })">
                        </span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Create Folder</h3>
        </div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin(["id"=>"ccsionform"]); ?>
                <label for="name">Folder Name:</label>
                <input type="text" name="name" id="name" class="form-control" value="" required="required" title="name"><br>
                    
                <div class="radio">
                    <label>
                        <input type="radio" name="option" id="input" value="1" checked="checked">
                        Create and Select:
                    </label>
                    <label>
                        <input type="radio" name="option" id="input" value="0">
                        Create Only:
                    </label>
                </div>
                <div class="btn btn-primary" onclick="
                    var url = $('#ccsionform').attr('action');
                    var formData = $('#ccsionform').serializeArray();
                    $.post(url, formData).done(function (data) {
                        $('#routepanel').html(data);
                    });">
                    Send
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>