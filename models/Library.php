<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "library".
 *
 * @property int $game_id
 * @property int $user_id
 */
class Library extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'library';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['game_id', 'user_id'], 'required'],
            [['game_id', 'user_id'], 'integer'],
            [['game_id', 'user_id'], 'unique', 'targetAttribute' => ['game_id', 'user_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'game_id' => 'Game ID',
            'user_id' => 'User ID',
        ];
    }
}
