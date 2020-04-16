<?php

namespace app\controllers;

use app\models\Level;
use Yii;
use app\models\Outlay;
use app\models\OutlaySearch;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\AdminSheet;

/**
 * OutlayController implements the CRUD actions for Outlay model.
 */
class OutlayController extends Controller
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
		if(Level::RightCheck('outlay',0)){
			return parent::beforeAction($action);
		}else{
			echo "<script>alert('沒有支出管理權限');history.go(-1);</script>";
			return  false;
		}
	}

    /**
     * Lists all Outlay models.
     * @return mixed
     */
    public function actionIndex()
    {
		$searchModel = new OutlaySearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
    }

    /**
     * Displays a single Outlay model.
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
     * Creates a new Outlay model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		if(Level::RightCheck('outlay',1)){
			$model = new Outlay();
			if ($model->load(Yii::$app->request->post()) && $model->save()) {
				return $this->redirect(['view', 'id' => $model->id]);
			}
			return $this->render('create', [
				'model' => $model,
			]);
		}else{
			echo "<script>alert('沒有新增支出權限');history.go(-1);</script>";
			return  false;
		}
    }

    /**
     * Updates an existing Outlay model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
		if(Level::RightCheck('outlay',2)){
			$model = $this->findModel($id);
			if ($model->load(Yii::$app->request->post()) && $model->save()) {
				return $this->redirect(['view', 'id' => $model->id]);
			}
			return $this->render('update', [
				'model' => $model,
			]);
		}else{
			echo "<script>alert('沒有修改支出權限');history.go(-1);</script>";
			return  false;
		}

    }

    /**
     * Deletes an existing Outlay model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
		if(Level::RightCheck('outlay',3)){
			$this->findModel($id)->delete();
			Yii::$app->db->createCommand('ALTER TABLE outlay DROP id')->query();
			Yii::$app->db->createCommand('ALTER TABLE outlay ADD id INT( 11 ) NOT NULL AUTO_INCREMENT FIRST,ADD PRIMARY KEY(id)')->query();
			return $this->redirect(['index']);
		}else{
			echo "<script>alert('沒有刪除支出權限');history.go(-1);</script>";
			return  false;
		}

    }

    /**
     * Finds the Outlay model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Outlay the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Outlay::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
