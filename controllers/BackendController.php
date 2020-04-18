<?php

namespace app\controllers;

use app\models\AdminSheetSearch;
use app\models\clinicSearch;
use app\models\Level;
use app\models\LineNotify;
use app\models\MaterialSearch;
use app\models\Toothcase;
use app\models\toothcaseSearch;
use edofre\fullcalendar\models\Event;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\AdminSheet;
use yii\widgets\DetailView;

class BackendController extends Controller
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
	public function beforeAction($action) {
		$currentaction = $action->id;
		$novalidactions = ['Person'];
		if(in_array($currentaction,$novalidactions)) {
			$action->controller->enableCsrfValidation = false;
		}
		return true;
	}
	/**
     * {@inheritdoc}
     */
    public function actions(){
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
    public function actionIndex(){
     	$this->layout = 'logout';
        Yii::$app->session['login'] = 0;
        Yii::$app->session['user'] = "";

        return $this->render('index');
    }

	public function actionLinesend(){
		return $this->render('linesend');
	}

	public function actionWeekinfo(){
    	$this->layout = false;
		return $this->render('weekinfo');
	}

	public function actionFinishcase(){
		$this->layout = false;
		return $this->render('finishcase');
	}

	public function actionJoinLine(){
		$url = LineNotify::authorization();
		return $this->redirect($url);
	}

	public function actionPerson(){
		if(Yii::$app->session['login']){
			if(!empty($_POST['code']) && $_POST['state'] == 'csrf_token'){
				$response = LineNotify::getToken($_POST['code']);
				if(!empty($response)){
					LineNotify::snedNotify($response, ['message'=>'歡迎加入']);
					$_SESSION['user']['line_token'] = $response;
					AdminSheet::updateAll(['line_token' => $response], ['id' => $_SESSION['user']['id']]);
				}
			}
			return $this->render('person');
		}
		$message =  "";
		if(isset($_POST["admin"]) && isset($_POST["password"])){
			$model = new AdminSheet();
			$model = $model->find()->where(['and',["admin"=>$_POST["admin"]],["password"=>$_POST["password"]],["password"=>$_POST["password"]]])->asArray()->one();
			if($model != null){
				if($model['deleted'] == 1){
					$message =  '登入失敗!!<br>您已於'.$model['deleted_time'].'離職';
				}else{
					Yii::$app->session['login'] = 1;
					if(Yii::$app->session['login']){
						Yii::$app->session['user'] = $model;
						$this->layout = 'main';
						return $this->render('person');
					}
				}
			}elseif($_POST["admin"] == ""){
				$message =  '登入失敗!!<br>請輸入帳號';
			}elseif($_POST["password"] == ""){
				$message =  '登入失敗!!<br>請輸入密碼';
			}else{
				$message =  '登入失敗!!<br>請輸入正確帳號與密碼';
			}
		}
		$this->layout = 'logout';
		return $this->render('index',['message'=>$message]);
	}

	public function actionTodaycase(){
		if(Level::RightCheck('today_case',0)){
			$model = new Toothcase;
			if(empty($_POST['time'])){
				$start_time = date('Y-m-01',strtotime('-1 months'));
				$end_time = date('Y-m-t',strtotime('+1 months'));
			}else{

			}
			$model = $model->find()->where(["or",["and",[">=","start_time",$start_time],["<=","start_time",$end_time]],["and",[">=","try_time",$start_time],["<=","try_time",$end_time]]])->orderBy(['clinic_id'=>SORT_ASC,'end_time'=>SORT_ASC])->asArray()->all();
			return $this->render('todaycase', [
				'model' => $model,
			]);
		}else{
			echo "<script>alert('沒有交件權限');history.go(-1);</script>";
			return  false;
		}

	}
	public function actionEvent()
	{
		$start_time = explode('T',$_GET['start'])[0];
		$end_time = explode('T',$_GET['end'])[0];
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$model = new Toothcase;
		$model = $model->find()->where(["or",["and",[">=","start_time",$start_time],["<=","start_time",$end_time]],["and",[">=","try_time",$start_time],["<=","try_time",$end_time]]])->orderBy(['clinic_id'=>SORT_ASC,'end_time'=>SORT_ASC])->asArray()->all();
		$events = [];
		$clinic = clinicSearch::GetData();
		foreach($model as $val){
			$events[] = new Event([
				'id'=> uniqid(),
				'title'=> $clinic[$val['clinic_id']]['clinic'].'_交件 '.$val['name'],
				'className' => $val['id'],
				'start'=> $val['end_time'],
				'color'=> 'blue'
			]);
			$events[] = new Event([
				'id'=> uniqid(),
				'title'=>  $clinic[$val['clinic_id']]['clinic'].'_收件 '.$val['name'],
				'className' => $val['id'],
				'start'=> $val['start_time'],
				'color'=> 'green'
			]);
		}

		return $events;
	}
	public function actionEdetail()
	{
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$models = toothcaseSearch::getData($_POST['id'])[0];
		$clinic = clinicSearch::GetData();
		$material = MaterialSearch::GetDataWhere();
		$admin_sheet = AdminSheetSearch::GetUserData();
		$attributes_arr = [];
		$attributes_arr[] = ['label'=>'診所','value'=>$clinic[$models['clinic_id']]['clinic']];
		$attributes_arr[] = ['label'=>'工作日期','value'=>$models['start_time'].' ~ '.$models['end_time']];
		if($models['try_time'] != 0){
			$attributes_arr[] = ['label'=>'試戴日','value'=>$models['try_time']];
		}
		$attributes_arr[] = ['label'=>'病人姓名','value'=>$models['name']];
		$attributes_arr[] = ['label'=>'材料1','value'=>$material[$models['material_id']]['material'].'('.$models['tooth'].')'];
		$attributes_arr[] = ['label'=>'齒色','value'=>$models['tooth_color']];
		if(!empty($material[$models['material_id']]['make_process'])){
			$make_p = explode(',', $material[$models['material_id']]['make_process']);
			$make_p_arr = [];
			$make_p_arr[] = ['label'=>'程序','value'=>'負責人'];
			$marker_per = explode(',',$models['make_p']);
			$marker_pf = explode(',',$models['make_p_f']);
			foreach($make_p as $key=>$val){
				if(!empty($marker_per[$key])){
					if($marker_pf[$key] == 1){
						$make_p_arr[] =  ['label'=>$val,'format' => 'html','value'=>$admin_sheet[$marker_per[$key]]['user_name'].'<i style="color:green;" class="glyphicon glyphicon-ok"></i>'];
					}else{
						$make_p_arr[] =  ['label'=>$val,'format' => 'html','value'=>$admin_sheet[$marker_per[$key]]['user_name'].'<i style="color:red;" class="glyphicon glyphicon-remove"></i>'];
					}
				}else{
					$make_p_arr[] =  ['label'=>$val,'format' => 'html','value'=>''];
				}
			}
			$attributes_arr[] = ['label'=>'工作流程','format' => 'html','value'=>DetailView::widget([
				'model' => $models,
				'attributes' => $make_p_arr,
				'options'=>['class' => 'table table-striped table-bordered detail-view'],
			])];
		}
		if($models['material_id_1'] != 0){
			$attributes_arr[] = ['label'=>'材料2','value'=>($models['material_id_1']==0?'':$material[$models['material_id_1']]['material']).'('.$models['tooth_1'].')'];
			$attributes_arr[] = ['label'=>'齒色','value'=>$models['tooth_color_1']];
		}
		if(!empty($material[$models['material_id_1']]['make_process'])){
			$make_p = explode(',', $material[$models['material_id_1']]['make_process']);
			$make_p_arr = [];
			$make_p_arr[] = ['label'=>'程序','value'=>'負責人'];
			$marker_per = explode(',',$models['make_p1']);
			$marker_pf = explode(',',$models['make_p1_f']);
			foreach($make_p as $key=>$val){
				if(!empty($marker_per[$key])){
					if($marker_pf[$key] == 1){
						$make_p_arr[] =  ['label'=>$val,'format' => 'html','value'=>$admin_sheet[$marker_per[$key]]['user_name'].'<i style="color:green;" class="glyphicon glyphicon-ok"></i>'];
					}else{
						$make_p_arr[] =  ['label'=>$val,'format' => 'html','value'=>$admin_sheet[$marker_per[$key]]['user_name'].'<i style="color:red;" class="glyphicon glyphicon-remove"></i>'];
					}
				}else{
					$make_p_arr[] =  ['label'=>$val,'format' => 'html','value'=>''];
				}
			}
			$attributes_arr[] = ['label'=>'工作流程','format' => 'html','value'=>DetailView::widget([
				'model' => $models,
				'attributes' => $make_p_arr,
				'options'=>['class' => 'table table-striped table-bordered detail-view'],
			])];
		}
		if($models['material_id_2'] != 0){
			$attributes_arr[] = ['label'=>'材料3','value'=>($models['material_id_2']==0?'':$material[$models['material_id_1']]['material']).'('.$models['tooth_2'].')'];
			$attributes_arr[] = ['label'=>'齒色','value'=>$models['tooth_color_2']];
		}
		if(!empty($material[$models['material_id_2']]['make_process'])){
			$make_p = explode(',', $material[$models['material_id_2']]['make_process']);
			$make_p_arr = [];
			$make_p_arr[] = ['label'=>'程序','value'=>'負責人'];
			$marker_per = explode(',',$models['make_p2']);
			$marker_pf = explode(',',$models['make_p2_f']);
			foreach($make_p as $key=>$val){
				if(!empty($marker_per[$key])){
					if($marker_pf[$key] == 1){
						$make_p_arr[] =  ['label'=>$val,'format' => 'html','value'=>$admin_sheet[$marker_per[$key]]['user_name'].'<i style="color:green;" class="glyphicon glyphicon-ok"></i>'];
					}else{
						$make_p_arr[] =  ['label'=>$val,'format' => 'html','value'=>$admin_sheet[$marker_per[$key]]['user_name'].'<i style="color:red;" class="glyphicon glyphicon-remove"></i>'];
					}
				}else{
					$make_p_arr[] =  ['label'=>$val,'format' => 'html','value'=>''];
				}
			}
			$attributes_arr[] = ['label'=>'工作流程','format' => 'html','value'=>DetailView::widget([
				'model' => $models,
				'attributes' => $make_p_arr,
				'options'=>['class' => 'table table-striped table-bordered detail-view'],
			])];
		}
		$attributes_arr[] = ['label'=>'備註','value'=>$models['remark']];
		$attributes_arr[] = ['label'=>'金額','value'=>$models['price']];
		return DetailView::widget([
			'model' => $models,
			'attributes' => $attributes_arr,
			'options'=>['class' => 'table table-striped table-bordered detail-view'],
		]);
	}
}
