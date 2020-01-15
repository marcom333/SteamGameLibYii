<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "metacritic".
 *
 * @property int $id
 * @property int $game_id
 * @property int $score
 * @property string $url
 */
class Metacritic extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'metacritic';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['game_id', 'score', 'url'], 'required'],
            [['game_id', 'score'], 'integer'],
            [['url'], 'string', 'max' => 512],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'game_id' => 'Game ID',
            'score' => 'Score',
            'url' => 'Url',
        ];
    }
}
