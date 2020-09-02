
<?php

use dosamigos\multiselect\MultiSelect;
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
$select_data = ArrayHelper::map(Material::find()->Asarray()->all(),'id','material');
$select_data[0] = '清空';
ksort($select_data);

?>
<div class="toothcase-index  col-md-12">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= Html::a('新增病例',['create','clinic_this' => $clinic_id], ['class' => 'btn btn-success']) ?>

    <?php $form = ActiveForm::begin([
            'action' => ['/toothcase/pdf'],
            'method' => 'post',
			'options'=>['target'=>'_blank']
        ]); ?>
            <div  style="margin-left: -15px;display:none" >
                <input id='pdf_case' name='keys'>
               <input name='clinic_id' value="<?= $clinic_id?>">
               <input type = "date" name = "end_date" value = <?= date('Y-m-d',strtotime('-15 days')) ?>>
            </div>
            <?= Html::submitButton('輸出PDF帳單', ['class' => 'btn btn-warning pdf_case']) ?>
        <?php ActiveForm::end(); ?>
	<div class="table-responsive" style="min-height: 500px;">
	<?php Pjax::begin(); ?>
    <?= GridView::widget([
        'options'=>['id'=>'toothcase_grid'],
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
			 'filter' => DateRangePicker::widget([ 'name' => 'start_time',
												   'value' => Yii::$app->request->get('start_time'),
												   'convertFormat' => true,
												   'pluginOptions' => [ 'locale' => [ 'format' => 'Y-m-d', 'separator' => '~', ] ] ])
			],
            ['attribute' => 'end_time',
            'format' => ['date', "php:Y-m-d"],
		 	'contentOptions' => ['style' => 'min-width:200px;'],
            'filter' => DateRangePicker::widget([ 'name' => 'end_time',
                                                  'value' => Yii::$app->request->get('end_time'),
                                                  'convertFormat' => true,
                                                  'pluginOptions' => [ 'locale' => [ 'format' => 'Y-m-d', 'separator' => '~', ] ] ])
            ],
             [
                'attribute'=>'name',
				'contentOptions' => ['style' => 'min-width:100px;'],
				'filter' => '<input name="name" class="form-control" value="'.Yii::$app->request->get('name').'">',
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
			'filter' =>MultiSelect::widget([
				"options" => ['multiple'=>"multiple",'title'=>'請選擇'], // for the actual multiselect
				'data' => $select_data, // data as array
				'value' => Yii::$app->request->get('material')?Yii::$app->request->get('material'):[],
				'name' => 'material', // name for the form
				'clientOptions' => [
					'nSelectedText'=> '個項目',
    				'nonSelectedText'=> '請選擇',
					'maxHeight' => 180,
					'buttonWidth'=> '180',

				]
			]),
            'label'=>'材料',
             ],
			[
				'attribute'=>'remark',
				'contentOptions' => ['style' => 'min-width:200px;'],
				'filter' => '',
			],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
	</div>
</div>
<?php Pjax::end(); ?>

<?php
$js =<<< JS
var keys = [];
$(document).on('pjax:start', function(data){
	keys = $.merge(keys, $('#toothcase_grid').yiiGridView('getSelectedRows')).filter(function(value, index, self) {
		return self.indexOf(value) === index;
	});
});
$(document).on('pjax:end', function(data){
	var all_key = 1;
    $('input:checkbox[name="id[]"]').each(function(){
    	if($.inArray(parseFloat(this.value), keys) != '-1'){
			$(this).prop("checked", true);
		}else{
			all_key = 0;
		}
	});
	if(all_key){
		$('.select-on-check-all').prop("checked", true);
	}
});

$('.pdf_case').click(function() {
    $("#pdf_case").val(keys.join(","));
});

JS;
$this->registerJs($js);?>


