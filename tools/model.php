<?php
use app\models\material;
use app\models\clinic;
use app\models\toothcase;

//資料表要取得材料名稱要用的
function show_material($var){
	if($var == 'all'){
		$material_model = new material();
		$material_info = $material_model->find()->asArray()->all();
	return [$material_model,$material_info];
	}else{
		$models = new toothcase();
		$material_model = new material();
		$id_max = $models->find()->max('id');
		$id = $models->find()->where(["id"=>$var])->asArray()->one();
		$material_info = $material_model->find()->where(["id"=>$id['material_id']])->asArray()->one();
		return [$material_model,$material_info,$id_max];
	};
}
//資料表要取得診所名稱要用的
function show_clinic($var){
	if($var == 'all'){
	    $clinic_model = new Clinic();
	    $clinic_info=$clinic_model->find()->asArray()->all(); 
		return [$clinic_model,$clinic_info];
	}else{
        $clinic_model = new Clinic();
        $clinic_info = $clinic_model->find()->where(["id"=>$var])->asArray()->one();
        return [$clinic_model,$clinic_info];
	}
}
//算case價錢
function price_case($arr){
	$material_model = new material();
	$material_info = $material_model->find()->where(["id"=>$arr['material_id']])->asArray()->one();
	$tooth_num = count(explode(" ",$arr['tooth']));
	$price_case = $material_info['price'] * $tooth_num + $arr['other_price'];
	return $price_case;
}
//找此日期($date)後的第$var天的日期
function today_to($date,$var){
	$d = strtotime($date) + ($var + 1) * 85800;
	return date("Y-m-d",$d);
}