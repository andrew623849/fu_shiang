<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\models\Systemsetup;
use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\Level;
$sys_name = Systemsetup::SysName();

AppAsset::register($this);
$clinic = show_clinic('all');
$clinic_items = "";
foreach($clinic[1] as $val){
	$clinic_items .= "<li><a href='/toothcase/toothcase/".$val['id']."'>".$val['clinic']."</a></li>";
}

$job = ['nav'=>['today_case','toothcase','outlay','report','公司內部管理'],'公司內部管理' =>['admin_sheet','material','clinic','level']];
$nav_arr = [
	'today_case' => ['label' => '交件', 'url' => ['/toothcase/todaycase']],
	'toothcase' => ['label' => '病例', 'url' => ['#'],'items'=> [$clinic_items]],
	'outlay' => ['label' => '支出', 'url' => ['/outlay/index']],
	'report' => ['label' => '報表', 'url' => ['/toothcase/report']],
	'公司內部管理' =>[
		'admin_sheet' => ['label'=>'員工','url'=> ['/adminsheet/index']],
		'material' => ['label'=>'材料','url'=> ['/material/index']],
		'clinic' => ['label'=>'診所','url'=> ['/clinic/index']],
		'level' => ['label'=>'職權','url'=> ['/level/index']],
	]
];
$user_job = Yii::$app->session['user'][2];
$user_level = Level::find()->where(['=','id',$user_job])->asArray()->one();

$nav_need = [];
$right = [];
foreach($job['nav'] as $key => $val){
	if(!empty($job[$val])){
		$nav2_need = [];
		foreach($job[$val] as $vval){
			$decbin = preg_split('//', decbin($user_level[$vval]), -1, PREG_SPLIT_NO_EMPTY);
			if($decbin[0] == 1 || $user_job == 0){
				$nav2_need[] = $nav_arr[$val][$vval];
				$right[$vval] = 1;
			}
		}
		if(!empty($nav2_need)){
			$nav_need[] = ['label' => $val,'url' => ['#'], 'items'=> $nav2_need];
		}
	}else{
		$decbin = preg_split('//', decbin($user_level[$val]), -1, PREG_SPLIT_NO_EMPTY);
		if($decbin[0] == 1 || $user_job == 0){
			$nav_need[] = $nav_arr[$val];
			$right[$val] = 1;
		}
	}
}
Yii::$app->session['right'] = $right;
$nav_need[] =  ['label' => '登出', 'url' => ['/backend/index']];

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= $sys_name?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
	NavBar::begin([
		'brandLabel' => $sys_name,
		'brandUrl' => ['/backend/person'],
		'options' => [
			'class' => 'navbar-inverse navbar-fixed-top',
		],
	]);
		echo Nav::widget([
			'options' => ['class' => 'navbar-nav navbar-right'],
			'items' => $nav_need
		]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'homeLink' => [
            'label' => '首頁',
            'url' => ['backend/person'],
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

        <p class="pull-right"> 登入者: <?= Yii::$app->session['user']['3'].'&nbsp'.level_name(Yii::$app->session['user']['2']) ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
