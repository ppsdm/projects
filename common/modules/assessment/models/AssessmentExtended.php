<?php

namespace common\modules\assessment\models;

use Yii;

/**
 * This is the model class for table "assessment_extended".
 *
 * @property string $assessment_id
 * @property string $type
 * @property string $key
 * @property string $value
 * @property string $attribute_1
 * @property string $attribute_2
 * @property string $attribute_3
 *
 * @property Assessment $assessment
 */
class AssessmentExtended extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'assessment_extended';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['assessment_id', 'type', 'key'], 'required'],
            [['assessment_id'], 'integer'],
            [['value'], 'string'],
            [['type', 'key', 'attribute_1', 'attribute_2', 'attribute_3'], 'string', 'max' => 255],
            [['assessment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Assessment::className(), 'targetAttribute' => ['assessment_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'assessment_id' => Yii::t('app', 'Assessment ID'),
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
    public function getAssessment()
    {
        return $this->hasOne(Assessment::className(), ['id' => 'assessment_id']);
    }

    /**
     * @inheritdoc
     * @return AssessmentExtendedQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AssessmentExtendedQuery(get_called_class());
    }
}
