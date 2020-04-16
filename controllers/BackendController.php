<?php

namespace app\controllers;

use app\models\Level;
use app\models\LineNotify;
use app\models\Toothcase;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\AdminSheet;

class BackendController extends Controller
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
	public function beforeAction($action) {
		$currentaction = $action->id;
		$novalidactions = ['Person'];
		if(in_array($currentaction,$novalidactions)) {
			$action->controller->enableCsrfValidation = false;
		}
		return true;
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
     	$this->layout = 'logout';
        Yii::$app->session['login'] = 0;
        Yii::$app->session['user'] = "";

        return $this->render('index');
    }

	public function actionLinesend(){
		return $this->render('linesend');
	}

	public function actionWeekinfo(){
    	$this->layout = false;
		return $this->render('weekinfo');
	}

	public function actionFinishcase(){
		$this->layout = false;
		return $this->render('finishcase');
	}

	public function actionJoinLine(){
		$url = LineNotify::authorization();
		return $this->redirect($url);
	}

	public function actionPerson(){
		if(Yii::$app->session['login']){
			if(!empty($_POST['code']) && $_POST['state'] == 'csrf_token'){
				$response = LineNotify::getToken($_POST['code']);
				if(!empty($response)){
					LineNotify::snedNotify($response, ['message'=>'歡迎加入']);
					$_SESSION['user']['line_token'] = $response;
					AdminSheet::updateAll(['line_token' => $response], ['id' => $_SESSION['user']['id']]);
				}
			}
			return $this->render('person');
		}
		$message =  "";
		if(isset($_POST["admin"]) && isset($_POST["password"])){
			$model = new AdminSheet();
			$model = $model->find()->where(['and',["admin"=>$_POST["admin"]],["password"=>$_POST["password"]],["password"=>$_POST["password"]]])->asArray()->one();
			if($model != null){
				if($model['deleted'] == 1){
					$message =  '登入失敗!!<br>您已於'.$model['deleted_time'].'離職';
				}else{
					Yii::$app->session['login'] = 1;
					if(Yii::$app->session['login']){
						Yii::$app->session['user'] = $model;
						$this->layout = 'main';
						return $this->render('person');
					}
				}
			}elseif($_POST["admin"] == ""){
				$message =  '登入失敗!!<br>請輸入帳號';
			}elseif($_POST["password"] == ""){
				$message =  '登入失敗!!<br>請輸入密碼';
			}else{
				$message =  '登入失敗!!<br>請輸入正確帳號與密碼';
			}
		}
		$this->layout = 'logout';
		return $this->render('index',['message'=>$message]);
	}

	public function actionTodaycase(){
		if(Level::RightCheck('today_case',0)){
			$model = new Toothcase;
			if(empty($_POST['time'])){
				$start_time = date('Y-m-d');
				$end_time = date('Y-m-d');
				$time = $start_time.'~'.$end_time;
			}else{
				$start_time = explode('~',$_POST['time'])[0];
				$end_time = explode('~',$_POST['time'])[1];
				$time = $_POST['time'];
			}
			$model = $model->find()->where(["or",["and",[">=","end_time",$start_time],["<=","end_time",$end_time]],["and",[">=","try_time",$start_time],["<=","try_time",$end_time]]])->orderBy(['clinic_id'=>SORT_ASC,'end_time'=>SORT_ASC])->all();
			$clinic = show_clinic('all');
			return $this->render('todaycase', [
				'model' => $model,
				'clinic_info'=>$clinic['1'],
				'time'=>$time,
			]);
		}else{
			echo "<script>alert('沒有交件權限');history.go(-1);</script>";
			return  false;
		}

	}
}
