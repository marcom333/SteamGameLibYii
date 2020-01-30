<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "game_data".
 *
 * @property int $game_id
 * @property int $data_id
 * @property int $type_id
 */
class GameData extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'game_data';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['game_id', 'data_id', 'type_id'], 'required'],
            [['game_id', 'data_id', 'type_id'], 'integer'],
            [['game_id', 'data_id', 'type_id'], 'unique', 'targetAttribute' => ['game_id', 'data_id', 'type_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'game_id' => 'Game ID',
            'data_id' => 'Data ID',
            'type_id' => 'Type ID',
        ];
    }
}
