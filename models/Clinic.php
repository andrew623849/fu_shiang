<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clinic".
 *
 * @property int $id
 * @property string $clinic
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
            [['id'], 'integer'],
            [['clinic'], 'string', 'max' => 50],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'clinic' => 'Clinic',
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
