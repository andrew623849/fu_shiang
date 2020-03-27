<?php

namespace app\console\models;

use Yii;

/**
 * This is the model class for table "bill".
 *
 * @property int $id
 * @property int $check_date
 * @property int $thoothcase_mix
 * @property int $thoothcase_max
 * @property int $clinic_id
 * @property int $type 0:已收款 1:未收款
 */
class Bill extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bill';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['check_date', 'thoothcase_mix', 'thoothcase_max', 'clinic_id', 'type'], 'required'],
            [['check_date', 'thoothcase_mix', 'thoothcase_max', 'clinic_id', 'type'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'check_date' => 'Check Date',
            'thoothcase_mix' => 'Thoothcase Mix',
            'thoothcase_max' => 'Thoothcase Max',
            'clinic_id' => 'Clinic ID',
            'type' => 'Type',
        ];
    }
}
