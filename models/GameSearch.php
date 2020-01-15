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
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'required_age', 'initial'], 'integer'],
            [['name', 'img_icon_url', 'img_logo_url', 'controller_support', 'detailed_description', 'about_the_game', 'pc_requirements_minimum', 'pc_requirements_recomended', 'developers', 'publishers', 'price_currency', 'platforms', 'background'], 'safe'],
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
        $query = Game::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'required_age' => $this->required_age,
            'initial' => $this->initial,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'img_icon_url', $this->img_icon_url])
            ->andFilterWhere(['like', 'img_logo_url', $this->img_logo_url])
            ->andFilterWhere(['like', 'controller_support', $this->controller_support])
            ->andFilterWhere(['like', 'detailed_description', $this->detailed_description])
            ->andFilterWhere(['like', 'about_the_game', $this->about_the_game])
            ->andFilterWhere(['like', 'pc_requirements_minimum', $this->pc_requirements_minimum])
            ->andFilterWhere(['like', 'pc_requirements_recomended', $this->pc_requirements_recomended])
            ->andFilterWhere(['like', 'developers', $this->developers])
            ->andFilterWhere(['like', 'publishers', $this->publishers])
            ->andFilterWhere(['like', 'price_currency', $this->price_currency])
            ->andFilterWhere(['like', 'platforms', $this->platforms])
            ->andFilterWhere(['like', 'background', $this->background]);

        return $dataProvider;
    }
}
