<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\toothcase */

$this->title = $model->clinic_id.':更新資料 ';
$this->params['breadcrumbs'][] = ['label' => '病例', 'url' => ['toothcase']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新資料';
?>
<div class="toothcase-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'url' => 'update',
        'clinic_model' => $clinic_model,
        'clinic_info' =>$clinic_info,
    ]) ?>

</div>
