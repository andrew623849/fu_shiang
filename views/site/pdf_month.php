<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\dialog\Dialog;
use yii\web\JsExpression;
/* @var $this yii\web\View */
/* @var $model app\models\toothcaseSearch */
/* @var $form yii\widgets\ActiveForm */
echo Dialog::widget([
    'libName' => 'dialogpdf',
    'options'=>[
        'draggable'=>true,
        'closable'=>true,
        'size'=>Dialog::SIZE_LARGE,
        'title'=>'是否結帳',
        'buttons' => [  
            [
                'id' => 'cust-btn-1',  
                'label' => '不結帳',
                'action'=>new JsExpression("function(dialog){
                     $('.checkout').val('0');
                     $('.checkout_date').val('');
                     $('.pdfOK').click();
                    }")   
            ],
            [
                'id' => 'cust-btn-2',  
                'label' => '結帳',
                'action'=>new JsExpression("function(dialog){
                     $('.checkout').val('1');
                     $('.pdfOK').click();
                    }") 
            ]

       ] 
    ]
]);
?>

<div class="toothcase-search">

    <?php $form = ActiveForm::begin([
        'action' => ['site/pdf'],
        'method' => 'post',
    ]); ?>
    <div class="container" style="padding: 0px;">
            <input type = "date" name = "start_date" value = <?= date('Y-m') ?>-01>
            <input type = "date" name = "end_date" value = <?= date('Y-m-d') ?>>
            <input class = "hidden checkout_date" type = "date" name = "checkout_date" value = <?= date('Y-m-d') ?>>
            <input class = "hidden checkout" type = "text" name = "checkout" >
            <button type="button" id="btn-pdf" class="btn btn-warning">結帳</button>
                        <?= Html::submitButton('輸出PDF帳單', ['class' => 'btn btn-success hidden pdfOK']) ?>
        <div  style="margin-left: -15px;display:none" >
            <?= $form->field($model,'clinic_id')->label("診所")->dropDownList(ArrayHelper::map($clinic_info,'id','clinic'),['value' => !empty($clinic) ? $clinic : 1],['style'=>'border:1px solid ;'])?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$js =<<< JS
    $("#btn-pdf").on("click", function() {
       dialogpdf.dialog("只要結帳之後就無法再產生pdf，若只是查看帳單請選不結帳，最後要結帳請務必結帳", function (result) {
        if(result){

        }

        });
    });
JS;
$this->registerJs($js);
?>