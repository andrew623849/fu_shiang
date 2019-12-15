<?php

namespace app\controllers;

use Yii;
use app\models\Material;
use app\models\MaterialSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MaterialController implements the CRUD actions for Material model.
 */
class MaterialController extends Controller
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
		//如果未登录，则直接返回
		if(Yii::$app->session['login'] == 0){
			echo "<script>alert('請先登入');location.href='?r=site/index'</script>";

			return  false;
		}
		return parent::beforeAction($action);
	}

    /**
     * Lists all Material models.
     * @return mixed
     */
    public function actionIndex()
    {
		$searchModel = new MaterialSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,['useable'=>0,'deleted'=>0]);
        $dataProvider_1 = $searchModel->search(Yii::$app->request->queryParams,['useable'=>1,'deleted'=>0]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dataProvider_1' => $dataProvider_1,
        ]);
    }

    /**
     * Displays a single Material model.
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
     * Creates a new Material model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Material();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Material model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model_1 = $this->findModel($id);
		MaterialSearch::UpdateById(['deleted'=>'1'],$id);

		$model = new Material();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model_1,
        ]);
    }

	/**
	 * Deletes an existing Material model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionNouse($id)
	{
		MaterialSearch::UpdateById(['useable'=>1,'modify_time'=>date('Y-m-d H:i:s')],$id);


		return $this->redirect(['index']);
	}
	/**
	 * Deletes an existing Material model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUse($id)
	{
		MaterialSearch::UpdateById(['useable'=>0,'modify_time'=>date('Y-m-d H:i:s')],$id);

		return $this->redirect(['index']);
	}

    /**
     * Finds the Material model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Material the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Material::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
