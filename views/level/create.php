<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Level */

$this->title = '新增職權';
$this->params['breadcrumbs'][] = ['label' => '職權', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="level-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
