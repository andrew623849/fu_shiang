<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Clinic */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="clinic-form">

    <?php $form = ActiveForm::begin();
    if($type == 'create'){ 
        echo $form->field($model, 'id')->label('')->hiddenInput(['value' => ($max_id['id']+1)]);
    } ?>

    <?= $form->field($model, 'clinic')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput() ?>

    <?= $form->field($model, 'adress')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
