<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "admin_sheet".
 *
 * @property int $id
 * @property string $em_num
 * @property string $admin
 * @property string $password
 * @property string $build_time
 * @property int $job
 * @property string $user_name
 * @property string $user_phone
 * @property string $user_email
 * @property int $user_pay
 * @property string $user_f_na
 * @property string $user_f_ph
 * @property string $user_exp
 * @property string $user_grade
 * @property string $remark
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
            [['em_num', 'admin', 'password', 'build_time', 'job', 'user_name', 'user_phone', 'user_email', 'user_pay', 'user_f_na', 'user_f_ph', 'user_exp', 'user_grade', 'remark'], 'required'],
            [['build_time'], 'safe'],
            [['job', 'user_pay'], 'integer'],
            [['em_num', 'user_f_na', 'user_f_ph', 'user_exp', 'user_grade', 'remark'], 'string', 'max' => 100],
            [['admin', 'password', 'user_name', 'user_phone', 'user_email'], 'string', 'max' => 64],
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
        ];
    }

    public function getJob()
    {
        return $this->hasOne($job_arr('all'), ['id' => 'key']);
    }
}
