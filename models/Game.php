<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "game".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $img_icon_url
 * @property string|null $img_logo_url
 * @property int|null $required_age
 * @property string|null $controller_support
 * @property string|null $detailed_description
 * @property string|null $about_the_game
 * @property string|null $pc_requirements_minimum
 * @property string|null $pc_requirements_recomended
 * @property string|null $developers
 * @property string|null $publishers
 * @property string|null $price_currency
 * @property int|null $initial
 * @property string|null $platforms
 * @property string|null $background
 */
class Game extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'game';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'required_age', 'initial'], 'integer'],
            [['detailed_description', 'about_the_game', 'pc_requirements_minimum', 'pc_requirements_recomended'], 'string'],
            [['name', 'background'], 'string', 'max' => 512],
            [['img_icon_url', 'img_logo_url', 'developers', 'publishers', 'platforms'], 'string', 'max' => 100],
            [['controller_support', 'price_currency'], 'string', 'max' => 10],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'img_icon_url' => 'Img Icon Url',
            'img_logo_url' => 'Img Logo Url',
            'required_age' => 'Required Age',
            'controller_support' => 'Controller Support',
            'detailed_description' => 'Detailed Description',
            'about_the_game' => 'About The Game',
            'pc_requirements_minimum' => 'Pc Requirements Minimum',
            'pc_requirements_recomended' => 'Pc Requirements Recomended',
            'developers' => 'Developers',
            'publishers' => 'Publishers',
            'price_currency' => 'Price Currency',
            'initial' => 'Price',
            'price' => 'Price',
            'platforms' => 'Platforms',
            'background' => 'Background',
        ];
    }

    public function getPrice(){
        return $this->initial/100;
    }

    public function getScreenshots(){
        return $this->hasMany(Screenshots::className(),['game_id' => 'id']);
    }
    public function getGenre(){
        return $this->hasMany(Genre::className(),['id' => 'genre_id'])->viaTable('game_genre', ['game_id' => 'id']);
    }
    public function getCategory(){
        return $this->hasMany(Category::className(),['id' => 'category_id'])->viaTable('category_game', ['game_id' => 'id']);
    }
    public function getTag(){
        return $this->hasMany(Tag::className(),['id' => 'tag_id'])->viaTable('game_tag', ['game_id' => 'id']);
    }
}
