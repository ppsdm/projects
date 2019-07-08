<?php

namespace common\modules\core\models;


use Yii;

/**
 * This is the model class for table "ref_config".
 *
 * @property string $type
 * @property string $key
 * @property string $value
 */
class RefConfig extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'key'], 'required'],
            [['type', 'key', 'value'], 'string', 'max' => 255],
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
        ];
    }

    /**
     * @inheritdoc
     * @return RefConfigQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RefConfigQuery(get_called_class());
    }
}
