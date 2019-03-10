<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\toothcase;
use app\models\clinic;
use app\models\material;
use app\models\toothcaseSearch;
class SiteController extends Controller
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

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
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
     public function actionIndex()
    {
        $searchModel = new toothcaseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all toothcase models.
     * @return mixed
     */
    public function actionToothcase()
    {
        $clinic_id =Yii::$app->request->queryParams;
        if(count($clinic_id) < 2) $clinic_id=['toothcaseSearch'=>['clinic_id'=>1,],];
        $searchModel = new toothcaseSearch();
        $dataProvider = $searchModel->search($clinic_id['toothcaseSearch']['clinic_id']);
        $clinic_model = new Clinic();
        $clinic_info=$clinic_model->find()->all(); 
        return $this->render('toothcase', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'clinic_info'=>$clinic_info,
        ]);
    }

    /**
     * Displays a single toothcase model.s
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {   
        $models = new toothcase();
        $clinic_model = new Clinic();
        $material_model = new material();
        $id_max = $models->find()->max('id');
        $id = $models->find()->where(["id"=>$id])->asArray()->one();
        $clinic_info = $clinic_model->find()->where(["id"=>$id['clinic_id']])->asArray()->one();
        $material_info = $material_model->find()->where(["id"=>$id['material_id']])->asArray()->one();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'clinic_info'=>$clinic_info,
            'material_info' =>$material_info,
            'id_max' => $id_max,
        ]);
    }

    /**
     * Creates a new toothcase model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new toothcase();
        $material_model = new material();
        $clinic_model = new Clinic();
        $clinic_info=$clinic_model->find()->all(); 
        $material_info=$material_model->find()->all();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            var_dump($_POST);
            die;
            //$price_update = Customer:: find()->where(['id'->])
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model,
            'clinic_model' => $clinic_model,
            'clinic_info'=>$clinic_info,
            'material_model'=>$material_model,
            'material_info'=>$material_info,
        ]);
    }

    /**
     * Updates an existing toothcase model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $material_model = new material();
        $clinic_model=new Clinic();
        $clinic_info=$clinic_model->find()->all();
        $material_info=$material_model->find()->all();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'clinic_model' => $clinic_model,
            'clinic_info'=>$clinic_info,
            'material_model'=>$material_info,
            'material_info'=>$material_info,
        ]);
    }

    /**
     * Deletes an existing toothcase model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['toothcase']);
    }
    /**
     * Finds the toothcase model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return toothcase the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = toothcase::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
