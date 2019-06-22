<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\AdminSheet */
/* @var $form yii\widgets\ActiveForm */
$sale[0] = '男';
$sale[1] = '女';
?>

<div class="admin-sheet-form">
	<h3>基本資料</h3>
    <?php $form = ActiveForm::begin(); ?>
    <div class="form-group col-sm-4"  style="height:99px;"><?= $form->field($model, 'user_name')->label("*姓名")->textInput(['maxlength' => true]) ?></div>
    <div class="form-group col-sm-4" ><?= $form->field($model, 'user_sale')->label("*性別")->dropDownList($sale,['value' => date('Y-m-d')],['style'=>'border:1px solid ;'])?></div>
    <div class="form-group col-sm-4"  style="height:99px;"><?= $form->field($model, 'user_br')->label("*出生年/月/日")->widget(DatePicker::classname(), [
    		'inline'=>false,
    		'language' => 'us',
    		'clientOptions'=>[
    			'autoclose'=>true,
    			'format' => 'yyyy-mm-dd'
    		]
    ]); ?></div>
    <div class="form-group col-sm-4"  style="height:99px;"><?= $form->field($model, 'user_phone')->label("*手機")->textInput(['maxlength' => true]) ?></div>
    <div class="form-group col-sm-4"  style="height:99px;"><?= $form->field($model, 'user_email')->label("*信箱")->textInput(['maxlength' => true]) ?></div>
    <div class="form-group col-sm-4"  style="height:99px;"><?= $form->field($model, 'user_line')->textInput(['maxlength' => true]) ?></div>
    <div class="form-group col-sm-4"><?= $form->field($model, 'user_f_na')->textInput(['maxlength' => true]) ?></div>
    <div class="form-group col-sm-4"><?= $form->field($model, 'user_f_ph')->textInput(['maxlength' => true]) ?></div>
     <div class="form-group col-sm-4"><?= $form->field($model, 'user_f_rel')->textInput(['maxlength' => true]) ?></div>

    <div class="form-group col-sm-12"><?= $form->field($model, 'user_exp')->label("經歷")->textarea(['rows' => '3']) ?></div>
    <div class="form-group col-sm-12"><?= $form->field($model, 'user_grade')->label("學歷")->textarea(['rows' => '3']) ?></div>
    <div class="form-group col-sm-12"><?= $form->field($model, 'remark')->label("備註")->textarea(['rows' => '3']) ?></div>
    <?php if($url == 'create'){?>
	<div class="form-group col-sm-12"> <?= $form->field($model, 'build_time')->label("")->hiddenInput(['value' => date('Y-m-d')]) ?></div>
	<hr />
    <?php }?>
	<h3>員工資料</h3>
	<?php if($url == 'create' or $url == 'pupdate'){?>
    <div class="form-group col-sm-6"  style="height:99px;"><?= $form->field($model, 'admin')->label("*帳號")->textInput(['maxlength' => true]) ?></div>

    <div class="form-group col-sm-6"  style="height:99px;"><?= $form->field($model, 'password')->label("*密碼")->passwordInput(['maxlength' => true]) ?></div>
	<?php }?>
    <?php if($url != 'pupdate'){?>
    <div class="form-group col-sm-6"  style="height:99px;"><?= $form->field($model, 'user_pay')->label("*員工薪資")->textInput(['maxlength' => true]) ?></div>
    <div class="form-group col-sm-6"  style="height:99px;"><?= $form->field($model, 'job')->label("*職位")->textInput(['maxlength' => true]) ?></div>
    <?php }?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
