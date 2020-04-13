<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\FrontPage;

/**
 * clinicSearch represents the model behind the search form of `app\models\Clinic`.
 */
class frontpageSearch extends FrontPage
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
		return [
			[['name', 'file_name', 'build_time', 'deleted_time', 'modify_time'], 'safe'],
			[['top_id', 'build_id', 'deleted_id', 'deleted', 'modify_id'], 'integer'],
			[['build_time', 'deleted_time', 'modify_time'], 'safe'],
			[['name', 'file_name'], 'string', 'max' => 64],
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
    public function search($params,$type)
    {
        $query = FrontPage::find()->Where($type);

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
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'file_name', $this->file_name])
            ->andFilterWhere(['like', 'build_time', $this->build_time]);

        return $dataProvider;
    }
	public function GetDataWhere($arr = '')
	{
		if(!empty($arr)){
			return FrontPage::find()->where($arr)->indexBy("id")->asArray()->all();
		}else{
			return FrontPage::find()->indexBy("id")->asArray()->all();
		}
	}
}
