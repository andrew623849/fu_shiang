<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\toothcase */
$this->title = $clinic_model['clinic'].'(更新資料)';
$this->params['breadcrumbs'][] = ['label' => $clinic_model['clinic'].'病例', 'url' => ['toothcase','toothcaseSearch[clinic_id]'=>$model['clinic_id']]];
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
