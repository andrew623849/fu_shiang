<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AdminSheet */

$this->title = '新增員工';
$this->params['breadcrumbs'][] = ['label' => '員工', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-sheet-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
    	'url' =>'create',
        'model' => $model,
        'job_info' => $job_info
    ]) ?>

</div>
