<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "systemsetup".
 *
 * @property string $sys_name 牙體技工所的名子
 * @property string $sys_logo_pic 技工所的logo圖
 * @property int $sys_mny 系統費用
 * @property string $s_time 系統啟用日
 * @property string $e_time 系統到期日
 * @property int $clinic_name 0:診所名稱 1:診所代號
 */
class Systemsetup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'systemsetup';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sys_logo_pic'], 'required'],
            [['sys_logo_pic'], 'string'],
            [['sys_mny', 'clinic_name'], 'integer'],
            [['s_time', 'e_time'], 'safe'],
            [['sys_name'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'sys_name' => '牙體技工所的名子',
            'sys_logo_pic' => '技工所的logo圖',
            'sys_mny' => '系統費用',
            's_time' => '系統啟用日',
            'e_time' => '系統到期日',
            'clinic_name' => '0:診所名稱 1:診所代號',
        ];
    }

	public function SysName()
	{
		$system_data = Systemsetup::find()->Asarray()->one();
		return $system_data['sys_name'];
	}
	public function SysLogo()
	{
		$system_data = Systemsetup::find()->Asarray()->one();
		return $system_data['sys_logo_pic'];
	}
}
