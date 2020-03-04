<?php

namespace app\controllers;

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
		if(empty(Yii::$app->session['right']['admin_sheet']) && empty(Yii::$app->request->get("id"))){
			echo "<script>alert('沒有員工管理權限');history.go(-1);</script>";

			return  false;
		}
		return parent::beforeAction($action);
	}

    /**
     * Lists all AdminSheet models.
     * @return mixed
     */

    public function actionIndex()
    {
		$searchModel = new AdminSheetSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider_l = $searchModel->search2(Yii::$app->request->queryParams);
		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'dataProvider_l' => $dataProvider_l,
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
		$model = new AdminSheet();
		$job_info = show_level('all');
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->id]);
		}

		return $this->render('create', [
			'model' => $model,
			'job_info' =>$job_info[1]
		]);
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
		$model = $this->findModel($id);
		$job_info = show_level('all');
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->id]);
		}

		return $this->render('update', [
			'model' => $model,
			'job_info' => $job_info[1]
		]);
    }

	public function actionPupdate($id)
    {
		$model = $this->findModel($id);
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			Yii::$app->session['login'] = 0;
			$this->layout = 'logout';
			return $this->render('/backend/index', ['message'=>"修改個人資料成功，請重新登入"]);
		}
		return $this->render('pupdate', [
			'model' => $model,
		]);
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
		$model = $this->findModel($id);
		AdminSheet::updateAll(['deleted'=>1,'deleted_time'=>date('Y-m-d H:i:s'),'deleted_id'=>Yii::$app->session['user']['id']],['id'=>$model->id]);
		return $this->redirect(['index']);
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
