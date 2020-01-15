<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\GameSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="game-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'img_icon_url') ?>

    <?= $form->field($model, 'img_logo_url') ?>

    <?= $form->field($model, 'required_age') ?>

    <?php // echo $form->field($model, 'controller_support') ?>

    <?php // echo $form->field($model, 'detailed_description') ?>

    <?php // echo $form->field($model, 'about_the_game') ?>

    <?php // echo $form->field($model, 'pc_requirements_minimum') ?>

    <?php // echo $form->field($model, 'pc_requirements_recomended') ?>

    <?php // echo $form->field($model, 'developers') ?>

    <?php // echo $form->field($model, 'publishers') ?>

    <?php // echo $form->field($model, 'price_currency') ?>

    <?php // echo $form->field($model, 'initial') ?>

    <?php // echo $form->field($model, 'platforms') ?>

    <?php // echo $form->field($model, 'background') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
