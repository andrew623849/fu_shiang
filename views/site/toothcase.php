<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\daterange\DateRangePicker;


/* @var $this yii\web\View */
/* @var $searchModel app\models\toothcaseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$request = Yii::$app->request;
$clinic_id=$request->get('toothcaseSearch');
$clinic=ArrayHelper::map($clinic_info,'id','clinic');
$clinic_id['clinic_id']=$clinic_id['clinic_id']==NULl?1:$clinic_id['clinic_id'];
$this->title = $clinic[$clinic_id['clinic_id']].'病例';
$this->params['breadcrumbs'][] = $this->title;
?>
<div style="margin-left:15px"  > 
<?php  echo $this->render('pdf_month', ['clinic_info' => $clinic_info,'model' => $searchModel,'clinic'=>$clinic_id]); ?>
</div>
<div class="toothcase-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= Html::a('新增病例',['create','clinic_this' => $clinic_id['clinic_id']], ['class' => 'btn btn-success']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],
            ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'start_time',
            'format' => ['date', "php:Y-m-d"],
            'headerOptions' => ['width' => '20%'],
            'filter' => DateRangePicker::widget([ 'name' => 'BorrowRepaymentSearch[start_time]',
            'value' => Yii::$app->request->get('BorrowRepaymentSearch')['start_time'], 'convertFormat' => true,
            'pluginOptions' => [ 'locale' => [ 'format' => 'Y-m-d', 'separator' => '~', ] ] ])
            ],
            'name',
            'tooth',
            [
            'attribute'=>'Material',
            'value'=>'material.material',
            'label'=>'材料',
             ],
             'tooth_1',
            [
            'attribute'=>'Material',
            'value'=>'material_1.material',
            'label'=>'材料2',
             ],
             'tooth_2',
            [
            'attribute'=>'Material',
            'value'=>'material_2.material',
            'label'=>'材料3',
             ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <p>
        <?= Html::a('新增病例', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
</div>

