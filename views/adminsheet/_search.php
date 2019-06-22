<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AdminsheetSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admin-sheet-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'admin') ?>

    <?= $form->field($model, 'password') ?>

    <?= $form->field($model, 'build_time') ?>

    <?php // echo $form->field($model, 'job') ?>

    <?php // echo $form->field($model, 'user_name') ?>

    <?php // echo $form->field($model, 'user_phone') ?>

    <?php // echo $form->field($model, 'user_email') ?>

    <?php // echo $form->field($model, 'user_pay') ?>

    <?php // echo $form->field($model, 'user_f_na') ?>

    <?php // echo $form->field($model, 'user_f_ph') ?>

    <?php // echo $form->field($model, 'user_exp') ?>

    <?php // echo $form->field($model, 'user_grade') ?>

    <?php // echo $form->field($model, 'remark') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
