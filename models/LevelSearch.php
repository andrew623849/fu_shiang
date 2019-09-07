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
        $query = Level::find()->where(['!=','id',0]);

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
            'useable' => $this->useable,
        ]);

        $query->andFilterWhere(['like', 'job_name', $this->job_name]);

        return $dataProvider;
    }
}
