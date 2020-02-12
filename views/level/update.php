<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Level */

$this->title = '更新職權: ' . $model->job_name;
$this->params['breadcrumbs'][] = ['label' => '職權', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->job_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="level-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'type' => 'update',
    ]) ?>

</div>
