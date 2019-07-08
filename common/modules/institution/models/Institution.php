<?php

namespace common\modules\institution\models;

use Yii;

/**
 * This is the model class for table "institution".
 *
 * @property string $id
 * @property string $type
 * @property string $name
 * @property string $attribute_1
 * @property string $attribute_2
 * @property string $attribute_3
 *
 * @property InstitutionExtended[] $institutionExtendeds
 */
class Institution extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'institution';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'name', 'attribute_1', 'attribute_2', 'attribute_3'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', 'Type'),
            'name' => Yii::t('app', 'Name'),
            'attribute_1' => Yii::t('app', 'Attribute 1'),
            'attribute_2' => Yii::t('app', 'Attribute 2'),
            'attribute_3' => Yii::t('app', 'Attribute 3'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstitutionExtendeds()
    {
        return $this->hasMany(InstitutionExtended::className(), ['institution_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return InstitutionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new InstitutionQuery(get_called_class());
    }
}
