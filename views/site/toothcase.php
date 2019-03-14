<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
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
<?php  echo $this->render('_search', ['clinic_info' => $clinic_info,'model' => $searchModel,'clinic'=>$clinic_id['clinic_id']]); ?>
<div class="toothcase-index">
    <p>
        <?= Html::a('新增病例', ['create','clinic_this' => $clinic_id['clinic_id']], ['class' => 'btn btn-success']) ?>
    </p>
    <h1><?= Html::encode($this->title) ?></h1>


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
