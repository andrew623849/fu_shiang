<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clinic".
 *
 * @property int $id
 * @property string $clinic
 * @property int $phone
 * @property string $adress
 * @property string $email
 * @property int $deleted
 *
 * @property Toothcase[] $toothcases
 */
class Clinic extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clinic';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'clinic'], 'required'],
            [['id', 'phone', 'deleted'], 'integer'],
            [['clinic'], 'string', 'max' => 50],
            [['adress', 'email'], 'string', 'max' => 100],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '編號',
            'clinic' => '診所名稱',
            'phone' => '診所電話',
            'adress' => '診所地址',
            'email' => '診所信箱',
            'deleted' => 'Deleted',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToothcases()
    {
        return $this->hasMany(Toothcase::className(), ['clinic_id' => 'id']);
    }
}
