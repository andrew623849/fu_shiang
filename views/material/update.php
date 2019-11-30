<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Material */

$this->title = '更新: ' . $model->material;
$this->params['breadcrumbs'][] = ['label' => '材料', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->material, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="material-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
