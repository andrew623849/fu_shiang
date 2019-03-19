<?php
date_default_timezone_set("Asia/Taipei");
// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

// require_once('../tools/tcpdf/examples/lang/chi.php');
require_once('../tools/tcpdf/tcpdf.php');
require __DIR__ . '/../tools/model.php';
require __DIR__ . '/../tools/function_show.php';
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();
