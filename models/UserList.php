<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_list".
 *
 * @property int $id
 * @property string $code
 * @property string $user_admin
 * @property string $user_name
 * @property string $user_email
 * @property string $user_cellphone
 * @property string $user_address
 * @property int $user_company_num
 * @property string $user_phone
 */
class UserList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_company_num','user_mny'], 'integer'],
            [['start_time', 'end_time'], 'safe'],
            [['code', 'user_admin', 'company_name', 'user_name', 'user_email', 'user_cellphone', 'user_address', 'user_phone'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => '編號',
            'user_admin' => '帳號',
            'company_name' => '公司名稱',
            'user_name' => '負責人',
            'user_email' => '負責人信箱',
            'user_cellphone' => '負責人手機',
            'user_address' => '負責人地址',
            'user_company_num' => 'User Company Num',
            'user_phone' => '公司電話',
			'user_mny'=>'月費',
			'start_time'=>'啟用日',
			'end_time'=>'截止日',
        ];
    }

    public function NewData(){
		$max_id = self::find()->orderBy('id desc')->asArray()->one();
		$new_code = 'k'.sprintf("%03d", $max_id['id']+1);
		$new_data = 'cowbtool_'.$new_code;
		$model = New UserList();
		$model->code = $new_code;
		$model->user_admin = $_POST['admin'];
		$model->company_name = $_POST['company_name'];
		$model->user_name = $_POST['companyer'];
		$model->start_time = date('Y-m-d');
		$model->user_mny = '600';
		$model->end_time = date('Y-m-d',strtotime('+1 years'));
		$model->insert();
		Yii::$app->db->createCommand("create database ".$new_data." DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci")->execute();
		Yii::$app->db->createCommand("use `cowbtool_sample`")->execute();
		$table = Yii::$app->db->createCommand("show tables")->queryAll();
		Yii::$app->db->createCommand("use `$new_data`")->execute();
		foreach($table as $val){
			$sql = Yii::$app->db->createCommand("SHOW CREATE TABLE `cowbtool_sample`.`".$val['Tables_in_cowbtool_sample']."`")->queryAll();
			$sql = $sql[0]['Create Table'];
			Yii::$app->db->createCommand("$sql")->execute();

		}
		$admin = New AdminSheet();
		$admin->admin = $_POST['admin'];
		$admin->password = $_POST['password'];
		$admin->build_time = date('Y-m-d');
		$admin->job = 0;
		$admin->user_name = $_POST['companyer'];
		$admin->user_sale = 0;
		$admin->user_pay = 0;
		$admin->insert();
		$sys = New Systemsetup();
		$sys->sys_name = $_POST['company_name'];
		$sys->insert();
		$level = New Level();
		$level->id = 0;
		$level->job_name = '老闆';
		$level->build_time = date('Y-m-d H:i:s');
		$level->useable = 1;
		$level->build_id = 1;
		$level->insert();
		mkdir('./users/'.$new_code);
		mkdir('./users/'.$new_code.'/pages');
		mkdir('./users/'.$new_code.'/home_img');
		fopen('./users/'.$new_code.'/homepage.html',"w+");
	}
}
