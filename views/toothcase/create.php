<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\toothcase */

$this->title = '新增病例';
$this->params['breadcrumbs'][] = ['label' => '病例', 'url' => ['toothcase']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="toothcase-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
    	'url' => 'create',
        'model' => $model,
        'clinic_model' => $clinic_model,
        'clinic_info' =>$clinic_info,
    ]) ?>

</div>
