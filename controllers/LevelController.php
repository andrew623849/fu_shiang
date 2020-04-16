<?php

namespace app\controllers;

use app\models\AdminSheet;
use Yii;
use app\models\Level;
use app\models\LevelSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LevelController implements the CRUD actions for Level model.
 */
class LevelController extends Controller
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
			$this->layout = '';
			echo "<script>alert('請先登入');location.href=''";
		}
		if(Level::RightCheck('level',0)){
			return parent::beforeAction($action);
		}else{
			echo "<script>alert('沒有職權管理權限');history.go(-1);</script>";
			return  false;
		}
	}

    /**
     * Lists all Level models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LevelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Level model.
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
     * Creates a new Level model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		if(Level::RightCheck('level',1)){
			$model = new Level();
			if ($model->load(Yii::$app->request->post())) {
				$model->build_time = date('Y-m-d H:i:s');
				$model->build_id = Yii::$app->session['user']['id'];
				$model->useable = 1;
				$model->save();
				return $this->redirect(['view', 'id' => $model->id]);
			}
			return $this->render('create', [
				'model' => $model,
			]);
		}else{
			echo "<script>alert('沒有新增職權的權限');history.go(-1);</script>";
			return  false;
		}


    }

    /**
     * Updates an existing Level model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
		if(Level::RightCheck('level',2)){
			$model = $this->findModel($id);
			if ($model->load(Yii::$app->request->post()) && $model->save()) {
				return $this->redirect(['view', 'id' => $model->id]);
			}
			return $this->render('update', [
				'model' => $model,
			]);
		}else{
			echo "<script>alert('沒有編輯職權的權限');history.go(-1);</script>";
			return  false;
		}

    }

    /**
     * Deletes an existing Level model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
		if(Level::RightCheck('level',3)){
			$data = adminsheet::find()->where(['job'=>$id,'deleted'=>0])->asArray()->one();
			if(empty($data)){
				$this->findModel($id)->delete();
				return $this->redirect(['index']);
			}else{
				echo "<script>alert('此職稱尚有人員使用，無法刪除');history.go(-1);</script>";
			}
		}else{
			echo "<script>alert('沒有刪除職權的權限');history.go(-1);</script>";
			return  false;
		}


    }

    /**
     * Finds the Level model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Level the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Level::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
