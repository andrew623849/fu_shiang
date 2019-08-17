<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Level */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="level-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'job_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'build_time')->textInput() ?>

    <?= $form->field($model, 'build_id')->textInput() ?>

    <?= $form->field($model, 'useable')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
