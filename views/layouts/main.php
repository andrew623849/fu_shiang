<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
 $clinic = show_clinic('all');
$clinic_items = "";
$todaycase ="";
$job = [0,1,2,3,4,5,6,7,8,9];
foreach($clinic[1] as $val){
    $clinic_items .= "<li><a href='?r=site/toothcase&toothcaseSearch[clinic_id]=".$val['id']."'>".$val['clinic']."</a></li>";
	$todaycase .= "<li><a href='?r=site/todaycase&clinic_id=".$val['id']."'>".$val['clinic']."</a></li>";
}
$internal = [
             '0' => ['label'=>'員工','url'=> ['/adminsheet/index']],
             '1' => ['label'=>'材料','url'=> ['/material/index']],
             '2' => ['label'=>'診所','url'=> ['/clinic/index']],
             '9' => ['label'=>'職權','url'=> ['/level/index']]
            ];
$internal_need = [];
$nav_need = [];
foreach($internal as $key => $val){
    if(in_array($key,$job)){
        $internal_need[] = $val;
    }
}
$nav_arr = [
            '3' => ['label' => '交件', 'url' => ['/site/todaycase']],
            '4' => ['label' => '病例', 'url' => ['#'],'items'=> [$clinic_items]],
            '5' => ['label' => '支出', 'url' => ['/outlay/index']],
            '6' => ['label' => '報表', 'url' => ['/site/report']],
            '7' => ['label' => '公司內部管理','url' => ['#'],
                'items'=> $internal_need,
            ],
            '8' => ['label' => '登出', 'url' => ['/site/index']]
            ];
foreach($nav_arr as $key => $val){
    if(in_array($key,$job)){
        $nav_need[] = $val;
    }
}
// v_d($nav_need);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title>富翔牙體技術所</title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    if(Yii::$app->session['login']){
        NavBar::begin([
            'brandLabel' => '富翔牙體技術所',
            'brandUrl' => ['/site/person'],
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $nav_need
            ]);
    }else{
        NavBar::begin([
            'brandLabel' => '牙技所管理系統登入',
            'brandUrl' => ['/site/index'],
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                ['label' => '介紹', 'url' => ['#']],
                ['label' => '登入', 'url' => ['/site/index']]
            ],
        ]);
    }

    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'homeLink' => [
            'label' => '首頁',
            'url' => ['site/person'],
            'class' => 'myhome'
        ],
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left"></p>

        <p class="pull-right"> 登入者: <?=!empty(Yii::$app->session['user'])?Yii::$app->session['user']['3'].'&nbsp'.level_name(Yii::$app->session['user']['2']):'' ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
