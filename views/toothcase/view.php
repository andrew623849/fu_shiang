<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\clinicSearch;
use app\models\MaterialSearch;

/* @var $this yii\web\View */
/* @var $model app\models\toothcase */
$clinic = clinicSearch::ShowData('all',[],'');

$this->title = $clinic[$model['clinic_id']-1]['clinic'].':病人資料';
$this->params['breadcrumbs'][] = ['label' => $clinic[$model['clinic_id']-1]['clinic'].'病例', 'url' => ['toothcase/'.$model['clinic_id']]];
$this->params['breadcrumbs'][] = $model->name;
\yii\web\YiiAsset::register($this);
$material = MaterialSearch::ShowData('all',[],'material');
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

	<div class="col-sm-12">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            ['label'=>'病人編號','value'=>$model->id],
            ['label'=>'交件日','value'=>$model->end_time],
            ['label'=>'收件日','value'=>$model->start_time],
            ['label'=>'試戴日','value'=>$model->try_time],
            ['label'=>'病人姓名','value'=>$model->name],
            ['label'=>'材料1','value'=>$material[$model->material_id]],
            ['label'=>'齒位','value'=>$model->tooth],
            ['label'=>'齒色','value'=>$model->tooth_color],
            ['label'=>'材料2','value'=>!empty($model->material_id_1)?$material[$model->material_id_1]:'無'],
            ['label'=>'齒位','value'=>$model->tooth_1],
            ['label'=>'齒色','value'=>$model->tooth_color_1],
            ['label'=>'材料3','value'=>!empty($model->material_id_2)?$material[$model->material_id_2]:'無'],
            ['label'=>'齒位','value'=>$model->tooth_2],
            ['label'=>'齒色','value'=>$model->tooth_color_2],
            ['label'=>'備註','value'=>$model->remark],
            ['label'=>'金額','value'=>$model->price],
        ],
        'template' => '<tr><th>{label}</th><td>{value}</td></tr>',
    ]) ?>
</div>

</div>
