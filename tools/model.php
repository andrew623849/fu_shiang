<?php
use app\models\Material;
use app\models\Clinic;
use app\models\Toothcase;

//資料表要取得材料名稱要用的
function show_material($var){
	if($var == 'all'){
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
	if($var == 'all'){
	    $clinic_model = new Clinic();
	    $clinic_info=$clinic_model->find()->asArray()->all(); 
		return [$clinic_model,$clinic_info];
	}else{
		$models = new Toothcase();
        $clinic_model = new Clinic();
        $id_max = $models->find()->max('id');
        $id = $models->find()->where(["id"=>$var])->asArray()->one();
        $clinic_info = $clinic_model->find()->where(["id"=>$id['clinic_id']])->asArray()->one();
        return [$clinic_model,$clinic_info,$id_max];
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
function report_num($models,$clinic,$material){
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
		if(substr($v['start_time'],0,4) == date('Y') && substr($v['start_time'], 5,2) =="01"){
			$price_case = price_case($v);
			$price[$v['clinic_id']]['1'] = $price[$v['clinic_id']]['1'] + $price_case;
			$tooth = $v['tooth'] != '' ? count(explode(",",$v['tooth'])):0;
			$tooth1 = $v['tooth_1'] != '' ? count(explode(",",$v['tooth_1'])):0;
			$tooth2 = $v['tooth_2'] != '' ? count(explode(",",$v['tooth_2'])):0;
			$material_name[$v['material_id']]['1'] = $material_name[$v['material_id']]['1'] + $tooth + $tooth1 + $tooth2;
		}
		if(substr($v['start_time'],0,4) == date('Y') && substr($v['start_time'], 5,2) =="02"){
			$price_case = price_case($v);
                        $price[$v['clinic_id']]['2'] = $price[$v['clinic_id']]['2'] + $price_case;
                        $tooth = $v['tooth'] != '' ? count(explode(",",$v['tooth'])):0;
                        $tooth1 = $v['tooth_1'] != '' ? count(explode(",",$v['tooth_1'])):0;
                        $tooth2 = $v['tooth_2'] != '' ? count(explode(",",$v['tooth_2'])):0;
			$material_name[$v['material_id']]['2'] = $material_name[$v['material_id']]['2'] + $tooth + $tooth1 + $tooth2;
		}
		if(substr($v['start_time'],0,4) == date('Y') && substr($v['start_time'], 5,2) =="03"){
			$price_case = price_case($v);
			$price[$v['clinic_id']]['3'] = $price[$v['clinic_id']]['3'] + $price_case;
                        $tooth = $v['tooth'] != '' ? count(explode(",",$v['tooth'])):0;
                        $tooth1 = $v['tooth_1'] != '' ? count(explode(",",$v['tooth_1'])):0;
                        $tooth2 = $v['tooth_2'] != '' ? count(explode(",",$v['tooth_2'])):0;
			$material_name[$v['material_id']]['3'] = $material_name[$v['material_id']]['3'] + $tooth + $tooth1 + $tooth2;
		}
		if(substr($v['start_time'],0,4) == date('Y') && substr($v['start_time'], 5,2) =="04"){
			$price_case = price_case($v);
			$price[$v['clinic_id']]['4'] = $price[$v['clinic_id']]['4'] + $price_case;
                        $tooth = $v['tooth'] != '' ? count(explode(",",$v['tooth'])):0;
                        $tooth1 = $v['tooth_1'] != '' ? count(explode(",",$v['tooth_1'])):0;
                        $tooth2 = $v['tooth_2'] != '' ? count(explode(",",$v['tooth_2'])):0;
			$material_name[$v['material_id']]['4'] = $material_name[$v['material_id']]['4'] + $tooth + $tooth1 + $tooth2;
		}
		if(substr($v['start_time'],0,4) == date('Y') && substr($v['start_time'], 5,2) =="05"){
			$price_case = price_case($v);
			$price[$v['clinic_id']]['5'] = $price[$v['clinic_id']]['5'] + $price_case;
                        $tooth = $v['tooth'] != '' ? count(explode(",",$v['tooth'])):0;
                        $tooth1 = $v['tooth_1'] != '' ? count(explode(",",$v['tooth_1'])):0;
                        $tooth2 = $v['tooth_2'] != '' ? count(explode(",",$v['tooth_2'])):0;
			$material_name[$v['material_id']]['5'] = $material_name[$v['material_id']]['5'] + $tooth + $tooth1 + $tooth2;;
		}
		if(substr($v['start_time'],0,4) == date('Y') && substr($v['start_time'], 5,2) =="06"){
			$price_case = price_case($v);
			$price[$v['clinic_id']]['6'] = $price[$v['clinic_id']]['6'] + $price_case;
                        $tooth = !empty($v['tooth']) ? count(explode(",",$v['tooth'])):0;
                        $tooth1 = !empty($v['tooth_1']) ? count(explode(",",$v['tooth_1'])):0;
                        $tooth2 = !empty($v['tooth_2']) ? count(explode(",",$v['tooth_2'])):0;
			$material_name[$v['material_id']]['6'] = $material_name[$v['material_id']]['6'] + $tooth + $tooth1 + $tooth2;
		}
		if(substr($v['start_time'],0,4) == date('Y') && substr($v['start_time'], 5,2) =="07"){
			$price_case = price_case($v);
			$price[$v['clinic_id']]['7'] = $price[$v['clinic_id']]['7'] + $price_case;
                        $tooth = $v['tooth'] != '' ? count(explode(",",$v['tooth'])):0;
                        $tooth1 = $v['tooth_1'] != '' ? count(explode(",",$v['tooth_1'])):0;
                        $tooth2 = $v['tooth_2'] != '' ? count(explode(",",$v['tooth_2'])):0;
			$material_name[$v['material_id']]['7'] = $material_name[$v['material_id']]['7'] + $tooth + $tooth1 + $tooth2;
		}
		if(substr($v['start_time'],0,4) == date('Y') && substr($v['start_time'], 5,2) =="08"){
			$price_case = price_case($v);
			$price[$v['clinic_id']]['8'] = $price[$v['clinic_id']]['8'] + $price_case;
                        $tooth = $v['tooth'] != '' ? count(explode(",",$v['tooth'])):0;
                        $tooth1 = $v['tooth_1'] != '' ? count(explode(",",$v['tooth_1'])):0;
                        $tooth2 = $v['tooth_2'] != '' ? count(explode(",",$v['tooth_2'])):0;
			$material_name[$v['material_id']]['8'] = $material_name[$v['material_id']]['8'] + $tooth + $tooth1 + $tooth2;
		}
		if(substr($v['start_time'],0,4) == date('Y') && substr($v['start_time'], 5,2) =="09"){
			$price_case = price_case($v);
			$price[$v['clinic_id']]['9'] = $price[$v['clinic_id']]['9'] + $price_case;
                        $tooth = $v['tooth'] != '' ? count(explode(",",$v['tooth'])):0;
                        $tooth1 = $v['tooth_1'] != '' ? count(explode(",",$v['tooth_1'])):0;
                        $tooth2 = $v['tooth_2'] != '' ? count(explode(",",$v['tooth_2'])):0;
			$material_name[$v['material_id']]['9'] = $material_name[$v['material_id']]['9'] + $tooth + $tooth1 + $tooth2;
		}
		if(substr($v['start_time'],0,4) == date('Y') && substr($v['start_time'], 5,2) =="10"){
			$price_case = price_case($v);
			$price[$v['clinic_id']]['10'] = $price[$v['clinic_id']]['10'] + $price_case;
                        $tooth = $v['tooth'] != '' ? count(explode(",",$v['tooth'])):0;
                        $tooth1 = $v['tooth_1'] != '' ? count(explode(",",$v['tooth_1'])):0;
                        $tooth2 = $v['tooth_2'] != '' ? count(explode(",",$v['tooth_2'])):0;
			$material_name[$v['material_id']]['10'] = $material_name[$v['material_id']]['10'] + $tooth + $tooth1 + $tooth2;
		}
		if(substr($v['start_time'],0,4) == date('Y') && substr($v['start_time'], 5,2) =="11"){
			$price_case = price_case($v);
			$price[$v['clinic_id']]['11'] = $price[$v['clinic_id']]['11'] + $price_case;
                        $tooth = $v['tooth'] != '' ? count(explode(",",$v['tooth'])):0;
                        $tooth1 = $v['tooth_1'] != '' ? count(explode(",",$v['tooth_1'])):0;
                        $tooth2 = $v['tooth_2'] != '' ? count(explode(",",$v['tooth_2'])):0;
			$material_name[$v['material_id']]['11'] = $material_name[$v['material_id']]['11'] + $tooth + $tooth1 + $tooth2;
		}
		if(substr($v['start_time'],0,4) == date('Y') && substr($v['start_time'], 5,2) =="12"){
			$price_case = price_case($v);
			$price[$v['clinic_id']]['12'] = $price[$v['clinic_id']]['12'] + $price_case;
                        $tooth = $v['tooth'] != '' ? count(explode(",",$v['tooth'])):0;
                        $tooth1 = $v['tooth_1'] != '' ? count(explode(",",$v['tooth_1'])):0;
                        $tooth2 = $v['tooth_2'] != '' ? count(explode(",",$v['tooth_2'])):0;
			$material_name[$v['material_id']]['12'] = $material_name[$v['material_id']]['12'] + $tooth + $tooth1 + $tooth2;
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
