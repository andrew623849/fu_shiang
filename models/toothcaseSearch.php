<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Toothcase;

/**
 * toothcaseSearch represents the model behind the search form of `app\models\toothcase`.
 */
class toothcaseSearch extends Toothcase
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
            'sort'=>['defaultOrder'=>['start_time'=>SORT_DESC]],
        ]);
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'tooth', $this->tooth])
            ->andFilterWhere(['like', 'tooth_color', $this->tooth_color])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'start_time', $this->start_time]);

        return $dataProvider;
    }
}
