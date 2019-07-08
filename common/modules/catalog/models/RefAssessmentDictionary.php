<?php

namespace common\modules\catalog\models;

use Yii;

/**
 * This is the model class for table "ref_assessment_dictionary".
 *
 * @property string $type
 * @property string $key
 * @property string $value
 * @property string $textvalue
 * @property string $attribute_1
 * @property string $attribute_2
 * @property string $attribute_3
 */
class RefAssessmentDictionary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_assessment_dictionary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'key', 'value'], 'required'],
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
     * @return RefAssessmentDictionaryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RefAssessmentDictionaryQuery(get_called_class());
    }
}
