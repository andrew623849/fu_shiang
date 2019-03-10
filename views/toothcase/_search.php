<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\toothcaseSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="toothcase-search">

    <?php $form = ActiveForm::begin([
        'action' => ['toothcase'],
        'method' => 'get',
    ]); ?>
    <div class="container">

        <div class="col-sm-6"><?= $form->field($model, 'start_time') ?></div>
        <div class="col-sm-6"><?= $form->field($model, 'end_time') ?></div>
        <div class="col-sm-6"><?= $form->field($model, 'name') ?></div>
        <div class="col-sm-6"><?= $form->field($model, 'clinic_id') ?></div>
        <?= Html::submitButton('搜尋', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('重設', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
