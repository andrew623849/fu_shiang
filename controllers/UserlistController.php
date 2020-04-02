<?php

namespace app\controllers;

use app\models\UploadForm;
use app\models\UserListSearch;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\AdminSheet;

class UserlistController extends Controller
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
        return $this->render('index');
    }

    public function actionUserList(){
    	$this->layout = false;
		$searchModel = new UserListSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams,[]);
		return $this->render('user-list', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}
	public function actionSqlEdit(){
    	$this->layout = false;

		return $this->render('sql-edit', [

		]);
	}
}
