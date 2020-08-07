<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
	{
	/**
	* @var UploadedFile
	*/
	public $imageFile;
	public $text;
	public $home_file;
	public $file_arr;
	public $file_config;

	public function rules()
	{
		return [
			[['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxFiles' => 4],
			[['text'],'string', 'max' => 10000]
		];
	}

	function __construct(){
		$this->home_file = './users/'.explode('_',Yii::$app->db->dsn)[1];
		$this->showtext();
	}

	public function upload()
	{
		if ($this->validate()) {
			if(!empty($this->imageFile)){
				foreach ($this->imageFile as $key =>$file){
					$file->saveAs($this->home_file.'/home_img/'.$file->name);
				}
			}
			$file = fopen($this->home_file.'/homepage.html',"w"); //開啟檔案
			fwrite($file,$this->text);
			fclose($file);
			return true;
		} else {
			return false;
		}
	}
	public function deleted()
	{
		$file= explode('../',$_POST['pic_link'])[1];
		unlink($file);
		return true;
	}

	private function showtext(){
		if(file_exists($this->home_file.'/homepage.html'))
			$this->text = file_get_contents($this->home_file.'/homepage.html');
		$dir = $this->home_file.'/home_img';
		// 用 opendir() 開啟目錄，開啟失敗終止程式
		$handle = @opendir($dir) or die("Cannot open " . $dir);

		// 用 readdir 讀取檔案內容
		$k=0;
		while($file = readdir($handle)){
			if($file != "." && $file != ".."){
				$this->file_arr[] =  '../'.$dir.'/'.$file;
				$this->file_config[] = ['caption'=> $file, 'filename'=>$file,'key'=>$k];
				$k ++;

			}
		}
	}
}