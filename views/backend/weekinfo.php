<?php

use app\models\AdminSheetSearch;
use app\models\MaterialSearch;
use app\models\Tool;
use app\models\toothcaseSearch;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

$case = toothcaseSearch::getWeekCase();
$material = MaterialSearch::GetMaterialData();

foreach($case as $val){
	$make_p = explode(',',$val['make_p']);
	$make_p_f = explode(',',$val['make_p_f']);
	$make_p_f0 = Tool::WhoNeedLine($make_p,$make_p_f);
	$make_p1 = explode(',',$val['make_p1']);
	$make_p1_f = explode(',',$val['make_p1_f']);
	$make_p1_f0 = Tool::WhoNeedLine($make_p1,$make_p1_f);
	$make_p2 = explode(',',$val['make_p2']);
	$make_p2_f = explode(',',$val['make_p2_f']);
	$make_p2_f0 = Tool::WhoNeedLine($make_p2,$make_p2_f);

	$arr = [];
	if(in_array($_SESSION['user']['id'],$make_p) || in_array($_SESSION['user']['id'],$make_p2) || in_array($_SESSION['user']['id'],$make_p2)){
		$arr[] = ['label'=>'病人姓名','value'=>$val['name']];
		$arr[] = ['label'=>'交件日','value'=>$val['end_time']];

		if(!empty($val['material_id'])){
			$material_id = explode(',',$material[$val['material_id']]['make_process']);
			$material_msg = Tool::MaterialMsgByWeek($make_p,$material_id,$make_p_f);
			$arr[] = ['label'=>'材料1','value'=>$material[$val['material_id']]['material']];
			$arr[] = ['label'=>'齒位','value'=>$val['tooth']];
			$arr[] = ['label'=>'齒色','value'=>$val['tooth_color']];
			$arr[] = ['label'=>'工作程序','format' => 'html','value'=>$material_msg];
		}
		if(!empty($val['material_id_1'])){
			$material_id = explode(',',$material[$val['material_id_1']]['make_process']);
			$material_msg = Tool::MaterialMsgByWeek($make_p1,$material_id,$make_p1_f);

			$arr[] = ['label'=>'材料2','value'=>$material[$val['material_id_1']]['material']];
			$arr[] = ['label'=>'齒位','value'=>$val['tooth_1']];
			$arr[] = ['label'=>'齒色','value'=>$val['tooth_color_1']];
			$arr[] = ['label'=>'工作程序','format' => 'html','value'=>$material_msg];
		}
		if(!empty($val['material_id_2'])){
			$material_id = explode(',',$material[$val['material_id_2']]['make_process']);
			$material_msg = Tool::MaterialMsgByWeek($make_p2,$material_id,$make_p2_f);

			$arr[] = ['label'=>'材料3','value'=>$material[$val['material_id_2']]['material']];
			$arr[] = ['label'=>'齒位','value'=>$val['tooth_2']];
			$arr[] = ['label'=>'齒色','value'=>$val['tooth_color_2']];
			$arr[] = ['label'=>'工作程序','format' => 'html','value'=>$material_msg];
		}
		$arr[] = ['label'=>'備註','value'=>$val['remark']];
		if($_SESSION['user']['id'] == $make_p_f0 || $_SESSION['user']['id'] == $make_p1_f0 || $_SESSION['user']['id'] == $make_p2_f0){
			$arr[] = ['label' => '操作', 'format' => 'raw', 'value' => Html::Button('完成', ['class' => 'btn btn-primary', 'onclick' => 'finishcase('.$val['id'].')'])];
		}else{
			$make_p_list = $make_p_f0.','.$make_p1_f0.','.$make_p2_f0;
			$admin_sheet = AdminSheetSearch::GetUserData($make_p_list);
			$button_str = '';
			foreach($admin_sheet as $aval){
				$button_str .= Html::Button('通知('.$aval['user_name'].')', ['class' => 'btn btn-success', 'onclick' => 'finishcase('.$val['id'].')']);
			}
			$arr[] = ['label' => '操作', 'format' => 'raw', 'value' => $button_str];
		}
	}
	if(!empty($arr)){
		echo '<div class="col-sm-4 case_'.$val['id'].'">';
		echo DetailView::widget([
			'model' => $case,
			'attributes' => $arr,
			'options'=>['class' => 'table table-striped table-bordered detail-view'],
		]);
		echo '</div>';
	}
}

$js = <<<JS
	function finishcase(id){
		$.ajax({
            url: 'finishcase',
            type:"POST",
            data:{
            	'id':id	
            }
        }).done(function(result) {
          	if(result){
          		$(".case_"+ id).hide('300');
          	}
        })
	}
JS;
$this->registerJs($js, View::POS_END);