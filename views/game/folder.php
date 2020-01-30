<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
foreach($folders as $folder){
    echo Html::a("Enter in " . $folder->name,["game/addfolder","id"=>$id, "path"=>$folder->id],['class'=>'btn btn-primary']);
    echo Html::a("Select folder " . $folder->name,["game/addfolder","id"=>$id, "path"=>$folder->id],['class'=>'btn btn-primary']) . "<br>";
}
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Save Folder</h3>
    </div>
    <div class="panel-body">
        <?php $form = ActiveForm::begin(["id"=>"ccsionform"]); ?>
            <label for="name" class="col-sm-2">Folder Name:</label>
            <input type="text" name="name" id="name" class="form-control" value="" required="required" title="name"><br>
            <input type="submit" name="addfolder"><br>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Save Folder and Select</h3>
    </div>
    <div class="panel-body">
        <?php $form = ActiveForm::begin(["id"=>"ccsionform"]); ?>
            <label for="name" class="col-sm-2">Folder Name:</label>
            <input type="text" name="name" id="name" class="form-control" value="" required="required" title="name"><br>
            <input type="submit" name="savefolder"><br>
        <?php ActiveForm::end(); ?>
    </div>
</div>

