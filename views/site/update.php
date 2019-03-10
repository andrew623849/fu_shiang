<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\toothcase */
$request = Yii::$app->request;
$clinic_id=$request->get('toothcaseSearch');
$clinic=ArrayHelper::map($clinic_info,'id','clinic');
$clinic_id['clinic_id']=$clinic_id['clinic_id']==NULl?1:$clinic_id['clinic_id'];
$this->title = $clinic[$clinic_id['clinic_id']].'(更新資料)';
$this->params['breadcrumbs'][] = ['label' => $clinic[$clinic_id['clinic_id']].'病例', 'url' => ['toothcase']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新資料';
?>
<div class="toothcase-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
    	'url' => 'update',
        'model' => $model,
        'clinic_model' => $clinic_model,
        'clinic_info' =>$clinic_info,
        'material_model'=>$material_model,
        'material_info'=>$material_info,
    ]) ?>


</div>
