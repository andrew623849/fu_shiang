<?php

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
	if($_SESSION['user']['id'] == $make_p_f0 || $_SESSION['user']['id'] == $make_p1_f0 || $_SESSION['user']['id'] == $make_p2_f0){
		$arr[] = ['label'=>'病人姓名','value'=>$val['name']];
		$arr[] = ['label'=>'交件日','value'=>$val['end_time']];

		if($_SESSION['user']['id'] == $make_p_f0){
			$material_id = explode(',',$material[$val['material_id']]['make_process']);
			$material_msg = Tool::MaterialMsg($_SESSION['user']['id'],$make_p,$material_id);
			$arr[] = ['label'=>'材料1','value'=>$material[$val['material_id']]['material']];
			$arr[] = ['label'=>'齒位','value'=>$val['tooth']];
			$arr[] = ['label'=>'齒色','value'=>$val['tooth_color']];
			$arr[] = ['label'=>'工作程序','value'=>$material_msg];
		}
		if($_SESSION['user']['id'] == $make_p1_f0){
			$material_id = explode(',',$material[$val['material_id_1']]['make_process']);
			$material_msg = Tool::MaterialMsg($_SESSION['user']['id'],$make_p1,$material_id);

			$arr[] = ['label'=>'材料2','value'=>$material[$val['material_id_1']]['material']];
			$arr[] = ['label'=>'齒位','value'=>$val['tooth_1']];
			$arr[] = ['label'=>'齒色','value'=>$val['tooth_color_1']];
			$arr[] = ['label'=>'工作程序','value'=>$material_msg];
		}
		if($_SESSION['user']['id'] == $make_p2_f0){
			$material_id = explode(',',$material[$val['material_id_2']]['make_process']);
			$material_msg = Tool::MaterialMsg($_SESSION['user']['id'],$make_p2,$material_id);

			$arr[] = ['label'=>'材料3','value'=>$material[$val['material_id_2']]['material']];
			$arr[] = ['label'=>'齒位','value'=>$val['tooth_2']];
			$arr[] = ['label'=>'齒色','value'=>$val['tooth_color_2']];
			$arr[] = ['label'=>'工作程序','value'=>$material_msg];
		}
		$arr[] = ['label'=>'備註','value'=>$val['remark']];
		$arr[] = ['label'=>'完成按鈕', 'format'=>'raw','value'=>Html::Button('完成', ['class' => 'btn btn-primary','onclick'=>'finishcase('.$val['id'].')'])];
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