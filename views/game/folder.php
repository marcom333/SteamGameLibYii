<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Directory [<?= $current?$current->name:"Root" ?>]</h3>
    </div>
    <div class="panel-body">
        <ul class>
            <?php if($current):?>
                <li><?= Html::a("Return to: <b>" . $current->parent->name . "</b>",["game/addfolder","id"=>$id, "path"=>$current->folder_id],['class'=>""]); ?></li>
            <?php endif;?>
            <?php foreach($folders as $folder): ?>
                <li>
                    <?= Html::a("Go To: <b>" . $folder->name . "</b>",["game/addfolder","id"=>$id, "path"=>$folder->id],['class'=>""]); ?>
                    <?= Html::a("<span class='glyphicon glyphicon-check'></span>", 
                                    ["game/selectfolder","id"=>$id, "folder_id"=>$folder->id], [
                                    'id'=>"folder".$folder->id,
                                    'data' => [
                                        'confirm' => 'Select folder?',
                                        'method' => 'post',
                                    ],
                                ]);
                    ?>
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
            <label for="name" class="col-sm-2">Folder Name:</label>
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
                

            <input type="submit" name="save"><br>
        <?php ActiveForm::end(); ?>
    </div>
</div>

