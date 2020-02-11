<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Level;

/**
 * LevelSearch represents the model behind the search form of `app\models\Level`.
 */
class LevelSearch extends Level
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'build_id', 'useable'], 'integer'],
            [['job_name', 'build_time'], 'safe'],
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
        $query = Level::find()->where(['!=','level.id',0]);
		$query->joinWith(['adminSheets']);/*这里的articlecategory是article模型里面关联的方法名，除了首字母，其他都要完全一样，否则会报错*/
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
            'build_time' => $this->build_time,
            'build_id' => $this->build_id,
        ]);

        $query->andFilterWhere(['like', 'job_name', $this->job_name]);

        return $dataProvider;
    }
}
