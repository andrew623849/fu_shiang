<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "outlay".
 *
 * @property int $id
 * @property string $name
 * @property string $buy_time
 * @property int $pay_mny
 */
class Outlay extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'outlay';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'buy_time', 'pay_mny'], 'required'],
            [['buy_time'], 'safe'],
            [['pay_mny'], 'integer'],
            [['name'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '項目',
            'buy_time' => '購入時間',
            'pay_mny' => '購入金額',
        ];
    }
}
