<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Game;

/**
 * GameSearch represents the model behind the search form of `app\models\Game`.
 */
class ZGameSearch extends Game
{

    public $cname, $gname, $tname;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'required_age', 'initial'], 'integer'],
            [['name', 'controller_support','gname', 'cname', 'tname', 'platforms',], 'safe'],
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
                    "GROUP_CONCAT( IF(type.name='Tag',data.name, NULL)) tname",
                    "GROUP_CONCAT( IF(type.name='Genre',data.name, NULL)) gname",
                    "GROUP_CONCAT( IF(type.name='Category',data.name, NULL)) cname",
                ])->
            from('game')->
            join('LEFT JOIN', 'game_data', 'game_data.game_id = game.id')->
            join('LEFT JOIN', 'data', 'data.id = game_data.data_id')->
            join('LEFT JOIN', 'type', 'type.id = game_data.type_id')->
            groupBy("game.id");

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['name' => SORT_ASC]],
            'pagination' => [
                'pageSize' => 20,
            ],
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
            ->andFilterWhere(['like', 'platforms', $this->platforms]);
        if($this->gname){
            $query->andFilterWhere(['like', 'data.name', $this->gname])->andFilterWhere(['=', 'type.name', 'Genre']);
        }
        if($this->cname){
            $query->andFilterWhere(['like', 'data.name', $this->cname])->andFilterWhere(['=', 'type.name', 'Category']);
        }
        if($this->tname){
            $query->andFilterWhere(['like', 'data.name', $this->tname])->andFilterWhere(['=', 'type.name', 'Tag']);
        }

        return $dataProvider;
    }
}
