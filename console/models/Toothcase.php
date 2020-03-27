<?php

namespace app\console\models;

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
 * @property int $other_price
 * @property string $make_p
 * @property string $make_p_f
 * @property int $material_id_1
 * @property string $tooth_1
 * @property string $tooth_color_1
 * @property int $other_price_1
 * @property string $make_p1
 * @property string $make_p1_f
 * @property int $material_id_2
 * @property string $tooth_2
 * @property string $tooth_color_2
 * @property int $other_price_2
 * @property string $make_p2
 * @property string $make_p2_f
 * @property int $price
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
            [['start_time', 'end_time', 'clinic_id', 'name', 'material_id', 'tooth', 'other_price', 'price'], 'required'],
            [['start_time', 'end_time', 'try_time', 'checkout_date'], 'safe'],
            [['clinic_id', 'material_id', 'other_price', 'material_id_1', 'other_price_1', 'material_id_2', 'other_price_2', 'price', 'checkout'], 'integer'],
            [['name'], 'string', 'max' => 20],
            [['tooth', 'tooth_color', 'make_p', 'make_p_f', 'tooth_1', 'tooth_color_1', 'make_p1', 'make_p1_f', 'tooth_2', 'tooth_color_2', 'make_p2', 'make_p2_f'], 'string', 'max' => 100],
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
            'material_id' => '材料1',
            'tooth' => '齒位1',
            'tooth_color' => '齒色',
            'price' => '費用',
            'other_price' => '其他費用',
            'remark' => '備註',
            'material_id_1' => '材料2',
            'tooth_1' => '齒位2',
            'make_p' => 'Make P',
            'make_p_f' => 'Make P F',
            'tooth_color_1' => 'Tooth Color 1',
            'other_price_1' => 'Other Price 1',
            'material_id_2' => '材料3',
            'tooth_2' => '材料3',
            'make_p1' => 'Make P1',
            'make_p1_f' => 'Make P1 F',
            'tooth_color_2' => 'Tooth Color 2',
            'other_price_2' => 'Other Price 2',
            'checkout' => 'Checkout',
            'make_p2' => 'Make P2',
            'make_p2_f' => 'Make P2 F',
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
