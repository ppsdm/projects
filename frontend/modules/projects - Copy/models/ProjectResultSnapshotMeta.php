<?php

namespace app\modules\projects\models;

use Yii;

/**
 * This is the model class for table "project_result_snapshot_meta".
 *
 * @property string $id
 * @property integer $project_result_snapshot_id
 * @property string $type
 * @property string $key
 * @property string $value
 * @property string $textvalue
 * @property string $attribute_1
 * @property string $attribute_2
 * @property string $attribute_3
 */
class ProjectResultSnapshotMeta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project_result_snapshot_meta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_result_snapshot_id'], 'integer'],
            [['textvalue'], 'string'],
            [['type', 'key', 'value', 'attribute_1', 'attribute_2', 'attribute_3'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'project_result_snapshot_id' => Yii::t('app', 'Project Result Snapshot ID'),
            'type' => Yii::t('app', 'Type'),
            'key' => Yii::t('app', 'Key'),
            'value' => Yii::t('app', 'Value'),
            'textvalue' => Yii::t('app', 'Textvalue'),
            'attribute_1' => Yii::t('app', 'Attribute 1'),
            'attribute_2' => Yii::t('app', 'Attribute 2'),
            'attribute_3' => Yii::t('app', 'Attribute 3'),
        ];
    }

    /**
     * @inheritdoc
     * @return ProjectResultSnapshotMetaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProjectResultSnapshotMetaQuery(get_called_class());
    }
}
