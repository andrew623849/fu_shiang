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

    /**
     * Lists all AdminSheet models.
     * @return mixed
     */

    public function actionIndex()
    {
         if(Yii::$app->session['login']){
            $searchModel = new AdminSheetSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }else{
            $model = new AdminSheet();           
            return $this->render('/site/index', [      
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays a single AdminSheet model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if(Yii::$app->session['login']){
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }else{
            $model = new AdminSheet();           
            return $this->render('/site/index', [      
                'model' => $model,
            ]);
        }
    }

    /**
     * Creates a new AdminSheet model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(Yii::$app->session['login']){
            $model = new AdminSheet();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('create', [
                'model' => $model,
            ]);
        }else{
            $model = new AdminSheet();           
            return $this->render('/site/index', [      
                'model' => $model,
            ]);
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
        if(Yii::$app->session['login']){
            $model = $this->findModel($id);
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        }else{
            $model = new AdminSheet();           
            return $this->render('/site/index', [      
                'model' => $model,
            ]);
        }
    }

        public function actionPupdate($id)
    {
        if(Yii::$app->session['login']){
            $model = $this->findModel($id);
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->session['login'] = 0;
                return $this->render('/site/index', ['message'=>"修改個人資料成功，請重新登入"]);
            }

            return $this->render('pupdate', [
                'model' => $model,
            ]);
        }else{
            $model = new AdminSheet();           
            return $this->render('/site/index', [      
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing AdminSheet model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if(Yii::$app->session['login']){
            AdminSheet::updateAll(['deleted'=>1,'deleted_time'=>date('Y-m-d H:i:s'),'deleted_id'=>Yii::$app->session['user']['0']],['id'=>$id]);
            return $this->redirect(['index']);
        }else{
            $model = new AdminSheet();           
            return $this->render('/site/index', [      
                'model' => $model,
            ]);
        }
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
        if(Yii::$app->session['login']){
            if (($model = AdminSheet::findOne($id)) !== null) {
                return $model;
            }
            throw new NotFoundHttpException('The requested page does not exist.');
        }else{
            $model = new AdminSheet();           
            return $this->render('/site/index', [      
                'model' => $model,
            ]);
        }
    }
}
