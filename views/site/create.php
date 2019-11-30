<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\toothcase */
$request = Yii::$app->request;
$clinic_id=$request->get('toothcaseSearch');
$clinic=ArrayHelper::map($clinic_info,'id','clinic');
$clinic_id['clinic_id']=$clinic_id['clinic_id']==NULl?1:$clinic_id['clinic_id'];
$this->title = '新增病例';
$this->params['breadcrumbs'][] = ['label' => $clinic[$clinic_this].'病例', 'url' => ['toothcase','toothcaseSearch[clinic_id]'=>$clinic_this]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="toothcase-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
    	'url' => 'create',
        'model' => $model,
        'clinic_model' => $clinic_model,
        'clinic_info' =>$clinic_info,
        'clinic_this'=>$clinic_this,
    ]) ?>

</div>
