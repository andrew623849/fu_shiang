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
    {   $date =date('Y-m-d');
        $date = '2019-03-11';
        $model = new toothcase;
        $model = $model->find()->where(["end_time"=>$date])->all();
        $clinic = show_clinic('all');
        $material = show_material('all');
        return $this->render('index', [
            'model' => $model,
            'clinic_info'=>$clinic['1'],
            'material_info' =>$material['1'],
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
        $dataProvider = $searchModel->search($clinic_id);
        $clinic = show_clinic('all');
        return $this->render('toothcase', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'clinic_info'=>$clinic['1'],
        ]);
    }

    /**
     * Displays a single toothcase model.s
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {   
        $clinic = show_clinic($id);
        $material = show_material($id);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'clinic_info'=>$clinic['1'],
            'material_info' =>$material['1'],
            'id_max' => $material['2'],
        ]);
    }

    /**
     * Creates a new toothcase model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $material = show_material('all');
        $model = new toothcase();
        $clinic = show_clinic('all');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            toothcase::updateAll(['price'=>price_case($_POST['Toothcase'])],['name'=>$_POST['Toothcase']['name'],'start_time'=>$_POST['Toothcase']['start_time'],'end_time'=>$_POST['Toothcase']['end_time']]);
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model,
            'clinic_model' => $clinic['0'],
            'clinic_info'=>$clinic['1'],
            'material_model'=>$material['0'],
            'material_info'=>$material['1'],
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

        $material = show_material($id);
        $clinic = show_clinic($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            toothcase::updateAll(['price'=>price_case($_POST['Toothcase'])],['name'=>$_POST['Toothcase']['name'],'start_time'=>$_POST['Toothcase']['start_time'],'end_time'=>$_POST['Toothcase']['end_time']]);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'clinic_model' => $clinic['0'],
            'clinic_info'=>$clinic['1'],
            'material_model'=>$material['0'],
            'material_info'=>$material['1'],
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
