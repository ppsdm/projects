<?php

namespace common\modules\core\models;

use Yii;

/**
 * This is the model class for table "rawscan_meta".
 *
 * @property integer $rawscan_id
 * @property string $type
 * @property string $key
 * @property string $value
 * @property string $attribute_1
 * @property string $attribute_2
 * @property string $attribute_3
 *
 * @property Rawscan $rawscan
 */
class RawscanMeta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rawscan_meta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rawscan_id', 'type', 'key', 'value'], 'required'],
            [['rawscan_id'], 'integer'],
            [['type', 'key', 'value', 'attribute_1', 'attribute_2', 'attribute_3'], 'string', 'max' => 255],
            [['rawscan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rawscan::className(), 'targetAttribute' => ['rawscan_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rawscan_id' => Yii::t('app', 'Rawscan ID'),
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
    public function getRawscan()
    {
        return $this->hasOne(Rawscan::className(), ['id' => 'rawscan_id']);
    }

    /**
     * @inheritdoc
     * @return RawscanMetaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RawscanMetaQuery(get_called_class());
    }
}
