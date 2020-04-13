<?php

namespace app\controllers;

use app\models\UploadForm;
use app\models\UserList;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\AdminSheet;

class SiteController extends Controller
{   /**
     * {@inheritdoc}
     */

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function actions(){
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex(){
     	$this->layout = 'frontend';
     	$model = new UploadForm();
        return $this->render('index',[
        	'model' =>$model,
		]);
    }

	public function actionPages()
	{
		$this->layout = 'frontend';

		return $this->render('pages', [
			'op' => $_GET['op'],
		]);
	}

	public function actionRegistered()
	{
		$this->layout = 'frontend';

		return $this->render('registered');
	}
	public function actionRegister()
	{
		$data = UserList::find()->where(['user_admin'=>$_POST['admin']])->asArray()->one();
		if(!empty($data)){
			echo "<script>alert('帳號已有人使用');history.go(-1);</script>";
		}else{
			UserList::NewData($_POST);
			echo "<script>location.href='http://".$_POST['admin'].".cowbtest.com/backend/index'</script>";
		}
	}
}
