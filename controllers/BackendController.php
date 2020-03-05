<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\AdminSheet;

class BackendController extends Controller
{   /**
     * {@inheritdoc}
     */
	private $clientId = 'pdIDlXwhecWpEIsHSwJHKw';
	private $clientSecret = 'EVBItEZPDw525sSop0zFPqVJCMo9xR7NU84x0P6JBkk';
	private $callback = 'http://fushiang.cowbtool.com/backend/person';
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
	public function actionSend(){
    	$token = 'Rxmm0mvZjNbi8ofVM06uZZNcmaLeWkxABCXvN9JyD2M';
    	$data['message'] = '我愛你';
		$this->snedNotify($token,$data);
	}
	public function actionJoinLine(){
		$url = "https://notify-bot.line.me/oauth/authorize";
		$data = [
			"response_type" => "code",
			"client_id" => $this->clientId,
			"redirect_uri" => $this->callback,
			"scope" => "notify",
			"state" => "csrf_token",
			"response_mode"=>"form_post"

		];
		$url = $url . "?" . http_build_query($data);
		return $this->redirect($url);
	}
	public function actionPerson(){
		if(Yii::$app->session['login']){
			if(!empty($_POST['code']) && $_POST['state'] == 'csrf_token'){
				$response = $this->token($_POST['code']);
				if(!empty($response)){
					$this->snedNotify($response, ['message'=>'歡迎加入']);
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
	private function token($code){
		$url = "https://notify-bot.line.me/oauth/token";
		$type = "POST";
		$data = [
			"grant_type" => "authorization_code",
			"code" => $code,
			"redirect_uri" => $this->callback,
			"client_id" => $this->clientId,
			"client_secret" => $this->clientSecret,
		];
		$header = [
			"Content-Type: application/x-www-form-urlencoded"
		];
		$response = $this->curl($url, $type, $data, [], $header);
		$response = json_decode($response, true);
		if ($response["status"] != "200") {
			return '';
		}
		return $response['access_token'];
	}
	/**
	 * 傳送notify
	 * @param string $token
	 * @param array $data
	 * @return bool
	 * @throws Exception
	 */
	function snedNotify($token, $data)
	{
		$url = "https://notify-api.line.me/api/notify";
		$type = "POST";
		$header = [
			"Authorization:	Bearer " . $token,
			"Content-Type: multipart/form-data"
		];
		if (!empty($data["imageFile"])) {
			$data["imageFile"] = curl_file_create($data["imageFile"]);
		}
		$response = BackendController::curl($url, $type, $data, [], $header);
		$response = json_decode($response, true);
		if ($response["status"] != "200") {
			return false;
		}
		return $response;

	}
	private function curl($url, $type = "GET", $data = [], $options = [], $header = [])
	{
		$ch = curl_init();
		if (strtoupper($type) == "GET") {
			$url = $url . "?" . http_build_query($data);
		} else {//POST
			if (in_array("Content-Type: multipart/form-data", $header)) {
				$options = [
					CURLOPT_POST => true,
					CURLOPT_POSTFIELDS => $data
				];
			} else {
				$options = [
					CURLOPT_POST => true,
					CURLOPT_POSTFIELDS => http_build_query($data)
				];
			}
		}
		$defaultOptions = [
			CURLOPT_URL => $url,
			CURLOPT_HTTPHEADER => $header,
			CURLOPT_RETURNTRANSFER => true,        // 不直接出現回傳值
			CURLOPT_SSL_VERIFYPEER => false,        // ssl
			CURLOPT_SSL_VERIFYHOST => false,        // ssl
			CURLOPT_HEADER => true                    //取得header
		];
		$options = $options + $defaultOptions;
		curl_setopt_array($ch, $options);
		$response = curl_exec($ch);
		if (curl_error($ch)) {
			throw new Exception(curl_error($ch), curl_errno($ch));
		}
		$headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$response = substr($response, $headerSize);
		return $response;
	}
}
