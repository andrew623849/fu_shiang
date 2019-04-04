<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Outlay */

$this->title = '新增支出';
$this->params['breadcrumbs'][] = ['label' => '支出', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="outlay-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
