<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GameSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Games';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="game-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Html::a('Update Library', ['create'], ['class' => 'btn btn-success']) ?> <?= Html::a('Update Details', ['details'], ['class' => 'btn btn-success']) ?></p>
    <div style="background-color: rgb(200,200,200); padding: 5px; border-radius:10px" class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    "attribute"=>"name",
                    'format' => 'html',
                    "value"=>function($model){
                        return "<img src=\"https://steamcdn-a.akamaihd.net/steamcommunity/public/images/apps/".$model['id']."/" . $model['img_logo_url'] . ".jpg\"><br>".$model["name"];
                    }
                ],
                'controller_support',
                'platforms',
                [
                    "attribute"=>'initial',
                    "value"=>function($model){
                        return "$" . ($model['initial']/100)  . " " . $model['price_currency'];
                    }
                ],
                [
                    "attribute"=>'gname',
                    "label"=>"Genre",
                    "value"=>function($model){
                        return str_replace(",",", ", $model["gname"]);
                    }
                ],
                [
                    "attribute"=>'cname',
                    "label"=>"Category",
                    "value"=>function($model){
                        return str_replace(",",", ", $model["cname"]);
                    }
                ],
                [
                    "attribute"=>'tname',
                    "label"=>"Tag",
                    "value"=>function($model){
                        return str_replace(",",", ", $model["tname"]);
                    }
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'visible'=> true,
                    'template'=>"{view} {update} {run}",
                    'buttons'=>[
                        'view'=>function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['view','id'=>$model['id']], ['class' => 'btn btn-default btn-xs custom_button']);
                        },
                        'update'=>function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-refresh"></span>', ['update','id'=>$model['id']], ['class' => 'btn btn-default btn-xs custom_button']);
                        },
                        'run'=>function ($url, $model){
                            return Html::a('<span class="glyphicon glyphicon-play-circle"></span>', "steam://run/" . $model['id'], ['class' => 'btn btn-default btn-xs custom_button']);
                        },
                    ],
                ]
            ],
        ]); ?>
    </div>

</div>
