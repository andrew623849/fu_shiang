<?php

namespace app\controllers;

use Yii;
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
     	$this->layout = 'logout';
        Yii::$app->session['login'] = 0;
        Yii::$app->session['user'] = "";
        $model = new AdminSheet();
        $message =  "";
        if(isset($_POST["admin"]) && isset($_POST["password"])){
            $model = $model->find()->where(['and',["admin"=>$_POST["admin"]],["password"=>$_POST["password"]],["password"=>$_POST["password"]]])->one();
            if($model != null){
                if($model['deleted'] == 1){
                    $message =  '登入失敗!!<br>您已於'.$model['deleted_time'].'離職';
                }else{
					Yii::$app->session['login'] = 1;
					if(Yii::$app->session['login']){
						Yii::$app->session['user'] = [$model['id'],$model['build_time'],$model['job'],$model['user_name'],$model['user_phone'],$model['user_email'],$model['user_pay'],$model['user_f_na'],$model['user_f_ph'],$model['user_f_rel'],$model['user_exp'],$model['user_grade'],$model['remark']];
						$this->layout = 'main';
						return $this->render('//toothcase/person');
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
        return $this->render('index',['message'=>$message]);
    }

}
