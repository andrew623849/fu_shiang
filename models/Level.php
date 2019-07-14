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
 *
 * @property AdminSheet[] $adminSheets
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
            [['id', 'job_name', 'build_time', 'build_id', 'useable'], 'required'],
            [['id', 'build_id', 'useable'], 'integer'],
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
            'job_name' => 'Job Name',
            'build_time' => 'Build Time',
            'build_id' => 'Build ID',
            'useable' => 'Useable',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdminSheets()
    {
        return $this->hasMany(AdminSheet::className(), ['job' => 'id']);
    }
}
