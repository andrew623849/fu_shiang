<?php

namespace app\controllers;

use Yii;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Toothcase;
use yii\web\Controller;
use app\models\toothcaseSearch;
use kartik\mpdf\Pdf;
use Mpdf\Mpdf;
class FrontendController extends Controller
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
		if(empty(Yii::$app->session['right']['frontend'])){
			echo "<script>alert('沒有前台編輯權限');history.go(-1);</script>";

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


	/**
	 * 前台編輯的介面
	 *
	 */
	public function actionEdit()
	{
		return $this->render('edit');
	}


	public function actionPagination()
	{
		$html = $this->renderPartial('pagination');
		return Json::encode($html);
	}

}
