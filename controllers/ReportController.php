<?php

namespace app\controllers;

use app\models\Report;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;

class ReportController extends Controller
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

	public function beforeAction($action){
		if(Yii::$app->session['login'] == 0){
			echo "<script>alert('請先登入');location.href='/backend/index'</script>";
			return  false;

		}
		if(empty(Yii::$app->session['right']['report']) && empty(Yii::$app->request->get("id"))){
			echo "<script>alert('沒有員工管理權限');history.go(-1);</script>";

			return  false;
		}
		return parent::beforeAction($action);
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
	public function actionWeekReport(){
		$this->layout =false;
		$day = empty($_POST['day'])?date('Y-m-d'):$_POST['day'];
		$start_time = date('Y-m-d', (strtotime($day) - ((date('w') == 0 ? 7 : date('w')) - 1) * 24 * 3600));
		$end_time = date('Y-m-d', (strtotime($day) + (7 - (date('w') == 0 ? 7 : date('w'))) * 24 * 3600));
		$data = Report::WeekReport($start_time,$end_time);
		return $this->render('week-report', [
			'day'=>$day,
			'data'=>$data
		]);
	}
	public function actionMonthReport(){
		$this->layout =false;
		$year = empty($_POST['year'])?date('Y'):$_POST['year'];
		$data = Report::MonthReport($year);
		return $this->render('month-report', [
			'data' =>$data,
			'year'=>$year
		]);
	}
	public function actionYearReport(){
		$this->layout =false;
		$year = empty($_POST['year'])?date('Y'):$_POST['year'];
		$data = Report::YearReport($year);
		return $this->render('Year-report', [
			'data' =>$data,
			'year'=>$year
		]);
	}

}
