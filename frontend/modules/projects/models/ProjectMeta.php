<?php

namespace app\modules\projects\models;

use Yii;

/**
 * This is the model class for table "project_meta".
 *
 * @property integer $project_id
 * @property string $type
 * @property string $key
 * @property string $value
 * @property string $attribute_1
 * @property string $attribute_2
 * @property string $attribute_3
 *
 * @property Project $project
 */
class ProjectMeta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project_meta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id', 'type', 'key', 'value'], 'required'],
            [['project_id'], 'integer'],
            [['type', 'key', 'value', 'attribute_1', 'attribute_2', 'attribute_3'], 'string', 'max' => 255],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'project_id' => Yii::t('app', 'Project ID'),
            'type' => Yii::t('app', 'Type'),
            'key' => Yii::t('app', 'Key'),
            'value' => Yii::t('app', 'Value'),
            'attribute_1' => Yii::t('app', 'Attribute 1'),
            'attribute_2' => Yii::t('app', 'Attribute 2'),
            'attribute_3' => Yii::t('app', 'Attribute 3'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }

    /**
     * @inheritdoc
     * @return ProjectMetaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProjectMetaQuery(get_called_class());
    }
}
