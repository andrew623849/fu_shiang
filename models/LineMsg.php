<?php

namespace app\models;


class LineMsg
{
	function AddCase($CaseData)
	{
		$user = $CaseData->make_p;
		$make_p = explode(',',$CaseData->make_p)[0];
		$make_p1 = 0;
		$make_p2 = 0;
		if(!empty($CaseData->make_p1)){
			$user .= ','.$CaseData->make_p1;
			$make_p1 = explode(',',$CaseData->make_p1)[0];
			if(!empty($CaseData->make_p2)){
				$user .= ','.$CaseData->make_p2;
				$make_p2 = explode(',',$CaseData->make_p2)[0];
			}
		}
		$user_data = AdminSheetSearch::GetUserData($user);
		$material = MaterialSearch::GetMaterialData();
		foreach($user_data as $key=>$val){
			$data['msg'] = '';
			if($make_p == $key || $make_p1 == $key || $make_p2 == $key){
				$data['message'] = "\r\n".$CaseData['clinic']['clinic'].'診所 - 新增一組病例'."\r\n\r\n";
				$data['message'] .= "病人姓名 : ".$CaseData->name."\r\n";
				$data['message'] .= "交件日 : ".$CaseData->end_time."\r\n";
				$data['message'] .= "材料1 : ".$material[$CaseData->material_id]['material']."\r\n";
				$data['message'] .= "齒位 : ".$CaseData->tooth."\r\n";
				$data['message'] .= "齒色 : ".$CaseData->tooth_color."\r\n";
				if(!empty($CaseData->material_id_1)){
					$data['message'] .= "材料2 : ".$material[$CaseData->material_id_1]['material']."\r\n";
					$data['message'] .= "齒位 : ".$CaseData->tooth_1."\r\n";
					$data['message'] .= "齒色 : ".$CaseData->tooth_color_1."\r\n";
				}
				if(!empty($CaseData->material_id_2)){
					$data['message'] .= "材料3 : ".$material[$CaseData->material_id_2]['material']."\r\n";
					$data['message'] .= "齒位 : ".$CaseData->tooth_1."\r\n";
					$data['message'] .= "齒色 : ".$CaseData->tooth_color_2."\r\n";
				}
				$data['message'] .= "備註:".$CaseData->remark."\r\n";
				if($make_p == $key){
					$data['message'] .= "進度:".explode(',',$material[$CaseData->material_id]['make_process'])[0]."\r\n";
				}elseif($make_p1 == $key){
					$data['message'] .= "進度:".explode(',',$material[$CaseData->material_id_1]['make_process'])[0]."\r\n";
				}else{
					$data['message'] .= "進度:".explode(',',$material[$CaseData->material_id_2]['make_process'])[0]."\r\n";
				}
				$data['message'] .= "完成後請登入系統點擊完成~~";
			}
			if(!empty($data['message']) && !empty($val['line_token']))
				LineNotify::snedNotify($val['line_token'],$data);
		}
	}



}
