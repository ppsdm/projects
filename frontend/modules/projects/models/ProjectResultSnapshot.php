<?php

namespace app\modules\projects\models;

use Yii;

/**
 * This is the model class for table "project_result_snapshot".
 *
 * @property integer $id
 * @property integer $project_assessment_id
 * @property string $snapshot_type
 * @property string $created_at
 */
class ProjectResultSnapshot extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project_result_snapshot';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_assessment_id'], 'integer'],
            [['created_at'], 'safe'],
            [['snapshot_type'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'project_assessment_id' => Yii::t('app', 'Project Assessment ID'),
            'snapshot_type' => Yii::t('app', 'Snapshot Type'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * @inheritdoc
     * @return ProjectResultSnapshotQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProjectResultSnapshotQuery(get_called_class());
    }
}
