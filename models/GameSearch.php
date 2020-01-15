<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Game;

/**
 * GameSearch represents the model behind the search form of `app\models\Game`.
 */
class GameSearch extends Game
{

    public $cname, $gname;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'required_age', 'initial'], 'integer'],
            [['name', 'controller_support','gname', 'cname', 'platforms',], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = (new \yii\db\Query())->
            select(
                [
                    "game.id",
                    "game.name name",
                    "game.img_logo_url",
                    "game.required_age",
                    "game.controller_support",
                    "game.platforms",
                    "game.initial",
                    "game.price_currency",
                    'GROUP_CONCAT(DISTINCT category.name) cname',
                    'GROUP_CONCAT(DISTINCT genre.name) gname',
                ])->
            from('game')->
            join('LEFT JOIN', 'game_genre', 'game_genre.game_id = game.id')->
            join('LEFT JOIN', 'genre', 'genre.id = game_genre.genre_id')->
            join('LEFT JOIN', 'category_game', 'category_game.game_id = game.id')->
            join('LEFT JOIN', 'category', 'category.id = category_game.category_id')->
            groupBy("game.id");


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['name' => SORT_ASC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $dataProvider->sort->attributes['name'] = [
            'asc' => ['game.name' => SORT_ASC],
            'desc' => ['game.name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['required_age'] = [
            'asc' => ['game.required_age' => SORT_ASC],
            'desc' => ['game.required_age' => SORT_DESC],
        ];
        
        $dataProvider->sort->attributes['controller_support'] = [
            'asc' => ['game.controller_support' => SORT_ASC],
            'desc' => ['game.controller_support' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['platforms'] = [
            'asc' => ['game.platforms' => SORT_ASC],
            'desc' => ['game.platforms' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['initial'] = [
            'asc' => ['game.initial' => SORT_ASC],
            'desc' => ['game.initial' => SORT_DESC],
        ];

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'required_age' => $this->required_age,
            'initial' => $this->initial?($this->initial * 100):NULL,
        ]);

        $query
            ->andFilterWhere(['like', 'game.name', $this->name])
            ->andFilterWhere(['like', 'controller_support', $this->controller_support])
            ->andFilterWhere(['like', 'platforms', $this->platforms])
            ->andFilterWhere(['like', 'genre.name', $this->gname])
            ->andFilterWhere(['like', 'category.name', $this->cname])
        ;

        return $dataProvider;
    }
}
