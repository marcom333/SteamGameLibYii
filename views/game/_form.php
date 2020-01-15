<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Game */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="game-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'img_icon_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'img_logo_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'required_age')->textInput() ?>

    <?= $form->field($model, 'controller_support')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'detailed_description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'about_the_game')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'pc_requirements_minimum')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'pc_requirements_recomended')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'developers')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'publishers')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price_currency')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'initial')->textInput() ?>

    <?= $form->field($model, 'platforms')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'background')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
