<?php

namespace app\controllers;

use app\models\Level;
use Yii;
use app\models\AdminSheet;
use app\models\AdminSheetSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AdminsheetController implements the CRUD actions for AdminSheet model.
 */
class AdminsheetController extends Controller
{
    /**
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
		if(Level::RightCheck('admin_sheet',0)){
			return parent::beforeAction($action);
		}else{
			echo "<script>alert('沒有員工管理權限');history.go(-1);</script>";
			return  false;
		}
	}

    /**
     * Lists all AdminSheet models.
     * @return mixed
     */

    public function actionIndex()
    {
		return $this->render('index');
    }

	public function actionWork()
	{
		$this->layout = false;
		$searchModel = new AdminSheetSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams,['and',['=','deleted','0'],['>','job','0']]);
		return $this->render('work', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	public function actionWorkLeave()
	{
		$this->layout = false;
		$searchModel = new AdminSheetSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams,['and',['=','deleted','1'],['>','job','0']]);
		return $this->render('work-leave', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

    /**
     * Displays a single AdminSheet model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
		return $this->render('view', [
			'model' => $this->findModel($id),
		]);
    }

    /**
     * Creates a new AdminSheet model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		if(Level::RightCheck('admin_sheet',1)){
			$model = new AdminSheet();
			$job_info = show_level('all');
			if ($model->load(Yii::$app->request->post()) && $model->save()) {
				return $this->redirect(['view', 'id' => $model->id]);
			}
			return $this->render('create', [
				'model' => $model,
				'job_info' =>$job_info[1]
			]);
		}else{
			echo "<script>alert('沒有新增員工的權限');history.go(-1);</script>";
			return  false;
		}

    }

    /**
     * Updates an existing AdminSheet model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
		if(Level::RightCheck('admin_sheet',2)){
			$model = $this->findModel($id);
			$job_info = show_level('all');
			if($model->load(Yii::$app->request->post()) && $model->save()){
				return $this->redirect(['view', 'id' => $model->id]);
			}
			return $this->render('update', [
				'model' => $model,
				'job_info' => $job_info[1]
			]);
		}else{
			echo "<script>alert('沒有編輯員工的權限');history.go(-1);</script>";
			return  false;
		}
    }

    /**
     * Deletes an existing AdminSheet model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionLeave($id)
    {
		if(Level::RightCheck('admin_sheet',3)){
			$model = $this->findModel($id);
			AdminSheet::updateAll(['deleted'=>1,'deleted_time'=>date('Y-m-d H:i:s'),'deleted_id'=>Yii::$app->session['user']['id']],['id'=>$model->id]);
			return $this->redirect(['index']);
		}else{
			echo "<script>alert('沒有刪除員工的權限');history.go(-1);</script>";
			return  false;
		}
	}

    public function actionReinstatement($id)
    {
		$model = $this->findModel($id);
		AdminSheet::updateAll(['deleted'=>0,'deleted_time'=>'','deleted_id'=>'']);
		return $this->redirect(['index']);
    }
    /**
     * Finds the AdminSheet model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AdminSheet the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
		if (($model = AdminSheet::findOne($id)) !== null) {
			return $model;
		}
		throw new NotFoundHttpException('The requested page does not exist.');
    }
}
