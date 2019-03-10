<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\toothcaseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '病例';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="toothcase-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('新增病例', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'end_time',
            'name',
            'material_id',
            'tooth',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <p>
        <?= Html::a('新增病例', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
</div>
