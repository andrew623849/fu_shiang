<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AdminsheetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Admin Sheets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-sheet-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Admin Sheet', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'em_num',
            'admin',
            'password',
            'build_time',
            //'job',
            //'user_name',
            //'user_phone',
            //'user_email:email',
            //'user_pay',
            //'user_f_na',
            //'user_f_ph',
            //'user_exp',
            //'user_grade',
            //'remark',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
