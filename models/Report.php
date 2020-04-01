<?php

namespace app\models;


class Report
{
	//算年度材料數量與月收
	function YearReport($year){
		$price = [];
		$material_name = [];
		$month = ['x', '一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'];
		$material_name[0] = $month;
		$price[0] = $month;
		$clinic = clinicSearch::GetData();
		$material = MaterialSearch::GetMaterialData();
		$models = Toothcase::find()->where(['like','start_time',$year])->asArray()->all();
		foreach($clinic as $k=>$v){
			$price[$k] = [$v['clinic'],0,0,0,0,0,0,0,0,0,0,0,0];
		}
		foreach($material as $k=>$v){
			$material_name[$k] = [$v['material'].'($'.$v['price'].')',0,0,0,0,0,0,0,0,0,0,0,0];
		}
		foreach($models as $k=>$v){
			if(substr($v['end_time'],0,4) == $year){
				$k = (int)substr($v['end_time'], 5,2);
			}
			$price[$v['clinic_id']][$k] = $price[$v['clinic_id']][$k] + $v['price'];
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
		$material_name = array_values($material_name);
		$price = array_values($price);
		$price_out = self::YearOutlay($year);
		$price[] = $price_out;
		return [$material_name,$price];
	}
	//算支出
	function YearOutlay($year){
		$models_outlay = Outlay::find()->where(['like','buy_time',$year])->asArray()->all();
		$price_out = ['支出',0,0,0,0,0,0,0,0,0,0,0,0];
		foreach($models_outlay as $k=>$v){
			if(substr($v['buy_time'],0,4) == date('Y')){
				$k = (int)substr($v['end_time'], 5,2);
			}
			$price_out[$k] = $price_out[$k] + $v['pay_mny'];
		}
		return $price_out;
	}

	//算年度材料數量與月收
	function MonthReport($year){
		$price = [];
		$material_name = [];
		$month = ['x', '一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'];
		$material_name[0] = $month;
		$price[0] = $month;
		$clinic = clinicSearch::GetDataWhere(['=','deleted',1]);
		$material = MaterialSearch::GetDataWhere(['useable'=>0,'deleted'=>0]);
		$models = Toothcase::find()->where(['like','end_time',$year])->asArray()->all();
		foreach($clinic as $k=>$v){
			$price[$k] = [$v['clinic'],0,0,0,0,0,0,0,0,0,0,0,0];
		}
		foreach($material as $k=>$v){
			$material_name[$k] = [$v['material'].'($'.$v['price'].')',0,0,0,0,0,0,0,0,0,0,0,0];
		}
		foreach($models as $k=>$v){
			$k = (int)date('m',strtotime($v['end_time']));
			$price[$v['clinic_id']][$k] = $price[$v['clinic_id']][$k] + $v['price'];
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
		$data = [];
		foreach($price as $val){
			$data[] = $val;
		}
		$material_data = [];
		foreach($material_name as $val){
			$material_data[] = $val;
		}
		$price_out = self::MonthOutlay($year);
		$price[] = $price_out;
		return [$material_data,$data];
	}
	//算支出
	function MonthOutlay($year){
		$models_outlay = Outlay::find()->where(['like','buy_time',$year])->asArray()->all();
		$price_out = ['支出',0,0,0,0,0,0,0,0,0,0,0,0];
		foreach($models_outlay as $k=>$v){
			$k = (int)date('m',strtotime($v['buy_time']));
			$price_out[$k] = $price_out[$k] + $v['pay_mny'];
		}
		return $price_out;
	}

	//算年度材料數量與月收
	function WeekReport($start_time,$end_time){
		$price = [];
		$material_name = [];
		$month = ['x', '周一', '周二', '周三', '周四', '周五', '周六', '周日'];
		$material_name[0] = $month;
		$price[0] = $month;
		$clinic = clinicSearch::GetDataWhere(['=','deleted',1]);
		$material = MaterialSearch::GetDataWhere(['useable'=>0,'deleted'=>0]);
		$models = Toothcase::find()->where(['and',['>=','end_time',$start_time],['<=','end_time',$end_time]])->asArray()->all();
		foreach($clinic as $k=>$v){
			$price[$k] = [$v['clinic'],0,0,0,0,0,0,0];
		}
		foreach($material as $k=>$v){
			$material_name[$k] = [$v['material'].'($'.$v['price'].')',0,0,0,0,0,0,0];
		}
		foreach($models as $k=>$v){
			$k = date('w',strtotime($v['end_time']));
			if($k == 0)$k =7;
			$price[$v['clinic_id']][$k] = $price[$v['clinic_id']][$k] + $v['price'];
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
		$data = [];
		foreach($price as $val){
			$data[] = $val;
		}
		$material_data = [];
		foreach($material_name as $val){
			$material_data[] = $val;
		}
		$price_out = self::WeekOutlay($start_time,$end_time);
		$data[] = $price_out;
		return [$material_data,$data];
	}
	//算支出
	function WeekOutlay($start_time,$end_time){
		$models_outlay = Outlay::find()->where(['and',['>=','buy_time',$start_time],['<=','buy_time',$end_time]])->asArray()->all();
		$price_out = ['支出',0,0,0,0,0,0,0];
		foreach($models_outlay as $k=>$v){
			$k = (int)(date('w',strtotime($v['end_time']))+1);
			$price_out[$k] = $price_out[$k] + $v['pay_mny'];
		}
		return $price_out;
	}
}
