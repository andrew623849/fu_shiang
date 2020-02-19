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
$color = '#E0E0E0';
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

    ?>
    <div class="col-sm-4 <?php if($models['material_id_1'] != 0) echo 'hidden' ?>">
    <?php echo DetailView::widget([
        'model' => $models,
        'attributes' => [
            ['label'=>'診所','value'=>$clinic_info[($models->clinic_id-1)]['clinic']],
            ['label'=>'收件日','value'=>$models->start_time],
            ['label'=>'交件日','value'=>$models->end_time],
            ['label'=>'病人姓名','value'=>$models->name],
            ['label'=>'材料1','value'=>$material[($models->material_id)]['material']],
            ['label'=>'齒位','value'=>$models->tooth],
            ['label'=>'齒色','value'=>$models->tooth_color],
            ['label'=>'備註','value'=>$models->remark],
            ['label'=>'金額','value'=>$models->price],
        ],
        'options'=>['class' => 'table table-striped table-bordered detail-view','style'=>$options],
    ]) ?>
    </div>
        <div class="col-sm-4 <?php if($models['material_id_1'] == 0) echo 'hidden' ?>" >
    <?php echo DetailView::widget([
        'model' => $models,
        'attributes' => [
            ['label'=>'診所','value'=>$clinic_info[($models->clinic_id-1)]['clinic']],
            ['label'=>'收件日','value'=>$models->start_time],
            ['label'=>'交件日','value'=>$models->end_time],
            ['label'=>'病人姓名','value'=>$models->name],
            ['label'=>'材料1','value'=>$material[($models->material_id)]['material']],
            ['label'=>'齒位','value'=>$models->tooth],
            ['label'=>'齒色','value'=>$models->tooth_color],
            ['label'=>'材料2','value'=>($models->material_id_1)==0?'':$material[($models->material_id_1)]['material']],
            ['label'=>'齒位','value'=>$models->tooth_1],
            ['label'=>'齒色','value'=>$models->tooth_color_1],
            ['label'=>'備註','value'=>$models->remark],
            ['label'=>'金額','value'=>$models->price],
        ],
        'options'=>['class' => 'table table-striped table-bordered detail-view','style'=>$options],
    ]) ?>
    </div>
        <div class="col-sm-4 <?php if($models['material_id_2'] == 0) echo 'hidden' ?>" >
    <?php echo DetailView::widget([
        'model' => $models,
        'attributes' => [
            ['label'=>'診所','value'=>$clinic_info[($models->clinic_id-1)]['clinic']],
            ['label'=>'收件日','value'=>$models->start_time],
            ['label'=>'交件日','value'=>$models->end_time],
            ['label'=>'病人姓名','value'=>$models->name],
            ['label'=>'材料1','value'=>$material[($models->material_id)]['material']],
            ['label'=>'齒位','value'=>$models->tooth],
            ['label'=>'齒色','value'=>$models->tooth_color],
            ['label'=>'材料2','value'=>($models->material_id_1)==0?'':$material[($models->material_id_1)]['material']],
            ['label'=>'齒位','value'=>$models->tooth_1],
            ['label'=>'齒色','value'=>$models->tooth_color_1],
            ['label'=>'材料3','value'=>($models->material_id_2)==0?'':$material[($models->material_id_2)]['material']],
            ['label'=>'齒位','value'=>$models->tooth_2],
            ['label'=>'齒色','value'=>$models->tooth_color_2],
            ['label'=>'備註','value'=>$models->remark],
            ['label'=>'金額','value'=>$models->price],
        ],
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
