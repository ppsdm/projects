<?php

namespace common\modules\core\models;

use Yii;

/**
 * This is the model class for table "ref_scale".
 *
 * @property string $type
 * @property string $name
 * @property string $raw
 * @property string $scaled
 * @property string $attribute_1
 * @property string $attribute_2
 * @property string $attribute_3
 */
class RefScale extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_scale';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'name', 'raw'], 'required'],
            [['type', 'name', 'raw', 'scaled', 'attribute_1', 'attribute_2', 'attribute_3'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'type' => Yii::t('app', 'Type'),
            'name' => Yii::t('app', 'Name'),
            'raw' => Yii::t('app', 'Raw'),
            'scaled' => Yii::t('app', 'Scaled'),
            'attribute_1' => Yii::t('app', 'Attribute 1'),
            'attribute_2' => Yii::t('app', 'Attribute 2'),
            'attribute_3' => Yii::t('app', 'Attribute 3'),
        ];
    }

    /**
     * @inheritdoc
     * @return RefScaleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RefScaleQuery(get_called_class());
    }
}
