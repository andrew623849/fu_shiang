<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Clinic */

$this->title = '新增診所';
$this->params['breadcrumbs'][] = ['label' => '診所', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clinic-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'max_id'=>$max_id,
        'type'=>'create',
    ]) ?>

</div>
