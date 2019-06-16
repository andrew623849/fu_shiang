<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $model app\models\toothcase */
$this->title = $clinic[$model['clinic_id']-1]['clinic'].':病人資料';
$this->params['breadcrumbs'][] = ['label' => $clinic[$model['clinic_id']-1]['clinic'].'病例', 'url' => ['toothcase','toothcaseSearch[clinic_id]'=>$model['clinic_id']]];
$this->params['breadcrumbs'][] = $model->name;
\yii\web\YiiAsset::register($this);
$last_id = ($model->id - 1);
if($last_id == 0){
    $last_id = $id_max;
}

$next_id = ($model->id + 1);
if($next_id > $id_max){
    $next_id = 1;
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
<div class="col-sm-1">
    <?= Html::a('上張單', ['view', 'id' => $last_id], ['class' => 'btn btn-sm btn-default']) ?>
</div>
<div class="col-sm-10">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            ['label'=>'病人編號','value'=>$model->id],
            ['label'=>'交件日','value'=>$model->end_time],
            ['label'=>'收件日','value'=>$model->start_time],
            ['label'=>'試戴日','value'=>$model->try_time],
            ['label'=>'病人姓名','value'=>$model->name],
            ['label'=>'材料1','value'=>$material_info['material']],
            ['label'=>'齒位','value'=>$model->tooth],
            ['label'=>'齒色','value'=>$model->tooth_color],
            ['label'=>'材料2','value'=>$material_info1['material']],
            ['label'=>'齒位','value'=>$model->tooth_1],
            ['label'=>'齒色','value'=>$model->tooth_color_1],
            ['label'=>'材料3','value'=>$material_info2['material']],
            ['label'=>'齒位','value'=>$model->tooth_2],
            ['label'=>'齒色','value'=>$model->tooth_color_2],
            ['label'=>'備註','value'=>$model->remark],
            ['label'=>'金額','value'=>$model->price],
        ],
        'template' => '<tr><th>{label}</th><td>{value}</td></tr>',
    ]) ?>
</div>
<div class="col-sm-1">
<?= Html::a('下張單', ['view', 'id' => $next_id], ['class' => 'btn btn-sm btn-default']) ?>
</div>

</div>
