<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "front_page".
 *
 * @property int $id
 * @property string $name 分頁名稱
 * @property string $file_name 檔案名稱
 * @property int $top_id 分頁的上層id
 * @property string $build_time
 * @property int $build_id
 * @property string $deleted_time
 * @property int $deleted_id
 * @property int $deleted
 * @property string $modify_time
 * @property int $modify_id
 */
class FrontPage extends \yii\db\ActiveRecord
{
	public $text;

	/**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'front_page';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'file_name'], 'required'],
            [['top_id', 'build_id', 'deleted_id', 'deleted', 'modify_id'], 'integer'],
            [['build_time', 'deleted_time', 'modify_time'], 'safe'],
            [['name', 'file_name'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '分頁名稱',
            'file_name' => '檔案名稱',
            'top_id' => '分頁上層',
            'build_time' => '建立時間',
            'build_id' => 'Build ID',
            'deleted_time' => 'Deleted Time',
            'deleted_id' => 'Deleted ID',
            'deleted' => 'Deleted',
            'modify_time' => 'Modify Time',
            'modify_id' => 'Modify ID',
        ];
    }

	public function create()
	{
		if ($this->validate()) {
			$model = new UploadForm();
			$file = fopen($model->home_file.'/pages/'.$this->file_name,"w"); //開啟檔案
			fwrite($file,$this->text);
			fclose($file);
			return true;
		} else {
			return false;
		}
	}

	public function showtext($file_name){
		$model = new UploadForm();
		if(file_exists($model->home_file.'/pages/'.$file_name))
			return file_get_contents($model->home_file.'/pages/'.$file_name);
	}

	public function updatetext($text,$file_name){
		$model = new UploadForm();
		$file = fopen($model->home_file.'/pages/'.$file_name,"w"); //開啟檔案
		fwrite($file,$text);
		fclose($file);
		return true;
	}
}
