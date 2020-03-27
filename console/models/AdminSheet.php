<?php

namespace app\console\models;

use Yii;

/**
 * This is the model class for table "admin_sheet".
 *
 * @property int $id
 * @property string $admin
 * @property string $password
 * @property string $build_time
 * @property int $job
 * @property string $user_name
 * @property string $user_br
 * @property int $user_sale
 * @property string $user_phone
 * @property string $line_token
 * @property string $user_email
 * @property string $user_line
 * @property int $user_pay
 * @property string $user_f_na
 * @property string $user_f_ph
 * @property string $user_f_rel
 * @property string $user_exp
 * @property string $user_grade
 * @property string $remark
 * @property int $deleted
 * @property string $deleted_time
 * @property int $deleted_id
 */
class AdminSheet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'admin_sheet';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['admin', 'password', 'build_time', 'job', 'user_name', 'user_br', 'user_sale', 'user_phone', 'user_email', 'user_pay'], 'required'],
            [['build_time', 'user_br', 'deleted_time'], 'safe'],
            [['job', 'user_sale', 'user_pay', 'deleted', 'deleted_id'], 'integer'],
            [['admin', 'password', 'user_name', 'user_phone',  'user_email'], 'string', 'max' => 64],
            [['line_token'], 'string', 'max' => 500],
            [['user_line', 'user_f_na', 'user_f_ph', 'user_f_rel', 'user_exp', 'user_grade', 'remark'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '編號',
            'em_num' => '員工編號',
            'admin' => '帳號',
            'password' => '密碼',
            'build_time' => '建立時間',
            'job' => '職位',
            'user_name' => '員工姓名',
            'user_phone' => '員工電話',
            'user_email' => '員工信箱',
            'user_pay' => '員工薪資',
            'user_f_na' => '聯絡人',
            'user_f_ph' => '聯絡人電話',
            'user_exp' => '經歷',
            'user_grade' => '學歷',
            'remark' => '備註',
            'user_br' => '出生年月日',
            'user_sale' => '性別',
            'user_line' => 'LINE ID',
            'user_f_rel' => '聯絡人關係',
            'line_token' => 'Line Token',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLevel()
    {
        return $this->hasOne(Level::className(), ['id' => 'job']);
    }
}
