<?php
use app\models\material;
use app\models\clinic;
use app\models\toothcase;

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

function show_clinic($var){
	if($var == 'all'){
	    $clinic_model = new Clinic();
	    $clinic_info=$clinic_model->find()->asArray()->all(); 
		return [$clinic_model,$clinic_info];
	}else{
		$models = new toothcase();
        $clinic_model = new Clinic();
        $id = $models->find()->where(["id"=>$var])->asArray()->one();
        $clinic_info = $clinic_model->find()->where(["id"=>$id['clinic_id']])->asArray()->one();
        return [$clinic_model,$clinic_info];
	}
}

function price_case($arr){
	$material_model = new material();
	$material_info = $material_model->find()->where(["id"=>$arr['material_id']])->asArray()->one();
	$tooth_num = count(explode(" ",$arr['tooth']));
	$price_case = $material_info['price'] * $tooth_num;
	return $price_case;
}
