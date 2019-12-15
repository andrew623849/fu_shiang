<?php

use yii\helpers\Html;
use app\models\MaterialSearch;

/* @var $this yii\web\View */
/* @var $searchModel app\models\toothcaseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '報表';
$this->params['breadcrumbs'][] = $this->title;
$material = MaterialSearch::ShowData('all',[],'');
$report_models = report_num($models,$clinic,$material,$year);
$price_out = outlay($models_outlay);
$report_models['1'][] = $price_out;

?>
<div class="toothcase-index">
    <h1>材料數量</h1>
<?php echo \yii2mod\c3\chart\Chart::widget([
    'options' => [
            'id' => 'report_material'
    ],
    'clientOptions' => [
       'data' => [
            'x' => 'x',
            'columns' => 
            	$report_models['0'],
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
            'id' => 'report_mny'
    ],
    'clientOptions' => [
       'data' => [
            'x' => 'x',
            'columns' =>
                $report_models['1'],
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
                'max' => 200000,
                'padding' => ['top' => 10, 'bottom' => 0]
            ]
        ]
    ]
]); ?>
</div>


