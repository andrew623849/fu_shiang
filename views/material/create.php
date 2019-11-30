<?php

use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model app\models\Material */

$this->title = '新增材料';
$this->params['breadcrumbs'][] = ['label' => '材料', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="material-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
