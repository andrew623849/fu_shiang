<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AdminSheet */

$this->title = '更新員工資料: ' . $model->user_name;
$this->params['breadcrumbs'][] = ['label' => '員工', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新資料';
?>
<div class="admin-sheet-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
    	'url' =>'update',
        'model' => $model,
    ]) ?>

</div>
