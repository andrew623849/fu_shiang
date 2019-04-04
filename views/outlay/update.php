<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Outlay */

$this->title = '更新支出:' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '支出', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="outlay-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
