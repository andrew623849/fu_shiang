<?php

namespace app\models;
use Yii;
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
            [['id', 'material_id', 'material_id_1', 'material_id_2'], 'integer'],
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
        $query = toothcase::find()->where(['clinic_id'=> $params]);
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
        if (!empty(Yii::$app->request->get('end_time'))){
        	$end_time = explode('~', Yii::$app->request->get('end_time'));
        	if(strtotime($end_time[0])){
				$query->andFilterCompare('end_time', $end_time[0], '>=');//起始時間
			}
			if(!empty($end_time[1]) &&strtotime($end_time[1])){
				$query->andFilterCompare('end_time', date('Y-m-d',strtotime($end_time[1]) + 86400), '<');//結束時間}
			}
        }
		if (!empty(Yii::$app->request->get('start_time'))){
			$start_time = explode('~', Yii::$app->request->get('start_time'));
			if(strtotime($start_time[0])){
				$query->andFilterCompare('start_time', $start_time[0], '>=');//起始時間
			}
			if(!empty($start_time[1]) &&strtotime($start_time[1])){
				$query->andFilterCompare('start_time', date('Y-m-d',strtotime($start_time[1]) + 86400), '<');//結束時間}
			}
        }
		if(!empty(Yii::$app->request->get('material'))){
        	if(in_array(0,Yii::$app->request->get('material'))){
        		$_GET['material'] = '';
			}
			$query->andFilterWhere(['in', 'material_id', Yii::$app->request->get('material')])
				->orFilterWhere(['in', 'material_id_1', Yii::$app->request->get('material')])
				->orFilterWhere(['in', 'material_id_2', Yii::$app->request->get('material')]);
		}
        $query->andFilterWhere(['like', 'name', Yii::$app->request->get('name')])
            ->andFilterWhere(['like', 'remark', $this->remark]);
        return $dataProvider;
    }

	/**
	 * 找出登入者的工作內容
	 *
	 * @param array $params
	 *
	 * @return ActiveDataProvider
	 */
    function getWeekCase()
	{
		return Toothcase::find()->where(['>=','end_time',date('Y-m-d')])->orderBy('end_time')->asArray()->all();
	}

	function getData($id = '')
	{
		if(!empty($id)){
			return Toothcase::find()->where(['in','id',$id])->asArray()->all();
		}else{
			return Toothcase::find()->asArray()->all();
		}
	}
}
