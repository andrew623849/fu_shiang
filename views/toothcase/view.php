<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $model app\models\toothcase */
$this->title = $clinic_info['clinic'].':病人資料';
$this->params['breadcrumbs'][] = ['label' => '病例', 'url' => ['toothcase']];
$this->params['breadcrumbs'][] = $model->name;
\yii\web\YiiAsset::register($this);
$last_id = ($model->id - 1);
if($last_id == 0){
    $last_id = 1;
}

$next_id = ($model->id + 1);
if($next_id > $id_max){
    $next_id = $id_max;
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
    </p>
<div class="col-sm-1" style="margin-top: 130px; ">
    <?= Html::a('<', ['view', 'id' => $last_id], ['class' => 'btn btn-link']) ?>
</div>
<div class="col-sm-10">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            ['label'=>'病人編號','value'=>$model->id],
            ['label'=>'交件日','value'=>$model->start_time],
            ['label'=>'收件日','value'=>$model->end_time],
            ['label'=>'病人姓名','value'=>$model->name],
            ['label'=>'材料','value'=>$model->material_id],
            ['label'=>'齒位','value'=>$model->tooth],
            ['label'=>'齒色','value'=>$model->tooth_color],
            ['label'=>'備註','value'=>$model->remark],
        ],
    ]) ?>
</div>
<div class="col-sm-1" style="margin-top: 130px;">
<?= Html::a('>', ['view', 'id' => $next_id], ['class' => 'btn btn-link']) ?>
</div>

</div>
