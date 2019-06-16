<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model app\models\toothcase */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="toothcase-form">
    <?php $form = ActiveForm::begin(); ?>
    <?php if($url == 'create'){
     $model ->clinic_id = $clinic_this;
     $i=-35;
     while ($i<=35){ 
        $d = strtotime(date('Y-m-d')) + ($i + 1) * 85800;
        $date_time = date("Y-m-d",$d);
        $date[$date_time] = $date_time;
        $i ++;
    }?>
        <div class="form-group col-sm-4"><?= $form->field($model, 'start_time')->label("*收件日")->dropDownList($date,['value' => date('Y-m-d')],['style'=>'border:1px solid ;'])?></div>
        <div class="form-group col-sm-4"><?= $form->field($model, 'end_time')->label("*交件日")->dropDownList($date,['value' => date('Y-m-d')],['style'=>'border:1px solid ;'])?></div>
        <div class="form-group col-sm-4"><?= $form->field($model, 'try_time')->label("*試戴日")->textInput() ?></div>
    <?php }else{ ?> 
        <div class="form-group col-sm-4"><?= $form->field($model, 'start_time')->label("*收件日")->textInput() ?></div>
        <div class="form-group col-sm-4"><?= $form->field($model, 'end_time')->label("*交件日")->textInput()?></div>
        <div class="form-group col-sm-4"><?= $form->field($model, 'try_time')->label("*試戴日")->textInput() ?></div>
    <?php } ?>
    <div class="form-group col-sm-6" style="height:99px;"><?= $form->field($model, 'name')->label("*病人姓名")->textInput(['maxlength' => true]) ?></div>
    <div class="form-group col-sm-6" style="height:99px;"><?= $form->field($model,'clinic_id')->label("*診所")->dropDownList(ArrayHelper::map($clinic_info,'id','clinic'),['style'=>'border:1px solid ;'])?></div>
    <div class="form-group col-sm-12" style="background-color:#E8E8E8;">
        <div class="form-group col-sm-6" style="height:99px;"><?= $form->field($model,'material_id')->label("*材料1")->dropDownList(ArrayHelper::map($material_info,'id','material'),['style'=>'border:1px solid ;'])?></div> 
        <div class="form-group col-sm-6" style="height:99px;"><?= $form->field($model, 'tooth')->label("*齒位")->textInput(['maxlength' => true]) ?></div>
        <div class="form-group col-sm-6" style="height:99px;"><?= $form->field($model, 'tooth_color')->label("齒色")->textInput(['maxlength' => true]) ?></div>
        <?php if($url == 'create'){ ?>
            <div class="form-group col-sm-6"> <?= $form->field($model, 'other_price')->label("其他費用")->textInput(['value' => 0]) ?></div>
        <?php }else{ ?> 
            <div class="form-group col-sm-6"> <?= $form->field($model, 'other_price')->label("其他費用")->textInput() ?></div>
        <?php } ?>
    </div>
    <div class="form-group col-sm-12 material_id_1" style="background-color:#E8E8E8;" <?php if($model['material_id_1'] == 0){echo 'hidden';$val= "'value'=>0";}else{$val='';}?>>
        <input class="btn btn-danger" style="margin-left: 98.3%;" type="button" id="m_del_btn_1" value="x">
        <div class="form-group col-sm-6" style="height:99px;"><?= $form->field($model,'material_id_1')->label("*材料2")->dropDownList(ArrayHelper::map($material_info,'id','material'),['style'=>'border:1px solid ;',$val])?></div> 
        <div class="form-group col-sm-6" style="height:99px;"><?= $form->field($model, 'tooth_1')->label("*齒位")->textInput(['maxlength' => true]) ?></div>
        <div class="form-group col-sm-6" style="height:99px;"><?= $form->field($model, 'tooth_color_1')->label("齒色")->textInput(['maxlength' => true]) ?></div>
        <?php if($url == 'create'){ ?>
            <div class="form-group col-sm-6"> <?= $form->field($model, 'other_price_1')->label("其他費用")->textInput(['value' => 0]) ?></div>
        <?php }else{ ?> 
            <div class="form-group col-sm-6"> <?= $form->field($model, 'other_price_1')->label("其他費用")->textInput() ?></div>
        <?php } ?>
    </div>
    <div class="form-group col-sm-12 material_id_2" style="background-color:#E8E8E8;" <?php if($model['material_id_2'] == 0){echo 'hidden';$val= "'value'=>0";}else{$val='';}?>>
        <input class="btn btn-danger right" style="margin-left:  98.3%;" type="button" id="m_del_btn_2" value="x">
        <div class="form-group col-sm-6" style="height:99px;"><?= $form->field($model,'material_id_2')->label("*材料3")->dropDownList(ArrayHelper::map($material_info,'id','material'),['style'=>'border:1px solid ;',$val])?></div> 
        <div class="form-group col-sm-6" style="height:99px;"><?= $form->field($model, 'tooth_2')->label("*齒位")->textInput(['maxlength' => true]) ?></div>
        <div class="form-group col-sm-6" style="height:99px;"><?= $form->field($model, 'tooth_color_2')->label("齒色")->textInput(['maxlength' => true]) ?></div>
        <?php if($url == 'create'){ ?>
            <div class="form-group col-sm-6"> <?= $form->field($model, 'other_price_2')->label("其他費用")->textInput(['value' => 0]) ?></div>
        <?php }else{ ?> 
            <div class="form-group col-sm-6"> <?= $form->field($model, 'other_price_2')->label("其他費用")->textInput() ?></div>
        <?php } ?>
    </div>
    <input class="col-sm-12 btn btn-primary" type="button" id="m_add_btn" value="+">
    <div class="form-group col-sm-12"> <?= $form->field($model, 'remark')->label("備註")->textarea(['rows' => '3']) ?></div>
    <div class="form-group col-sm-12"> <?= $form->field($model, 'price')->label("")->hiddenInput(['value' => -1]) ?></div>
        

    <div class="form-group col-sm-4"><?= Html::submitButton('提交', ['class' => 'btn btn-success']) ?></div>
    
    <?php ActiveForm::end(); ?>

</div>

<?php
$js =<<< JS
    var v = 1;
    $('#m_add_btn').click(function(){
        $('.material_id_'+v).show();
        if(v == 2){
            $('#m_del_btn_1').hide();
            $('#m_add_btn').hide();
        }
        console.log(v);    
        v++;
    });
    $('#m_del_btn_1').click(function(){
        $('.material_id_1').hide();
        $('#toothcase-material_id_1').val(0);
        $('#toothcase-tooth_1').val('');
        $('#toothcase-tooth_color_1').val('');
        $('#toothcase-tooth_color_1').val('');
        v = 0;
        console.log(v);    
    });
    $('#m_del_btn_2').click(function(){
        $('.material_id_2').hide();
        $('#m_del_btn_1').show();
        $('#m_add_btn').show();
        $('#toothcase-material_id_2').val(0);
        $('#toothcase-tooth_2').val('');
        $('#toothcase-tooth_color_2').val('');
        $('#toothcase-tooth_color_2').val('');
        v = 1;
        console.log(v);
    });
JS;
$this->registerJs($js);
