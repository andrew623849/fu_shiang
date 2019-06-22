<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AdminSheet */

$this->title = '員工個資資料: ' . $model->user_name;
$this->params['breadcrumbs'][] = '更新資料';
?>
<div class="admin-sheet-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
    	'url' =>'pupdate',
        'model' => $model,
    ]) ?>

</div>
