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
use app\models\adminsheet;
use app\models\toothcaseSearch;
use kartik\mpdf\Pdf;
use Mpdf\Mpdf;
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
    $this->layout = false; 
    if (!\Yii::$app->user->isGuest) {     
                return $this->goHome();
            }
     
            $model = new adminsheet();             
            if ($model->load(Yii::$app->request->post())) {      
                return $this->redirect(['todaycase']);        
            }else{
                echo '登入失敗!!';
            }
            return $this->render('index', [      
                'model' => $model,
            ]);

    }

     public function actionTodaycase($id=0)
    {   
        $date = date('Y-m-d');
        $date = today_to($date,$id);
        $model = new toothcase;
        $model = $model->find()->where(["end_time"=>$date])->all();
        $clinic = show_clinic('all');
        $material = show_material('all');
        return $this->render('todaycase', [
            'id'=>$id,
            'model' => $model,
            'date' => $date,
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
        $clinic_id=Yii::$app->request->queryParams;
        if(count($clinic_id) < 2) $clinic_id=['toothcaseSearch'=>['clinic_id'=>1,],];
        $searchModel = new toothcaseSearch();
        $dataProvider = $searchModel->search($clinic_id);
        $clinic = show_clinic('all');
        return $this->render('toothcase', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'clinic_info'=>$clinic['1'],
            'clinic_id'=>$clinic_id,
        ]);
    }

        public function actionPdf($clinic_this=0)
    {  
        $this->layout = false;
        $month = date('Y-m',strtotime($_POST['date']));
        $clinic_this = $_POST['toothcaseSearch']['clinic_id']; 
        $clinic = show_clinic($clinic_this);
        $material = show_material('all');
        $model = new toothcase();
        $models = $model->find()->where(['and',['like','end_time',$month],['=','clinic_id',$clinic_this],['<=','end_time',$_POST['date']]])->orderBy(['end_time'=>SORT_ASC])->asArray()->all();
        $content = $this->renderPartial('pdf',[
            'model'=>$models,
            'material'=>$material[1],
        ]);
        //設置kartik \ mpdf \ Pdf組件
        $pdf = new Pdf([
            //設置為僅使用核心字體
            'mode' => Pdf::MODE_UTF8,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // 縱向
            'orientation' => Pdf :: ORIENT_PORTRAIT,
            //流式傳輸到內嵌瀏覽器
            'destination' => Pdf::DEST_BROWSER,
            'marginTop' =>20,
            // your html content input
            'content' => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:24px}',
            // set mPDF properties on the fly
            'options' => [
                'title' => '中文',
                'autoLangToFont' => true,    //这几个配置加上可以显示中文
                'autoScriptToLang' => true,  //这几个配置加上可以显示中文
                'autoVietnamese' => true,    //这几个配置加上可以显示中文
                'autoArabic' => true,        //这几个配置加上可以显示中文
            ],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => ['富翔牙體技術所||'.$clinic[1]['clinic'].'診所<br>'.date('Y-m'),'O', false,10],
                'SetFooter' => ['{PAGENO}'],
            ]
        ]);
        
        //根據目標設置返回pdf輸出
        return $pdf->render(); 
    }

    /**
     * Displays a single toothcase model.s
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {   
        $clinic = show_clinic('all');
        $material = show_material($id);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'clinic'=>$clinic['1'],
            'material_info' =>$material['1'],
            'id_max' => $material['2'],
        ]);
    }

    /**
     * Creates a new toothcase model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($clinic_this = 1)
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
            'clinic_this' =>$clinic_this,
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
        $material_info = show_material('all');
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
            'material_info'=>$material_info['1'],
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
        Yii::$app->db->createCommand('ALTER TABLE toothcase DROP id')->query();
        Yii::$app->db->createCommand('ALTER TABLE toothcase ADD id INT( 11 ) NOT NULL AUTO_INCREMENT FIRST,ADD PRIMARY KEY(id)')->query();
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
