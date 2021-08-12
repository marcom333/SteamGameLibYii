<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "folder_game".
 *
 * @property int $game_id
 * @property int $folder_id
 */
class FolderGame extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'folder_game';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['game_id', 'folder_id'], 'required'],
            [['game_id', 'folder_id'], 'integer'],
            [['game_id', 'folder_id'], 'unique', 'targetAttribute' => ['game_id', 'folder_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'game_id' => 'Game ID',
            'folder_id' => 'Folder ID',
        ];
    }

    public function getFolder(){
        return $this->hasOne(Folder::className(),['id' => 'folder_id']);
    }
}
