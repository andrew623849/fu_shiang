<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\assets\AppAsset;
use app\models\Systemsetup;


AppAsset::register($this);
$sys_name = Systemsetup::SysName();
$sys_logo = Systemsetup::SysLogo();
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
            'brandLabel' => !empty($sys_logo) ? Html::img($sys_logo, ['alt'=>$sys_name]):$sys_name,
            'brandUrl' => ['/site/index'],
            'options' => [
                'class' => 'navbar-default navbar-fixed-top',
            ],
        ]);
		NavBar::end();

	?>
	<div class="container">
		<div class="row"></div>
	<?php

        NavBar::begin([
            'brandLabel' => !empty($sys_logo) ? Html::img($sys_logo, ['alt'=>$sys_name]):$sys_name,
            'brandUrl' => ['/site/index'],
            'options' => [
                'class' => 'navbar-default navbar-fixed-top',
            ],
        ]);
        echo Nav::widget([
            'options' => [
				'class' => 'navbar-nav navbar-right',
			],
            'items' => [

            ],
        ]);

    NavBar::end();
    ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left"></p>

        <p class="pull-right"> 登入者: </p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
