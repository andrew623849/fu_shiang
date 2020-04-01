<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use app\models\Outlay;
use app\models\Toothcase;

/* @var $this yii\web\View */
/* @var $searchModel app\models\toothcaseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


?>
<?php $form = ActiveForm::begin([
	'action' => ['report/index'],
	'method' => 'post',
	'options' =>['id'=>'WeekReport']

]); ?>
<div class="form-group" style="width: 100px;"><label>日期</label><?= DatePicker::widget([
		'type' => DatePicker::TYPE_INPUT,
		'name' =>'day',
		'value' =>$day,
		'options'=>['id'=>'WeekReportInput'],
		'pluginOptions' => [
			'autoclose'=>true,
			'format' => 'yyyy-mm-dd'
		]
	]); ?></div>
	<input type="hidden" name="type" value="0">
<?php ActiveForm::end(); ?>
<div class="toothcase-index">
    <h1>材料數量</h1>
<?php echo \yii2mod\c3\chart\Chart::widget([
    'options' => [
            'id' => 'week_report_material'
    ],
    'clientOptions' => [
       'data' => [
            'x' => 'x',
            'columns' => 
            	$data['0'],
        ],
        'axis' => [
            'x' => [
                'label' => '月份',
                'type' => 'category',
            ],
            'y' => [
                'label' => [
                    'text' => '數量',
                    'position' => 'outer-top'
                ],
                'min' => 0,
                'max' => 20,
                'padding' => ['top' => 10, 'bottom' => 0]
            ]
        ]
    ]
]); ?>
</div>

<div class="toothcase-index">

    <h1><?= Html::encode($this->title) ?></h1>
<?php echo \yii2mod\c3\chart\Chart::widget([
    'options' => [
            'id' => 'week_report_mny'
    ],
    'clientOptions' => [
       'data' => [
            'x' => 'x',
            'columns' =>
				$data['1'],
        ],
        'axis' => [
            'x' => [
                'label' => '月份',
                'type' => 'category',
            ],
            'y' => [
                'label' => [
                    'text' => '金額',
                    'position' => 'outer-top'
                ],
                'min' => 0,
                'max' => 50000,
                'padding' => ['top' => 10, 'bottom' => 0]
            ]
        ]
    ]
]); ?>
</div>

<?php
	$js =<<< JS
	$("#WeekReportInput").change(function(){
		$('#WeekReport').submit();
	});
JS;
	$this->registerJs($js);
