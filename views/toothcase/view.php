<?php

use kartik\tabs\TabsX;
use yii\helpers\Html;
use app\models\clinicSearch;
use app\models\Material;

/* @var $this yii\web\View */
/* @var $model app\models\toothcase */
$clinic = clinicSearch::GetData();
$this->title = $clinic[$model['clinic_id']]['clinic'].':病人資料';
$this->params['breadcrumbs'][] = ['label' => $clinic[$model['clinic_id']]['clinic'].'病例', 'url' => ['toothcase/toothcase/'.$model['clinic_id']]];
$this->params['breadcrumbs'][] = $model->name;
$material = Material::find('material')->indexBy('id')->asArray()->all();
$items[] = [
	'label'=>$material[$model->material_id]['material'],
	'active'=>true,
	'content'=>Yii::$app->runAction('toothcase/view-m',[
		'id'=>0,
		'tooth'=>$model->tooth,
		'color'=>$model->tooth_color,
		'set'=>$model->material_id,
		'make_p'=>$model->make_p,
		'make_p_f'=>$model->make_p_f,
	]),
];
if(!empty($model->material_id_1)){
	$items[] = [
		'label'=>$material[$model->material_id_1]['material'],
		'content'=>Yii::$app->runAction('toothcase/view-m',[
			'id'=>1,
			'tooth'=>$model->tooth_1,
			'color'=>$model->tooth_color_1,
			'set'=>$model->material_id_1,
			'make_p'=>$model->make_p1,
			'make_p_f'=>$model->make_p1_f,
		]),
	];
}
if(!empty($model->material_id_2)){
	$items[] = [
		'label'=>$material[$model->material_id_2]['material'],
		'content'=>Yii::$app->runAction('toothcase/view-m',[
			'id'=>2,
			'tooth'=>$model->tooth_2,
			'color'=>$model->tooth_color_2,
			'set'=>$model->material_id_2,
			'make_p'=>$model->make_p2,
			'make_p_f'=>$model->make_p2_f,
		]),
	];
}
?>
<div class="toothcase-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('刪除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '確定要刪除此病人資料?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('新增病例',['create','clinic_this' => $model['clinic_id']], ['class' => 'btn btn-success']) ?>
    </p>
	<div class="form-group">
		<label>病人編號：<?= $model->id?></label>
	</div>
	<div class="form-group">
		<label>工作日期：<?= $model->start_time.'~'.$model->end_time?></label>
	</div>
<?php if($model->try_time != ''){?>
	<div class="form-group">
		<label>試戴日：<?= $model->try_time?></label>
	</div>
<?php }?>
	<div class="form-group">
		<label>病人姓名：<?= $model->name?></label>
	</div>
	<div class="form-group">
		<label>金額：<?= $model->price?></label>
	</div>
	<div class="col-sm-12">

    <?= TabsX::widget([
		'items'=>$items,
		'position'=>TabsX::POS_ABOVE,
		'encodeLabels'=>false
	]); ?>
</div>

</div>
