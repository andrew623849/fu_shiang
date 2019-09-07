<?php
use app\models\Material;
use app\models\Clinic;
use app\models\Toothcase;
use app\models\Level;

//資料表要取得材料名稱要用的
function show_material($var){
	if((string)$var == 'all'){
		$material_model = new Material();
		$material_info = $material_model->find()->asArray()->all();
		return [$material_model,$material_info];
	}else{
		$models = new Toothcase();
		$material_model = new Material();
		$id_max = $models->find()->max('id');
		$id = $models->find()->where(["id"=>$var])->asArray()->one();
		$material_info = $material_model->find()->where(["id"=>$id['material_id']])->asArray()->one();
		$material_info1 = $material_model->find()->where(["id"=>$id['material_id_1']])->asArray()->one();
		$material_info2 = $material_model->find()->where(["id"=>$id['material_id_2']])->asArray()->one();
		return [$material_model,$material_info,$material_info1,$material_info2,$id_max];
	};
}
//資料表要取得診所名稱要用的
function show_clinic($var){
	if((string)$var == 'all'){
	    $clinic_model = new Clinic();
	    $clinic_info=$clinic_model->find()->asArray()->all(); 
		return [$clinic_model,$clinic_info];
	}else{
        $clinic_model = new Clinic();
        $id = $clinic_model->find()->where(["id"=>$var])->asArray()->one();
        return $id;
	}
}
//資料表要取得職稱名稱要用的
function show_level($var){
	if((string)$var == 'all'){
	    $clinic_model = new Level();
	    $clinic_info=$clinic_model->find()->where(["!=","id",0])->asArray()->all(); 
		return [$clinic_model,$clinic_info];
	}else{
		$models = new Level();
        $id = $models->find()->where(["id"=>$var])->asArray()->one();
        return $id['job_name'];
	}
}
//算case價錢
function price_case($arr){
	$material_model = new Material();
	$material_info = $material_model->find()->where(["id"=>$arr['material_id']])->asArray()->one();
	$material_info1 = $material_model->find()->where(["id"=>$arr['material_id_1']])->asArray()->one();
	$material_info2 = $material_model->find()->where(["id"=>$arr['material_id_2']])->asArray()->one();
	$tooth_num = count(explode(",",$arr['tooth']));
	$tooth_num1 = count(explode(",",$arr['tooth_1']));
	$tooth_num2 = count(explode(",",$arr['tooth_2']));
	// v_d([$material_info['price'],$tooth_num,$material_info1['price'],$tooth_num1,$material_info2['price'],$tooth_num2]);
	$price_case = $material_info['price'] * $tooth_num + 
				  $material_info1['price'] * $tooth_num1 + 
				  $material_info2['price'] * $tooth_num2 + 
				  $arr['other_price'] +
				  $arr['other_price_1'] +
				  $arr['other_price_2'];
	return $price_case;
}
//算材料X數量價錢
function price_mm($string,$id){
	$material_model = new Material();
	$material_info = $material_model->find()->where(["id"=>$id])->asArray()->one();
	$tooth_num = count(explode(",",$string));
	 // v_d([$material_info['price'],$tooth_num]);
	$price_case = $material_info['price'] * $tooth_num;
	return $price_case;
}

