<?php

namespace app\controllers;

use app\models\Level;
use app\models\LineMsg;
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
		if(Level::RightCheck('toothcase',0)){
			return parent::beforeAction($action);
		}else{
			echo "<script>alert('沒有病例管理權限');history.go(-1);</script>";
			return  false;
		}
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

	public function actionViewM($id,$tooth,$color,$set,$make_p,$make_p_f)
	{
		$this->layout = false;
		return $this->render('view-m',[
			'id'=>$id,
			'tooth'=>$tooth,
			'color'=>$color,
			'set'=>$set,
			'make_p'=>$make_p,
			'make_p_f'=>$make_p_f,
		]);
	}
    /**
     * Creates a new toothcase model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($clinic_this = 1){
		if(Level::RightCheck('toothcase',1)){
			$model = new Toothcase();
			$clinic = show_clinic('all');
			if ($model->load(Yii::$app->request->post()) && $model->save()) {
				LineMsg::AddCase($model);
				toothcase::updateAll(['price'=>price_case($_POST['Toothcase'])],['id' => $model->id]);
				return $this->redirect(['view', 'id' => $model->id]);
			}
			return $this->render('create', [
				'model' => $model,
				'clinic_model' => $clinic['0'],
				'clinic_info'=>$clinic['1'],
				'clinic_this' =>$clinic_this,
			]);
		}else{
			echo "<script>alert('沒有新增病例權限');history.go(-1);</script>";
			return  false;
		}

    }

    /**
     * Updates an existing toothcase model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id){
		if(Level::RightCheck('toothcase',2)){
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
		}else{
			echo "<script>alert('沒有編輯病例權限');history.go(-1);</script>";
			return  false;
		}
    }

    /**
     * Deletes an existing toothcase model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id){
		if(Level::RightCheck('toothcase',3)){
			$this->findModel($id)->delete();
			Yii::$app->db->createCommand('ALTER TABLE toothcase DROP id')->query();
			Yii::$app->db->createCommand('ALTER TABLE toothcase ADD id INT( 11 ) NOT NULL AUTO_INCREMENT FIRST,ADD PRIMARY KEY(id)')->query();
			return $this->redirect(['toothcase']);
		}else{
			echo "<script>alert('沒有刪除病例權限');history.go(-1);</script>";
			return  false;
		}
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
