<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\toothcase;

/**
 * toothcaseSearch represents the model behind the search form of `app\models\toothcase`.
 */
class toothcaseSearch extends toothcase
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'material_id'], 'integer'],
            [['start_time', 'end_time', 'name', 'tooth', 'tooth_color', 'remark','price'], 'safe'],
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
        $query = toothcase::find()->where(['clinic_id'=> $params['toothcaseSearch']]);
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>['defaultOrder'=>['end_time'=>SORT_DESC]],
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
            'start_time' => $this->start_time,
            'material_id' => $this->material_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'tooth', $this->tooth])
            ->andFilterWhere(['like', 'tooth_color', $this->tooth_color])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'end_time', $this->end_time]);

        return $dataProvider;
    }
}
