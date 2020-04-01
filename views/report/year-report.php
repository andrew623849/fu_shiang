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
	'action' => ['report'],
	'method' => 'post',
	'options' =>['id'=>'YearReport']

]); ?>
<div class="form-group" style="width: 100px;"><label>年份</label><?= DatePicker::widget([
		'type' => DatePicker::TYPE_INPUT,
		'name' =>'year',
		'value' =>$year,
		'options'=>['id'=>'YearReportInput'],
		'pluginOptions' => [
			'minViewMode' => 2,
			'autoclose'=>true,
			'format' => 'yyyy'
		]
	]); ?></div>
<?php ActiveForm::end(); ?>
<div class="toothcase-index">
    <h1>材料數量</h1>
<?php echo \yii2mod\c3\chart\Chart::widget([
    'options' => [
            'id' => 'year_report_material'
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
                'max' => 100,
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
            'id' => 'year_report_mny'
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
                'max' => 300000,
                'padding' => ['top' => 10, 'bottom' => 0]
            ]
        ]
    ]
]); ?>
</div>

<?php
	$js =<<< JS
	$("#YearReportInput").change(function(){
		$('#YearReport').submit();
	});
JS;
	$this->registerJs($js);
