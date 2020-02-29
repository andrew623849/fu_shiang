<?php

use app\models\Material;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\toothcaseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$material = Material::find('material')->indexBy('id')->asArray()->all();
?>
<style type="text/css">
    th{
        width:100px;
    }
</style>
<?php $form = ActiveForm::begin([
	'action' => ['toothcase/todaycase'],
	'method' => 'post',
	'options' =>['class'=>'todaycase_time']
]); ?>
<div class="col-md-12">
<?= DateRangePicker::widget([
		'name' => 'time',
		'value' => $time,
		'options'=>['id'=>'todaycase_timerange','class'=>'form-control'],
		'convertFormat' => true,
		'pluginOptions' => [ 'locale' => [ 'format' => 'Y-m-d', 'separator' => '~', ]
		]
]); ?>
</div>

<?php ActiveForm::end(); ?>
<?php 
$clinic = -1;
for($i = 0;$i < count($model);$i ++){
    $models = $model[$i];
    if($models['end_time'] == date('Y-m-d')){
        $options = "border:3px red solid";
    }elseif($models['end_time'] <= date('Y-m-d',strtotime('+3 day'))){
        $options= "border:3px blue solid";
    }else{
        $options = "border:3px solid";
    }
    if($clinic != $models['clinic_id']){
        echo '<hr><div class="col-sm-12"><h2>'.$clinic_info[($models['clinic_id']-1)]['clinic'].'</h2></div>';
        $clinic=$models['clinic_id'];
    }
	$attributes_arr = [];
	$attributes_arr[] = ['label'=>'診所','value'=>$clinic_info[($models->clinic_id-1)]['clinic']];
	$attributes_arr[] = ['label'=>'工作日期','value'=>$models->start_time.' ~ '.$models->end_time];
	if($models['try_time'] != 0){
		$attributes_arr[] = ['label'=>'試戴日','value'=>$models->try_time];

	}
	$attributes_arr[] = ['label'=>'病人姓名','value'=>$models->name];
	$attributes_arr[] = ['label'=>'材料1','value'=>$material[$models['material_id']]['material'].'('.$models->tooth.')'];
    $attributes_arr[] = ['label'=>'齒色','value'=>$models->tooth_color];
    if(!empty($material[$models['material_id']]['make_process'])){
    	$make_p = explode(',', $material[$models['material_id']]['make_process']);
		$make_p_arr = [];
		$make_p_arr[] = ['label'=>'程序','value'=>'負責人'];
    	foreach($make_p as $val){
			$make_p_arr[] =  ['label'=>$val,'value'=>''];
		}
		$attributes_arr[] = ['label'=>'工作流程','format' => 'html','value'=>DetailView::widget([
			'model' => $models,
			'attributes' => $make_p_arr,
			'options'=>['class' => 'table table-striped table-bordered detail-view'],
		])];
	}
	if($models['material_id_1'] != 0){
		$attributes_arr[] = ['label'=>'材料2','value'=>($models->material_id_1==0?'':$material[($models->material_id_1)]['material']).'('.$models->tooth_1.')'];
        $attributes_arr[] = ['label'=>'齒色','value'=>$models->tooth_color_1];
	}
	if(!empty($material[$models['material_id_1']]['make_process'])){
		$make_p = explode(',', $material[$models['material_id_1']]['make_process']);
		$make_p_arr = [];
		$make_p_arr[] = ['label'=>'程序','value'=>'負責人'];
		foreach($make_p as $val){
			$make_p_arr[] =  ['label'=>$val,'value'=>''];
		}
		$attributes_arr[] = ['label'=>'工作流程','format' => 'html','value'=>DetailView::widget([
			'model' => $models,
			'attributes' => $make_p_arr,
			'options'=>['class' => 'table table-striped table-bordered detail-view'],
		])];
	}
	if($models['material_id_2'] != 0){
		$attributes_arr[] = ['label'=>'材料3','value'=>($models->material_id_2==0?'':$material[($models->material_id_1)]['material']).'('.$models->tooth_2.')'];
		$attributes_arr[] = ['label'=>'齒色','value'=>$models->tooth_color_2];
	}
	if(!empty($material[$models['material_id_2']]['make_process'])){
		$make_p = explode(',', $material[$models['material_id_2']]['make_process']);
		$make_p_arr = [];
		$make_p_arr[] = ['label'=>'程序','value'=>'負責人'];
		foreach($make_p as $val){
			$make_p_arr[] =  ['label'=>$val,'value'=>''];
		}
		$attributes_arr[] = ['label'=>'工作流程','format' => 'html','value'=>DetailView::widget([
			'model' => $models,
			'attributes' => $make_p_arr,
			'options'=>['class' => 'table table-striped table-bordered detail-view'],
		])];
	}
	$attributes_arr[] = ['label'=>'備註','value'=>$models->remark];
	$attributes_arr[] = ['label'=>'金額','value'=>$models->price];
    ?>
    <div class="col-sm-4">
    <?php echo DetailView::widget([
        'model' => $models,
        'attributes' => $attributes_arr,
        'options'=>['class' => 'table table-striped table-bordered detail-view','style'=>$options],
    ]) ?>
    </div>
<?php
 }?>
<?php
	$js =<<< JS
	$("#todaycase_timerange").change(function(){
		$('.todaycase_time').submit();
	});
JS;
	$this->registerJs($js);
