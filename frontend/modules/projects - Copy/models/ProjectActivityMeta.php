<?php

namespace app\modules\projects\models;
use app\modules\profile\models\Profile;

use Yii;

/**
 * This is the model class for table "project_activity_meta".
 *
 * @property integer $project_activity_id
 * @property string $type
 * @property string $key
 * @property string $value
 * @property string $attribute_1
 * @property string $attribute_2
 * @property string $attribute_3
 *
 * @property ProjectActivity $projectActivity
 */
class ProjectActivityMeta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project_activity_meta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_activity_id', 'type', 'key', 'value'], 'required'],
            [['project_activity_id'], 'integer'],
            [['type', 'key', 'value', 'attribute_1', 'attribute_2', 'attribute_3'], 'string', 'max' => 255],
            [['project_activity_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProjectActivity::className(), 'targetAttribute' => ['project_activity_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'project_activity_id' => Yii::t('app', 'Project Activity ID'),
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
    public function getProjectActivity()
    {
        return $this->hasOne(ProjectActivity::className(), ['id' => 'project_activity_id']);
    }

    public function getAssessor()
    {
        return $this->hasOne(Profile::className(), ['id' => 'value']);
    }

    /**
     * @inheritdoc
     * @return ProjectActivityMetaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProjectActivityMetaQuery(get_called_class());
    }
}
