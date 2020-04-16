<?php

namespace app\controllers;

use app\models\Level;
use Yii;
use app\models\Clinic;
use app\models\clinicSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ClinicController implements the CRUD actions for Clinic model.
 */
class ClinicController extends Controller
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
		if(Level::RightCheck('clinic',0)){
			return parent::beforeAction($action);
		}else{
			echo "<script>alert('沒有診所管理權限');history.go(-1);</script>";
			return  false;
		}
	}

    /**
     * Lists all Clinic models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new clinicSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Clinic model.
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
     * Creates a new Clinic model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		if(Level::RightCheck('clinic',1)){
			$model = new Clinic();
			$max_id = $model->find('id')->orderBy(['id'=>SORT_DESC])->one();
			if ($model->load(Yii::$app->request->post()) && $model->save()) {
				return $this->redirect(['view', 'id' => $model->id]);
			}

			return $this->render('create', [
				'model' => $model,
				'max_id'=> $max_id,
			]);
		}else{
			echo "<script>alert('沒有新增診所的權限');history.go(-1);</script>";
			return  false;
		}

    }

    /**
     * Updates an existing Clinic model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
		if(Level::RightCheck('clinic',2)){
			$model = $this->findModel($id);
			if($model->load(Yii::$app->request->post()) && $model->save()){
				return $this->redirect(['view', 'id' => $model->id]);
			}

			return $this->render('update', ['model' => $model,]);
		}else{
			echo "<script>alert('沒有修改診所的權限');history.go(-1);</script>";
			return  false;
		}
    }

    /**
     * Deletes an existing Clinic model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
		if(Level::RightCheck('clinic',3)){
			$this->updateAll(['deleted'=>'0'],['=','id',$id]);
			return $this->redirect(['index']);
		}else{
			echo "<script>alert('沒有刪除診所的權限');history.go(-1);</script>";
			return  false;
		}

    }

    /**
     * Finds the Clinic model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Clinic the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Clinic::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
