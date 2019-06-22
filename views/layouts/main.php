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
    $clinic = show_clinic('all');
    $clinic_items = "";
    foreach($clinic[1] as $val){
        $clinic_items .= "<li><a href='?r=site/toothcase&toothcaseSearch[clinic_id]=".$val['id']."'>".$val['clinic']."</a></li>";
    }
    if(Yii::$app->session['login']){
        NavBar::begin([
            'brandLabel' => '富翔牙體技術所',
            'brandUrl' => ['/site/person'],
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]);
        if(Yii::$app->session['user']['2'] == '0'){
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                    ['label' => '交件', 'url' => ['/site/todaycase']],
                    ['label' => '病例', 'url' => ['#'],
                        'items'=> [
                            $clinic_items
                        ],
                    ],
                    ['label' => '支出', 'url' => ['/outlay/index']],
                    ['label' => '報表', 'url' => ['/site/report']],
                    ['label' => '公司內部管理','url' => ['#'],
                        'items'=> [
                            ['label'=>'員工','url'=> ['/adminsheet/index']],
                            ['label'=>'材料','url'=> ['/site/company']],
                            ['label'=>'診所','url'=> ['/clinic/index']]
                        ],
                    ],
                    ['label' => '登出', 'url' => ['/site/index']]
                ],
            ]);
        }elseif(Yii::$app->session['user']['2'] == '1'){
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                    ['label' => '交件', 'url' => ['/site/todaycase']],
                    ['label' => '病例', 'url' => ['#'],
                        'items'=> [
                            $clinic_items
                        ],
                    ],
                    ['label' => '支出', 'url' => ['/outlay/index']],
                    ['label' => '公司內部管理','url' => ['#'],
                        'items'=> [
                            ['label'=>'員工','url'=> ['/adminsheet/index']],
                        ],
                    ],
                    ['label' => '登出', 'url' => ['/site/index']]
                ],
            ]);
        }else{
                        echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                    ['label' => '交件', 'url' => ['/site/todaycase']],
                    ['label' => '病例', 'url' => ['#'],
                        'items'=> [
                            $clinic_items
                        ],
                    ],
                    ['label' => '支出', 'url' => ['/outlay/index']],
                    ['label' => '登出', 'url' => ['/site/index']]
                ],
            ]);
        }
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
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right">admin:黃柏禎</p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
