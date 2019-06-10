<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Clinic */

$this->title = '更新診所資料: ' . $model->clinic;
$this->params['breadcrumbs'][] = ['label' => '診所', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->clinic, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新資料';
?>
<div class="clinic-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'type' => 'update',
    ]) ?>

</div>
