<?php

namespace app\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Toothcase;
use yii\web\Controller;
use app\models\toothcaseSearch;
use kartik\mpdf\Pdf;
use Mpdf\Mpdf;
class ToothcaseController extends Controller
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
		if(empty(Yii::$app->session['right']['today_case']) && empty(Yii::$app->request->get("id"))){
			echo "<script>alert('沒有交件管理權限');history.go(-1);</script>";

			return  false;
		}
		if(empty(Yii::$app->session['right']['toothcase']) && !empty(Yii::$app->request->get("id"))){
			echo "<script>alert('沒有病例管理權限');history.go(-1);</script>";

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

    public function actionTodaycase(){
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
    }

    /**
     * Lists all toothcase models.
     * @return mixed
     */
    public function actionToothcase(){
		$clinic_id = Yii::$app->request->get("id") ?? "1";
		$searchModel = new toothcaseSearch();
		$dataProvider = $searchModel->search($clinic_id);
		$clinic = show_clinic('all');
		return $this->render('toothcase', [
			'dataProvider' => $dataProvider,
			'searchModel' => $searchModel,
			'clinic_info'=>$clinic['1'],
			'clinic_id'=>$clinic_id,
		]);
    }

    public function actionPdf(){
		$this->layout = false;
		$clinic = show_clinic($_POST['clinic_id']);
		$model = new Toothcase();
		$models = $model->find()->where(['in','id',explode(',',$_POST['keys'])])->orderBy(['start_time'=>SORT_ASC,'name'=>SORT_ASC])->asArray()->all();
		$content = $this->renderPartial('pdf',[
			'model'=>$models,
		]);
		//設置kartik \ mpdf \ Pdf組件
		$pdf = new Pdf([
			//設置為僅使用核心字體
			'mode' => Pdf::MODE_UTF8,
			// A4 paper format
			'format' => Pdf::FORMAT_A4,
			// 縱向
			'orientation' => Pdf :: ORIENT_PORTRAIT,
			//流式傳輸到內嵌瀏覽器
			'destination' => Pdf::DEST_BROWSER,
			'marginTop' =>20,
			// your html content input
			'content' => $content,
			'filename'=> $clinic['clinic'].'_'.date('Y.m',strtotime($_POST['end_date'])).'.pdf',
			// format content from your own css file if needed or use the
			// enhanced bootstrap css built by Krajee for mPDF formatting
			'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
			// any css to be embedded if required
			'cssInline' => '.kv-heading-1{font-size:24px}',
			// set mPDF properties on the fly
			'options' => [
				'title' => '中文',
				'autoLangToFont' => true,    //这几个配置加上可以显示中文
				'autoScriptToLang' => true,  //这几个配置加上可以显示中文
				'autoVietnamese' => true,    //这几个配置加上可以显示中文
				'autoArabic' => true,        //这几个配置加上可以显示中文
			],
			// call mPDF methods on the fly
			'methods' => [
				'SetHeader' => ['富翔牙體技術所||'.$clinic['clinic'].'診所<br>'.date('Y-m',strtotime($_POST['end_date'])),'O', false,15],
				'SetFooter' => ['{PAGENO}']]
		]);

		//根據目標設置返回pdf輸出
		return $pdf->render();
    }
    public function actionReport(){
		return $this->render('report', [
			'year'=>empty($_POST['year'])?date('Y'):$_POST['year']

		]);
    }

    /**
     * Displays a single toothcase model.s
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id){   
		return $this->render('view', [
			'model' => $this->findModel($id),
		]);
    }

    /**
     * Creates a new toothcase model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($clinic_this = 1){
		$model = new Toothcase();
		$clinic = show_clinic('all');
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			toothcase::updateAll(['price'=>price_case($_POST['Toothcase'])],['id' => $model->id]);
			return $this->redirect(['view', 'id' => $model->id]);
		}
		return $this->render('create', [
			'model' => $model,
			'clinic_model' => $clinic['0'],
			'clinic_info'=>$clinic['1'],
			'clinic_this' =>$clinic_this,
		]);
    }

    /**
     * Updates an existing toothcase model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id){
		$model = $this->findModel($id);
		$clinic = show_clinic($model['clinic_id']);
		$clinic_info = show_clinic('all');
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			toothcase::updateAll(['price'=>price_case($_POST['Toothcase'])],['name'=>$_POST['Toothcase']['name'],'tooth'=>$_POST['Toothcase']['tooth'],'id'=>$model->id]);
			return $this->redirect(['view', 'id' => $model->id]);
		}

		return $this->render('update', [
			'model' => $model,
			'clinic_model' => $clinic,
			'clinic_info'=>$clinic_info['1'],
		]);
    }

    /**
     * Deletes an existing toothcase model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id){
		$this->findModel($id)->delete();
		Yii::$app->db->createCommand('ALTER TABLE toothcase DROP id')->query();
		Yii::$app->db->createCommand('ALTER TABLE toothcase ADD id INT( 11 ) NOT NULL AUTO_INCREMENT FIRST,ADD PRIMARY KEY(id)')->query();
		return $this->redirect(['toothcase']);
    }
    /**
     * Finds the toothcase model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return toothcase the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id){
        if (($model = toothcase::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
