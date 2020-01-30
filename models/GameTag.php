<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "game_tag".
 *
 * @property int $game_id
 * @property int $tag_id
 */
class GameTag extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'game_tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['game_id', 'tag_id'], 'required'],
            [['game_id', 'tag_id'], 'integer'],
            [['game_id', 'tag_id'], 'unique', 'targetAttribute' => ['game_id', 'tag_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'game_id' => 'Game ID',
            'tag_id' => 'Tag ID',
        ];
    }

    public function getTag(){
        return $this->hasOne(Tag::class,["id"=>'tag_id']);
    }
}
