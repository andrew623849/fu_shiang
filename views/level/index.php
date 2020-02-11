<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Adminsheet;


/* @var $this yii\web\View */
/* @var $searchModel app\models\LevelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '職權';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="level-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新增職權', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'job_name',
			[
				'attribute'=>'build_id',
				'value'=>'adminSheets.0.user_name'
			],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
