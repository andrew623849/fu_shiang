<?php

namespace app\console\models;

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
            [['code', 'user_admin', 'user_name', 'user_email', 'user_cellphone', 'user_address', 'user_phone'], 'required'],
            [['user_company_num'], 'integer'],
            [['code', 'user_admin', 'user_name', 'user_email', 'user_cellphone', 'user_address', 'user_phone'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'user_admin' => 'User Admin',
            'user_name' => 'User Name',
            'user_email' => 'User Email',
            'user_cellphone' => 'User Cellphone',
            'user_address' => 'User Address',
            'user_company_num' => 'User Company Num',
            'user_phone' => 'User Phone',
        ];
    }
}
