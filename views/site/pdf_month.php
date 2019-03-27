<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\toothcaseSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="toothcase-search">

    <?php $form = ActiveForm::begin([
        'action' => ['site/pdf'],
        'method' => 'post',
    ]); ?>
    <div class="container" style="padding: 0px;">
            <input type = "date" name = "date" value = <?= date('Y-m-d') ?>>
            <?= Html::submitButton('輸出PDF帳單', ['class' => 'btn btn-success']) ?>
        <div  style="margin-left: -15px;display:none" >
            <?= $form->field($model,'clinic_id')->label("診所")->dropDownList(ArrayHelper::map($clinic_info,'id','clinic'),['value' => !empty($clinic) ? $clinic : 1],['style'=>'border:1px solid ;'])?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