//找此日期($date)後的第$var天的日期
function today_to($date,$var){
	$d = strtotime($date) + ($var + 1) * 85800;
	return date("Y-m-d",$d);
}
//算年度材料數量與月收
function report_num($models,$clinic,$material,$year){
	$price = [];
	$material_name = [];
	$month = ['x', '一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'];
	$material_name[0] = $month;
	$price[0] = $month;
	foreach($clinic as $k=>$v){
		$price[($k+1)] = [$v['clinic'],0,0,0,0,0,0,0,0,0,0,0,0];
	}
	foreach($material as $k=>$v){
		if($k != 0)
			$material_name[$k] = [$v['material'].'($'.$v['price'].')',0,0,0,0,0,0,0,0,0,0,0,0];
	}
	foreach($models as $k=>$v){
		if(substr($v['start_time'],0,4) == $year && substr($v['start_time'], 5,2) =="01"){
			$k = 1;
		}
		if(substr($v['start_time'],0,4) == $year && substr($v['start_time'], 5,2) =="02"){
			$k = 2;
		}
		if(substr($v['start_time'],0,4) == $year && substr($v['start_time'], 5,2) =="03"){
			$k = 3;
		}
		if(substr($v['start_time'],0,4) == $year && substr($v['start_time'], 5,2) =="04"){
			$k = 4;
		}
		if(substr($v['start_time'],0,4) == $year && substr($v['start_time'], 5,2) =="05"){
			$k = 5;
		}
		if(substr($v['start_time'],0,4) == $year && substr($v['start_time'], 5,2) =="06"){
			$k = 6;
		}
		if(substr($v['start_time'],0,4) == $year && substr($v['start_time'], 5,2) =="07"){
			$k = 7;
		}
		if(substr($v['start_time'],0,4) == $year && substr($v['start_time'], 5,2) =="08"){
			$k = 8;
		}
		if(substr($v['start_time'],0,4) == $year && substr($v['start_time'], 5,2) =="09"){
			$k = 9;
		}
		if(substr($v['start_time'],0,4) == $year && substr($v['start_time'], 5,2) =="10"){
			$k = 10;
		}
		if(substr($v['start_time'],0,4) == $year && substr($v['start_time'], 5,2) =="11"){
			$k = 11;
		}
		if(substr($v['start_time'],0,4) == $year && substr($v['start_time'], 5,2) =="12"){
			$k = 12;
		}
		$price_case = price_case($v);
		$price[$v['clinic_id']][$k] = $price[$v['clinic_id']][$k] + $price_case;
		$tooth = $v['tooth'] != '' ? count(explode(",",$v['tooth'])):0;
		$tooth1 = $v['tooth_1'] != '' ? count(explode(",",$v['tooth_1'])):0;
		$tooth2 = $v['tooth_2'] != '' ? count(explode(",",$v['tooth_2'])):0;
		$material_name[$v['material_id']][$k] = $material_name[$v['material_id']][$k] + $tooth;
		if($tooth1 != 0){
			$material_name[$v['material_id_1']][$k] = $material_name[$v['material_id_1']][$k] + $tooth1;
		}
		if($tooth2 != 0){
			$material_name[$v['material_id_2']][$k] = $material_name[$v['material_id_2']][$k] + $tooth2;
		}
	}
	return $models = [$material_name,$price];
}
//算支出
function outlay($models_outlay){
	$price_out = ['支出',0,0,0,0,0,0,0,0,0,0,0,0];
	foreach($models_outlay as $k=>$v){
		if(substr($v['buy_time'],0,4) == date('Y') && substr($v['buy_time'], 5,2) =="01"){
			$price_out['1'] = $price_out['1'] + $v['pay_mny'];
		}
		if(substr($v['buy_time'],0,4) == date('Y') && substr($v['buy_time'], 5,2) =="02"){
			$price_out['2'] = $price_out['2'] + $v['pay_mny'];
		}
		if(substr($v['buy_time'],0,4) == date('Y') && substr($v['buy_time'], 5,2) =="03"){
			$price_out['3'] = $price_out['3'] + $v['pay_mny'];
		}
		if(substr($v['buy_time'],0,4) == date('Y') && substr($v['buy_time'], 5,2) =="04"){
			$price_out['4'] = $price_out['4'] + $v['pay_mny'];
		}
		if(substr($v['buy_time'],0,4) == date('Y') && substr($v['buy_time'], 5,2) =="05"){
			$price_out['5'] = $price_out['5'] + $v['pay_mny'];
		}
		if(substr($v['buy_time'],0,4) == date('Y') && substr($v['buy_time'], 5,2) =="06"){
			$price_out['6'] = $price_out['6'] + $v['pay_mny'];
		}
		if(substr($v['buy_time'],0,4) == date('Y') && substr($v['buy_time'], 5,2) =="07"){
			$price_out['7'] = $price_out['7'] + $v['pay_mny'];
		}
		if(substr($v['buy_time'],0,4) == date('Y') && substr($v['buy_time'], 5,2) =="08"){
			$price_out['8'] = $price_out['8'] + $v['pay_mny'];
		}
		if(substr($v['buy_time'],0,4) == date('Y') && substr($v['buy_time'], 5,2) =="09"){
			$price_out['9'] = $price_out['9'] + $v['pay_mny'];
		}
		if(substr($v['buy_time'],0,4) == date('Y') && substr($v['buy_time'], 5,2) =="10"){
			$price_out['10'] = $price_out['10'] + $v['pay_mny'];
		}	
		if(substr($v['buy_time'],0,4) == date('Y') && substr($v['buy_time'], 5,2) =="11"){
			$price_out['11'] = $price_out['11'] + $v['pay_mny'];
		}
		if(substr($v['buy_time'],0,4) == date('Y') && substr($v['buy_time'], 5,2) =="12"){
			$price_out['12'] = $price_out['12'] + $v['pay_mny'];
		}
	}
	return $price_out;
}
function level_name($id){
	$id = (string)$id;
	$job_arr =['老闆','經理','高級牙技師','初級牙技師'];
	if($id == 'all'){
		return $job_arr;
	}else{
		return $job_arr[$id];
	}
}
