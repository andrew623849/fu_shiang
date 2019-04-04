<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "toothcase".
 *
 * @property int $id
 * @property string $start_time 收件日
 * @property string $end_time 交件日
 * @property string $try_time
 * @property int $clinic_id
 * @property string $name 病人姓名
 * @property int $material_id 材料
 * @property string $tooth 齒位
 * @property string $tooth_color 齒色
 * @property int $price
 * @property int $other_price
 * @property int $checkout 已結帳:1未結帳:0
 * @property string $checkout_date
 * @property string $remark 備註
 *
 * @property Clinic $clinic
 * @property Material $material
 */
class Toothcase extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'toothcase';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['start_time', 'end_time', 'clinic_id', 'name', 'material_id', 'tooth', 'price', 'other_price'], 'required'],
            [['start_time', 'end_time', 'try_time', 'checkout_date'], 'safe'],
            [['clinic_id', 'material_id', 'price', 'other_price', 'checkout'], 'integer'],
            [['name'], 'string', 'max' => 20],
            [['tooth', 'tooth_color'], 'string', 'max' => 50],
            [['remark'], 'string', 'max' => 500],
            [['clinic_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clinic::className(), 'targetAttribute' => ['clinic_id' => 'id']],
            [['material_id'], 'exist', 'skipOnError' => true, 'targetClass' => Material::className(), 'targetAttribute' => ['material_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'start_time' => '收件日',
            'end_time' => '交件日',
            'try_time' => '試戴日',
            'clinic_id' => '診所',
            'name' => '病人姓名',
            'material_id' => '材料',
            'tooth' => '齒位',
            'tooth_color' => '齒色',
            'price' => '費用',
            'other_price' => '其他費用',
            'remark' => '備註',
            'checkout' => 'Checkout',
            'checkout_date' => 'Check Out',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClinic()
    {
        return $this->hasOne(Clinic::className(), ['id' => 'clinic_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterial()
    {
        return $this->hasOne(Material::className(), ['id' => 'material_id']);
    }
}
