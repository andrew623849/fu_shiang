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
        'action' => ['toothcase'],
        'method' => 'get',
    ]); ?>
    <div class="container" style="padding: 0px;">
        <div class="col-sm-4" ><?= $form->field($model,'clinic_id')->label("診所")->dropDownList(ArrayHelper::map($clinic_info,'id','clinic'),['value' => !empty($clinic) ? $clinic : 1],['style'=>'border:1px solid ;'])?></div>
        <div class="col-sm-4" style="margin-top: 25px; ">
            <?= Html::submitButton('搜尋', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
