<?php

namespace common\modules\institution\models;

use Yii;

/**
 * This is the model class for table "institution_extended".
 *
 * @property string $institution_id
 * @property string $type
 * @property string $key
 * @property string $value
 * @property string $attribute_1
 * @property string $attribute_2
 * @property string $attribute_3
 *
 * @property Institution $institution
 */
class InstitutionExtended extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'institution_extended';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['institution_id', 'type', 'key'], 'required'],
            [['institution_id'], 'integer'],
            [['value'], 'string'],
            [['type', 'key', 'attribute_1', 'attribute_2', 'attribute_3'], 'string', 'max' => 255],
            [['institution_id'], 'exist', 'skipOnError' => true, 'targetClass' => Institution::className(), 'targetAttribute' => ['institution_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'institution_id' => Yii::t('app', 'Institution ID'),
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
    public function getInstitution()
    {
        return $this->hasOne(Institution::className(), ['id' => 'institution_id']);
    }

    /**
     * @inheritdoc
     * @return InstitutionExtendedQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new InstitutionExtendedQuery(get_called_class());
    }
}
