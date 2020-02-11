<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "level".
 *
 * @property int $id
 * @property string $job_name
 * @property string $build_time
 * @property int $build_id
 * @property int $useable
 * @property int $today_case 交件權限
 * @property int $toothcase 病例權限
 * @property int $outlay 支出權限
 * @property int $report 報表權限
 * @property int $admin_sheet 員工權限
 * @property int $material 材料權限
 * @property int $clinic 診所權限
 * @property int $level 職位權限
 */
class Level extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'level';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'job_name', 'build_time', 'build_id', 'useable', 'today_case', 'toothcase', 'outlay', 'report', 'admin_sheet', 'material', 'clinic', 'level'], 'required'],
            [['id', 'build_id', 'useable', 'today_case', 'toothcase', 'outlay', 'report', 'admin_sheet', 'material', 'clinic', 'level'], 'integer'],
            [['build_time'], 'safe'],
            [['job_name'], 'string', 'max' => 100],
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
            'job_name' => '職稱',
            'build_time' => '建立時間',
            'build_id' => '建立人',
            'useable' => 'Useable',
            'today_case' => '交件權限',
            'toothcase' => '病例權限',
            'outlay' => '支出權限',
            'report' => '報表權限',
            'admin_sheet' => '員工權限',
            'material' => '材料權限',
            'clinic' => '診所權限',
            'level' => '職位權限',
        ];
    }

	/**
	 * {@inheritdoc}
	 */
	public function LevelLabels()
	{
		return [
			'today_case' => '交件權限',
			'toothcase' => '病例權限',
			'outlay' => '支出權限',
			'report' => '報表權限',
			'admin_sheet' => '員工權限',
			'material' => '材料權限',
			'clinic' => '診所權限',
			'level' => '職位權限',
		];
	}

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdminSheets()
    {
        return $this->hasMany(AdminSheet::className(), ['id' => 'build_id']);
    }

}
