<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Clinic;

/**
 * clinicSearch represents the model behind the search form of `app\models\Clinic`.
 */
class clinicSearch extends Clinic
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'phone'], 'integer'],
            [['clinic', 'adress', 'email'], 'safe'],
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
        $query = Clinic::find();

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
            'phone' => $this->phone,
        ]);

        $query->andFilterWhere(['like', 'clinic', $this->clinic])
            ->andFilterWhere(['like', 'adress', $this->adress])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
	public function GetData($id = '')
	{
		if(!empty($id)){
			return Clinic::find()->where(['in',"id",$id])->indexBy("id")->asArray()->all();
		}else{
			return Clinic::find()->indexBy("id")->asArray()->all();
		}
	}
	public function GetDataWhere($arr = '')
	{
		if(!empty($arr)){
			return Clinic::find()->where($arr)->indexBy("id")->asArray()->all();
		}else{
			return Clinic::find()->indexBy("id")->asArray()->all();
		}
	}
}
