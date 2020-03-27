<?php
namespace app\commands;

use app\console\models\AdminSheet;
use app\console\models\clinicSearch;
use app\console\models\MaterialSearch;
use app\console\models\Toothcase;
use yii\console\Controller;
use yii\console\ExitCode;


class ApiController extends Controller
{
	public function actionEveryDayCase(){
		$admin_user = Adminsheet::find()->where(['=','job',1])->asArray()->all();
		$today_case = Toothcase::find()->where(['=','end_time',date('Y-m-d')])->asArray()->all();
		$material = MaterialSearch::GetMaterialData();
		$clinic = clinicSearch::GetData();
		if(!empty($today_case)){
			$data = [];
			foreach($today_case as $val){
				$data[$val['clinic_id']]['msg'][$val['id']] = "     姓名：".$val['name']."\r\n"."     材料：".$material[$val['material_id']]['material']."\r\n"."     齒位：".$val['tooth']."\r\n";
				if(!empty($val['material_id_1'])){
					$data[$val['clinic_id']]['msg'][$val['id']] .= "     材料2：".$material[$val['material_id_1']]['material']."\r\n"."     齒位：".$val['tooth_1']."\r\n";
				}
				if(!empty($val['material_id_2'])){
					$data[$val['clinic_id']]['msg'][$val['id']] .= "     材料2：".$material[$val['material_id_2']]['material']."\r\n"."     齒位：".$val['tooth_2']."\r\n";
				}
			}
			$send_data['message'] = '';
			foreach($data as $key=>$val){
				$send_data['message'] .= "診所：".$clinic[$key]['clinic']."\r\n";
				foreach($val['msg'] as $vval){
					$send_data['message'] .= $vval."\r\n";
				}
				$send_data['message'] .= "==================\r\n";
			}
			foreach($admin_user as $val){
				$snedNotify['message'] = $val['user_name']."你好\r\n這是".date('Y-m-d')."要交件的病例"."\r\n\r\n".$send_data['message'];
				$return = LineNotify::snedNotify($val['line_token'],$snedNotify);
				if($return['message'] == 'ok'){
					echo $val['user_name']."每日提醒繳件MSG發送成功\r\n";
				}else{
					echo $val['user_name']."每日提醒繳件MSG發送失敗\r\n";
				}
			}
		}
		return ExitCode::OK;
	}
}