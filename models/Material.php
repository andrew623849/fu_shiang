<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "material".
 *
 * @property int $id
 * @property int $sort 材料的排序
 * @property string $material 材料的名稱
 * @property int $price 材料的價錢
 * @property string $build_time 建立時間
 * @property int $deleted 修改資料後 要隱藏起來(永不顯示) 0:未隱藏 1:隱藏
 * @property int $useable 將材料放入停用區 0:使用 1:暫不使用
 * @property string $modify_time 修改時間
 *
 * @property Toothcase[] $toothcases
 */
class Material extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'material';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'sort', 'material', 'price', 'build_time'], 'required'],
            [['id', 'sort', 'price', 'deleted', 'useable'], 'integer'],
            [['build_time', 'modify_time'], 'safe'],
            [['material'], 'string', 'max' => 50],
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
            'sort' => 'Sort',
			'material' => '材料',
			'price' => '價錢',
			'build_time' => '建立時間',
            'deleted' => 'Deleted',
            'useable' => 'Useable',
            'modify_time' => 'Modify Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToothcases()
    {
        return $this->hasMany(Toothcase::className(), ['material_id' => 'id']);
    }
}
