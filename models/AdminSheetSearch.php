<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AdminSheet;

/**
 * AdminsheetSearch represents the model behind the search form of `app\models\AdminSheet`.
 */
class AdminsheetSearch extends AdminSheet
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'job', 'user_pay'], 'integer'],
            [['em_num', 'admin', 'password', 'build_time', 'user_name', 'user_phone', 'user_email', 'user_f_na', 'user_f_ph', 'user_exp', 'user_grade', 'remark'], 'safe'],
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
        $query = AdminSheet::find()->Where($type);
        $query->joinWith(['level']);/*这里的articlecategory是article模型里面关联的方法名，除了首字母，其他都要完全一样，否则会报错*/

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
            'user_pay' => $this->user_pay,
        ]);

        $query->andFilterWhere(['like', 'user_name', $this->user_name])
            ->andFilterWhere(['like', 'user_phone', $this->user_phone])
            ->andFilterWhere(['like', 'job', $this->job])
            ->andFilterWhere(['like', 'user_email', $this->user_email]);
        return $dataProvider;
    }

	public function GetUserData($id = '')
	{
		if(!empty($id)){
			return AdminSheet::find()->where(['in',"id",$id])->indexBy("id")->asArray()->all();
		}else{
			return AdminSheet::find()->indexBy("id")->asArray()->all();
		}
	}
}
