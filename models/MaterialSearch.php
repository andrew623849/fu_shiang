<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Material;

/**
 * MaterialSearch represents the model behind the search form of `app\models\Material`.
 */
class MaterialSearch extends Material
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'sort', 'price', 'deleted', 'useable'], 'integer'],
            [['material', 'build_time', 'modify_time'], 'safe'],
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
        $query = Material::find()->Where($type)->orderBy('sort asc');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
             'pagination' => [
                'route' => 'material/index'
            ],
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
            'sort' => $this->sort,
            'price' => $this->price,
            'build_time' => $this->build_time,
            'deleted' => $this->deleted,
            'useable' => $this->useable,
            'modify_time' => $this->modify_time,
        ]);

        $query->andFilterWhere(['like', 'material', $this->material]);

        return $dataProvider;
    }
	public function UpdateById($type,$id)
	{
		Material::updateAll($type,['=','id',$id]);
	}
	public function ShowData($var,$where,$table_name = '')
	{
		if((string)$var != 'all'){
			$where['id'] = $var;
		}
		$data = Material::find()->where($where)->asArray()->all();
		if(in_array($table_name,array_flip(Material::attributeLabels()))){
			foreach($data as $val){
				$data_1[$val['id']]=$val[$table_name];
			}
			return $data_1;
		}
		return $data;
	}
	public function GetMaterialData($id = '')
	{
		if(!empty($id)){
			return Material::find()->where(['in',"id",$id])->indexBy("id")->asArray()->all();
		}else{
			return Material::find()->indexBy("id")->asArray()->all();
		}
	}
	public function GetDataWhere($arr = '')
	{
		if(!empty($arr)){
			return Material::find()->where($arr)->indexBy("id")->asArray()->all();
		}else{
			return Material::find()->indexBy("id")->asArray()->all();
		}
	}
}
