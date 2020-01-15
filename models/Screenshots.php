<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "screenshots".
 *
 * @property int $id
 * @property string $path_thumbnail
 * @property int $game_id
 */
class Screenshots extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'screenshots';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['path_thumbnail', 'game_id'], 'required'],
            [['game_id'], 'integer'],
            [['path_thumbnail'], 'string', 'max' => 512],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'path_thumbnail' => 'Path Thumbnail',
            'game_id' => 'Game ID',
        ];
    }
}
