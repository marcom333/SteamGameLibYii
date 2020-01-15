<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category_game".
 *
 * @property int $game_id
 * @property int $category_id
 */
class CategoryGame extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category_game';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['game_id', 'category_id'], 'required'],
            [['game_id', 'category_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'game_id' => 'Game ID',
            'category_id' => 'Category ID',
        ];
    }
}
