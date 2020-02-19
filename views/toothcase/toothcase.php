
<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\daterange\DateRangePicker;
use yii\widgets\Pjax;
use app\models\Material;

/* @var $this yii\web\View */
/* @var $searchModel app\models\toothcaseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$request = Yii::$app->request;
$clinic=ArrayHelper::map($clinic_info,'id','clinic');
$this->title = $clinic[$clinic_id].'病例';
$this->params['breadcrumbs'][] = $this->title;
global $material_name;
$material_name = Material::find('material')->indexBy('id')->asArray()->all();

?>
<div class="toothcase-index  col-md-12">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= Html::a('新增病例',['create','clinic_this' => $clinic_id], ['class' => 'btn btn-success']) ?>

    <?php Pjax::begin(); ?>
    <?php $form = ActiveForm::begin([
            'action' => ['/toothcase/pdf'],
            'method' => 'post',
			'options'=>['target'=>'_blank']
        ]); ?>
            <div  style="margin-left: -15px;display:none" >
                <input id='pdf_case' name='keys'>
               <input name='clinic_id' value="<?= $clinic_id?>">
               <input type = "date" name = "end_date" value = <?= date('Y-m-d') ?>>
            </div>
            <?= Html::submitButton('輸出PDF帳單', ['class' => 'btn btn-warning pdf_case']) ?>
        <?php ActiveForm::end(); ?>
	<div class="table-responsive">

    <?= GridView::widget([
        'options'=>['id'=>'toothcase_grid','width'=>'300px'],
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn',

            'name' => 'id',
            ],
            ['class' => 'yii\grid\SerialColumn',
			],
            ['attribute' => 'start_time',
            'format' => ['date', "php:Y-m-d"],
		 	'contentOptions' => ['style' => 'min-width:200px;'],
            'filter' => DateRangePicker::widget([ 'name' => 'BorrowRepaymentSearch[start_time]',
                                                  'value' => Yii::$app->request->get('BorrowRepaymentSearch')['start_time'],
                                                  'convertFormat' => true,
                                                  'pluginOptions' => [ 'locale' => [ 'format' => 'Y-m-d', 'separator' => '~', ] ] ])
            ],
             [
                'attribute'=>'name',
				'contentOptions' => ['style' => 'min-width:100px;'],

				'value'=>function($data){
                    return $data->checkout == 1 ? $data->name.'<span color="red">(已結款)</span>' : $data->name;
                }
            ],
            [
            'attribute'=>'Material',
            'format' => 'raw',
            'value'=>function($data){
    			global $material_name;
                return $material_name[$data->material_id]["material"].'('.$data->tooth.')<br>'.($data->material_id_1 == 0?'':$material_name[$data->material_id_1]["material"].'('.$data->tooth_1.')<br>').($data->material_id_2 == 0?'':$material_name[$data->material_id_2]["material"].'('.$data->tooth_2.')');
            },
			'filter' =>ArrayHelper::map(Material::find()->Asarray()->all(),'id','material'),
            'label'=>'材料',
             ],
             'remark',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php
$js =<<< JS
if(typeof(keys) == 'undefined'){
    var keys =[];
}else{
    var type = 1; 
    $('input:checkbox[name="id[]"]').each(function(i) {
        if($.inArray(this.value, keys) != '-1'){
            $(this).prop("checked", true);
        }else{
            type = 0;
        }
        if(type){
            $('.select-on-check-all').prop("checked", true);
        }
    }); 
}
$('.select-on-check-all').click(function(){
    if($('.select-on-check-all').prop("checked")){
        $('input:checkbox[name="id[]"]').each(function() { 
            if($.inArray(this.value, keys) == '-1'){
                $(this).prop("checked", true);
                keys.push($(this).val());
            }
        });
    }else{
        $('input:checkbox[name="id[]"]').each(function() { 
            if($.inArray(this.value, keys) != '-1'){
                removeByValue(keys, this.value);
            }
        });
    }
});

$('input:checkbox[name="id[]"]').click(function(){
    if($.inArray(this.value, keys) != '-1'){
        removeByValue(keys, this.value);
    }else{
        keys.push(this.value);
    }
});

$('.pdf_case').click(function() {
    keys.join(",");
    $("#pdf_case").val(keys);
});
function removeByValue(arr, val) {
  for(var i=0; i<arr.length; i++) {
    if(arr[i] == val) {
      arr.splice(i, 1);
      break;
    }
  }
}
JS;
$this->registerJs($js);?>
<?php Pjax::end(); ?>
    <p>
        <?= Html::a('新增病例', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
	</div>
</div>

