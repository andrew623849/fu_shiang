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
	$material_model = new Material();
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
		$material_name[($k+1)] = [$v['material'].'($'.$v['price'].')',0,0,0,0,0,0,0,0,0,0,0,0];
	}
	foreach($models as $k=>$v){
		if(substr($v['end_time'],0,4) == date('Y') && substr($v['end_time'], 5,2) =="01"){
			$price_case = Price_case($v);
			$price[$v['clinic_id']]['1'] = $price[$v['clinic_id']]['1'] + $price_case;
			$material_name[$v['material_id']]['1'] = $material_name[$v['material_id']]['1'] + count(explode(" ",$v['tooth']));
		}
		if(substr($v['end_time'],0,4) == date('Y') && substr($v['end_time'], 5,2) =="02"){
			$price_case = Price_case($v);
			$price[$v['clinic_id']]['2'] = $price[$v['clinic_id']]['2'] + $price_case;
			$material_name[$v['material_id']]['2'] = $material_name[$v['material_id']]['2'] + count(explode(" ",$v['tooth']));
		}
		if(substr($v['end_time'],0,4) == date('Y') && substr($v['end_time'], 5,2) =="03"){
			$price_case = Price_case($v);
			$price[$v['clinic_id']]['3'] = $price[$v['clinic_id']]['3'] + $price_case;
			$material_name[$v['material_id']]['3'] = $material_name[$v['material_id']]['3'] + count(explode(" ",$v['tooth']));
		}
		if(substr($v['end_time'],0,4) == date('Y') && substr($v['end_time'], 5,2) =="04"){
			$price_case = Price_case($v);
			$price[$v['clinic_id']]['4'] = $price[$v['clinic_id']]['4'] + $price_case;
			$material_name[$v['material_id']]['4'] = $material_name[$v['material_id']]['4'] + count(explode(" ",$v['tooth']));
		}
		if(substr($v['end_time'],0,4) == date('Y') && substr($v['end_time'], 5,2) =="05"){
			$price_case = Price_case($v);
			$price[$v['clinic_id']]['5'] = $price[$v['clinic_id']]['5'] + $price_case;
			$material_name[$v['material_id']]['5'] = $material_name[$v['material_id']]['5'] + count(explode(" ",$v['tooth']));
		}
		if(substr($v['end_time'],0,4) == date('Y') && substr($v['end_time'], 5,2) =="06"){
			$price_case = Price_case($v);
			$price[$v['clinic_id']]['6'] = $price[$v['clinic_id']]['6'] + $price_case;
			$material_name[$v['material_id']]['6'] = $material_name[$v['material_id']]['6'] + count(explode(" ",$v['tooth']));
		}
		if(substr($v['end_time'],0,4) == date('Y') && substr($v['end_time'], 5,2) =="07"){
			$price_case = Price_case($v);
			$price[$v['clinic_id']]['7'] = $price[$v['clinic_id']]['7'] + $price_case;
			$material_name[$v['material_id']]['7'] = $material_name[$v['material_id']]['7'] + count(explode(" ",$v['tooth']));
		}
		if(substr($v['end_time'],0,4) == date('Y') && substr($v['end_time'], 5,2) =="08"){
			$price_case = Price_case($v);
			$price[$v['clinic_id']]['8'] = $price[$v['clinic_id']]['8'] + $price_case;
			$material_name[$v['material_id']]['8'] = $material_name[$v['material_id']]['8'] + count(explode(" ",$v['tooth']));
		}
		if(substr($v['end_time'],0,4) == date('Y') && substr($v['end_time'], 5,2) =="09"){
			$price_case = Price_case($v);
			$price[$v['clinic_id']]['9'] = $price[$v['clinic_id']]['9'] + $price_case;
			$material_name[$v['material_id']]['9'] = $material_name[$v['material_id']]['9'] + count(explode(" ",$v['tooth']));
		}
		if(substr($v['end_time'],0,4) == date('Y') && substr($v['end_time'], 5,2) =="10"){
			$price_case = Price_case($v);
			$price[$v['clinic_id']]['10'] = $price[$v['clinic_id']]['10'] + $price_case;
			$material_name[$v['material_id']]['10'] = $material_name[$v['material_id']]['10'] + count(explode(" ",$v['tooth']));
		}	
		if(substr($v['end_time'],0,4) == date('Y') && substr($v['end_time'], 5,2) =="11"){
			$price_case = Price_case($v);
			$price[$v['clinic_id']]['11'] = $price[$v['clinic_id']]['11'] + $price_case;
			$material_name[$v['material_id']]['11'] = $material_name[$v['material_id']]['11'] + count(explode(" ",$v['tooth']));
		}
		if(substr($v['end_time'],0,4) == date('Y') && substr($v['end_time'], 5,2) =="12"){
			$price_case = Price_case($v);
			$price[$v['clinic_id']]['12'] = $price[$v['clinic_id']]['12'] + $price_case;
			$material_name[$v['material_id']]['12'] = $material_name[$v['material_id']]['12'] + count(explode(" ",$v['tooth']));
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