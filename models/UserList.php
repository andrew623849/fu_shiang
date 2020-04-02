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
}
