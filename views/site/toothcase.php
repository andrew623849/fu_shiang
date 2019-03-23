<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel app\models\toothcaseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$clinic = $clinic_info[$clinic_id-1]['clinic'];
$this->title = $clinic.'病例';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php  echo $this->render('_search', ['clinic_info' => $clinic_info,'model' => $searchModel,'clinic'=>$clinic_id]); ?>
<div style="margin-left:1px"  > 
<?php  echo $this->render('pdf_month', ['clinic_info' => $clinic_info,'model' => $searchModel,'clinic'=>$clinic_id]); ?>
</div>
<div class="toothcase-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= Html::a('新增病例',['create','clinic_this' => $clinic_id], ['class' => 'btn btn-success']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'end_time',
            'name',
            'tooth',
            [
            'attribute'=>'Material',
            'value'=>'material.material',
            'label'=>'材料',
             ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <p>
        <?= Html::a('新增病例', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
</div>

