<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "game_genre".
 *
 * @property int $game_id
 * @property int $genre_id
 */
class GameGenre extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'game_genre';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['game_id', 'genre_id'], 'required'],
            [['game_id', 'genre_id'], 'integer'],
            [['game_id', 'genre_id'], 'unique', 'targetAttribute' => ['game_id', 'genre_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'game_id' => 'Game ID',
            'genre_id' => 'Genre ID',
        ];
    }

    public function getGenre(){
        return $this->hasOne(Genre::class,["id"=>"genre_id"]);
    }

}
