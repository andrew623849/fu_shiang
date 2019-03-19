<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "admin_sheet".
 *
 * @property string $name
 * @property int $admin
 * @property int $password
 * @property string $build_time
 * @property int $use_year
 * @property string $use_name
 * @property string $use_phone
 * @property string $use_email
 * @property int $use_pay
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
            [['name', 'admin', 'password', 'build_time', 'use_year', 'use_name', 'use_phone', 'use_email', 'use_pay'], 'required'],
            [['admin', 'password', 'use_year', 'use_pay'], 'integer'],
            [['build_time'], 'safe'],
            [['name', 'use_name', 'use_phone', 'use_email'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'admin' => 'Admin',
            'password' => 'Password',
            'build_time' => 'Build Time',
            'use_year' => 'Use Year',
            'use_name' => 'Use Name',
            'use_phone' => 'Use Phone',
            'use_email' => 'Use Email',
            'use_pay' => 'Use Pay',
        ];
    }
}
