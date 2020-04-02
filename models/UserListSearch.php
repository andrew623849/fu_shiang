<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\UserList;

/**
 * MaterialSearch represents the model behind the search form of `app\models\Material`.
 */
class UserListSearch extends UserList
{
    /**
     * {@inheritdoc}
     */
	public function rules()
	{
		return [
			[['user_company_num','user_mny'], 'integer'],
			[['start_time', 'end_time'], 'safe'],
			[['code', 'user_admin', 'company_name', 'user_name', 'user_email', 'user_cellphone', 'user_address', 'user_phone'], 'string', 'max' => 64],
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
        $query = UserList::find()->Where($type);

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
			'code' => $this->code,
			'company_name' => $this->company_name,
			'user_name' => $this->user_name,
			'user_email' => $this->user_email,
			'user_cellphone' => $this->user_cellphone,
			'user_address' => $this->user_address,
			'user_phone' => $this->user_phone,
			'user_mny' => $this->user_mny,
			'start_time' => $this->start_time,
			'end_time' => $this->end_time,

        ]);


        return $dataProvider;
    }
}
