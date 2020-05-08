<?php

namespace app\controllers;

use app\models\FrontPage;
use app\models\frontpageSearch;
use app\models\UploadForm;
use Yii;
use yii\helpers\Json;
use yii\filters\VerbFilter;
use yii\web\Controller;
use Mpdf\Mpdf;
use yii\web\UploadedFile;

class FrontendController extends Controller
{   /**
     * {@inheritdoc}
     */
	private static $home_file;

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
		if (!empty($_POST)) {
			$model = new UploadForm();
			$model->imageFile = UploadedFile::getInstances($model, 'imageFile');
			$model->text = $_POST['UploadForm']['text'];
			if ($model->upload()) {
				return $this->render('edit');
			}else{
				return $this->render('edit');
			}
		}
		return $this->render('edit');
	}

	/**
	 * 前台編輯的介面
	 *
	 */
	public function actionHome()
	{
		$this->layout = false;
		$model = new UploadForm();
		return $this->render('home',[
			'model' => $model
		]);
	}
	public function actionDeleted()
	{
		if (Yii::$app->request->isPost){
			$model = new UploadForm();
			if($model->deleted()){
				return Json::htmlEncode('刪除成功');
			}
		}
	}
	public function actionUpdate($id)
	{
		$model = new FrontPage();
		$models = $model->findOne($id);
		$models->text = $model->showtext($models->file_name);
		if ($models->load(Yii::$app->request->post()) && $models->save()) {
			$model->updatetext($_POST['FrontPage']['text'],$models->file_name);
			return $this->redirect(['edit', 'op' => '1']);
		}
		return $this->render('update', [
			'model' => $models,
		]);
	}
	public function actionPagination()
	{
		$this->layout = false;
		$searchModel = new frontpageSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams,['deleted'=>'0']);
		return $this->render('pagination', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	public function actionDeletePage()
	{
		if (Yii::$app->request->isGet){
			$model = new FrontPage();
			$model->updateAll(['deleted'=>'1','deleted_time'=>date('Y-m-d H:i:s'),'deleted_id'=>Yii::$app->session['user']['id']],['id'=>$_GET['id']]);
			return $this->redirect(['edit','op'=>1]);
		}
	}
	public function actionCreate()
	{
		$model = new FrontPage();
		$model->file_name = strtotime(date('Y-m-d H:i:s')).'.html';
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$model->create();
			return $this->redirect(['edit', 'op' => '1']);
		}
		return $this->render('create', [
			'model' => $model,
		]);
	}
	public function actionFileUpload()
	{
		$model = new UploadForm();
		//先取得檔案要存放的路徑 , 等一下才能把暫存檔搬過去
		$uploadPath = $model->home_file.'/home_timg/';
		//確認檔案有上傳成功再處理
		if (isset($_FILES["upload"]["name"]) && $_FILES["upload"]["error"] == 0) {
			//檔案上傳，改檔名
			$org_name=explode(".",$_FILES["upload"]["name"]);
			//新檔名
			$upload_filename=time().".".$org_name[count($org_name)-1];
			//把暫存檔案搬到目錄中
			move_uploaded_file($_FILES["upload"]["tmp_name"], $uploadPath . $upload_filename);
			//要回傳給 CKeditor 的檔案 URL
			$url = Yii::$app->urlManager->createAbsoluteUrl($uploadPath.$upload_filename,'https');
			//如果有什麼額外的回饋訊息，要打在這裡
			$message="";
			$funcNum = $_GET['CKEditorFuncNum'] ;
			//利用 JavaScript 指令回傳
			echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";
		} // end if
	}

}
