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
    <?php if($url == 'create'){
     $model ->clinic_id = $clinic_this;
     $i=-7;
     while ($i<=37){ 
        $d = strtotime(date('Y-m-d')) + ($i + 1) * 85800;
        $date_time = date("Y-m-d",$d);
        $date[] = $date_time;
        $i ++;
    }?>
        <div class="form-group col-sm-5"><?= $form->field($model, 'start_time')->label("*收件日")->dropDownList($date,['value' => date('Y-m-d')],['style'=>'border:1px solid ;'])?></div>
        <div class="form-group col-sm-5"><?= $form->field($model, 'end_time')->label("*交件日")->dropDownList($date,['style'=>'border:1px solid ;'])->hint('請記得填寫完整日期',['style' => 'color:red;'])?></div>
        <div class="form-group col-sm-2"><?= $form->field($model,'clinic_id')->label("*診所")->dropDownList(ArrayHelper::map($clinic_info,'id','clinic'),['style'=>'border:1px solid ;'])?></div>
    <?php }else{ ?> 
        <div class="form-group col-sm-5"><?= $form->field($model, 'start_time')->label("*收件日")->textInput() ?></div>
        <div class="form-group col-sm-5"><?= $form->field($model, 'end_time')->label("*交件日")->textInput()?></div>
    <?php } ?>
    <div class="form-group col-sm-6"><?= $form->field($model, 'name')->label("*病人姓名")->textInput(['maxlength' => true]) ?></div>
    <div class="form-group col-sm-6"><?= $form->field($model,'material_id')->label("*材料")->dropDownList(ArrayHelper::map($material_info,'id','material'),['style'=>'border:1px solid ;'])?></div> 
    <div class="form-group col-sm-4"><?= $form->field($model, 'tooth')->label("*齒位")->textInput(['maxlength' => true]) ?></div>
    <div class="form-group col-sm-4"><?= $form->field($model, 'tooth_color')->label("齒色")->textInput(['maxlength' => true]) ?></div>
    <?php if($url == 'create'){ ?>
        <div class="form-group col-sm-4"> <?= $form->field($model, 'other_price')->label("其他費用")->textInput(['value' => 0]) ?></div>
    <?php }else{ ?> 
        <div class="form-group col-sm-4"> <?= $form->field($model, 'other_price')->label("其他費用")->textInput() ?></div>
    <?php } ?>

    <div class="form-group col-sm-12"> <?= $form->field($model, 'remark')->label("備註")->textarea(['rows' => '3']) ?></div>
    <div class="form-group col-sm-12"> <?= $form->field($model, 'price')->label("")->hiddenInput(['value' => -1]) ?></div>
        

    <div class="form-group col-sm-4"><?= Html::submitButton('提交', ['class' => 'btn btn-success']) ?></div>
    
    <?php ActiveForm::end(); ?>

</div>
