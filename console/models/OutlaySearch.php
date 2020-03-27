<?php

namespace app\console\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Outlay;

/**
 * OutlaySearch represents the model behind the search form of `app\models\Outlay`.
 */
class OutlaySearch extends Outlay
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'pay_mny'], 'integer'],
            [['name', 'buy_time'], 'safe'],
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
        $query = Outlay::find();

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
            'buy_time' => $this->buy_time,
            'pay_mny' => $this->pay_mny,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
