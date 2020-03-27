<?php

namespace app\console\models;
use app\models\Tool;

class LineMsg
{
	function AddCase($CaseData)
	{
		$user = $CaseData['make_p'];
		$make_p = explode(',',$CaseData['make_p']);
		$make_p_f = explode(',',$CaseData['make_p_f']);
		$make_p_f0 = Tool::WhoNeedLine($make_p,$make_p_f);
		$make_p1[0] = 0;
		$make_p2[0] = 0;
		$make_p1_f0 = 0;
		$make_p2_f0 = 0;
		if(!empty($CaseData['make_p1'])){
			$user .= ','.$CaseData['make_p1'];
			$make_p1 = explode(',',$CaseData['make_p1']);
			$make_p1_f = explode(',',$CaseData['make_p1_f']);
			$make_p1_f0 = Tool::WhoNeedLine($make_p1,$make_p1_f);

			if(!empty($CaseData->make_p2)){
				$user .= ','.$CaseData['make_p2'];
				$make_p2 = explode(',',$CaseData['make_p2']);
				$make_p2_f = explode(',',$CaseData['make_p2_f']);
				$make_p2_f0 = Tool::WhoNeedLine($make_p2,$make_p2_f);

			}
		}
		$user_data = AdminSheetSearch::GetUserData(explode(',',$user));
		$clinic = clinicSearch::GetData();
		$material = MaterialSearch::GetMaterialData();
		foreach($user_data as $key=>$val){
			$data['msg'] = '';
			if($make_p[$make_p_f0] == $key || $make_p1[$make_p1_f0] == $key || $make_p2[$make_p2_f0] == $key){
				$data['message'] = "\r\n".$clinic[$CaseData['clinic_id']]['clinic'].'診所 - 新增一組病例'."\r\n\r\n";
				$data['message'] .= "病人姓名 : ".$CaseData['name']."\r\n";
				$data['message'] .= "交件日 : ".$CaseData['end_time']."\r\n";
				$data['message'] .= "材料1 : ".$material[$CaseData['material_id']]['material']."\r\n";
				$data['message'] .= "齒位 : ".$CaseData['tooth']."\r\n";
				$data['message'] .= "齒色 : ".$CaseData['tooth_color']."\r\n";
				if(!empty($CaseData['material_id_1'])){
					$data['message'] .= "材料2 : ".$material[$CaseData['material_id_1']]['material']."\r\n";
					$data['message'] .= "齒位 : ".$CaseData['tooth_1']."\r\n";
					$data['message'] .= "齒色 : ".$CaseData['tooth_color_1']."\r\n";
				}
				if(!empty($CaseData['material_id_2'])){
					$data['message'] .= "材料3 : ".$material[$CaseData['material_id_2']]['material']."\r\n";
					$data['message'] .= "齒位 : ".$CaseData['tooth_1']."\r\n";
					$data['message'] .= "齒色 : ".$CaseData['tooth_color_2']."\r\n";
				}
				$data['message'] .= "備註:".$CaseData['remark']."\r\n";
				if($make_p[$make_p_f0] == $key){
					$material_id = explode(',',$material[$CaseData['material_id']]['make_process']);
					$material_msg = Tool::MaterialMsg($key,$make_p,$material_id);
					$data['message'] .= "工作程序:".$material_msg."\r\n";
				}elseif($make_p[$make_p_f0] == $key){
					$material_id = explode(',',$material[$CaseData['material_id_1']]['make_process']);
					$material_msg = Tool::MaterialMsg($key,$make_p,$material_id);
					$data['message'] .= "工作程序:".$material_msg."\r\n";
				}elseif($make_p[$make_p_f0] == $key){
					$material_id = explode(',',$material[$CaseData['material_id_2']]['make_process']);
					$material_msg = Tool::MaterialMsg($key,$make_p,$material_id);
					$data['message'] .= "工作程序:".$material_msg."\r\n";
				}
				$data['message'] .= "\r\n"."完成後請登入系統點擊完成~~";
			}
			if(!empty($data['message']) && !empty($val['line_token']))
				LineNotify::snedNotify($val['line_token'],$data);
		}
	}
}
