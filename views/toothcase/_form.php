<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\toothcase */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="toothcase-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?php if($url == 'create'){ ?>
    <?= $form->field($model, 'start_time')->label("收件日")->textInput(['value' => date('Y-m-d')]) ?>
    <?= $form->field($model, 'end_time')->label("交件日")->textInput(['value' => date('Y-m')])?>
    <?= $form->field($clinic_model,'clinic')->dropDownList(ArrayHelper::map($clinic_info,'id','clinic'),['style'=>'border:1px solid ;width:150px;'])?>
    <?php }else{ ?>
    <?= $form->field($model, 'start_time')->label("收件日")->textInput() ?>
    <?= $form->field($model, 'end_time')->label("交件日")->textInput()?>
    <?php } ?>
    <?= $form->field($model, 'name')->label("病人姓名")->textInput(['maxlength' => true])->hint('請輸入病人名') ?>

    <?= $form->field($model, 'material_id')->label("材料")->textInput()->hint('1:post 2:臨時假牙 3:鈷鉻金屬 ') ?>

    <?= $form->field($model, 'tooth')->label("齒位")->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tooth_color')->label("齒色")->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'remark')->label("備註")->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('儲存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
