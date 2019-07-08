<?php

namespace common\modules\catalog\models;

use Yii;

/**
 * This is the model class for table "catalog_meta".
 *
 * @property integer $catalog_id
 * @property string $type
 * @property string $key
 * @property string $value
 * @property string $attribute_1
 * @property string $attribute_2
 * @property string $attribute_3
 *
 * @property Catalog $catalog
 */
class CatalogMeta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_meta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['catalog_id', 'type', 'key', 'value'], 'required'],
            [['catalog_id'], 'integer'],
            [['type', 'key', 'value', 'attribute_1', 'attribute_2', 'attribute_3'], 'string', 'max' => 255],
            [['catalog_id'], 'exist', 'skipOnError' => true, 'targetClass' => Catalog::className(), 'targetAttribute' => ['catalog_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'catalog_id' => Yii::t('app', 'Catalog ID'),
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
    public function getCatalog()
    {
        return $this->hasOne(Catalog::className(), ['id' => 'catalog_id']);
    }

    /**
     * @inheritdoc
     * @return CatalogMetaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CatalogMetaQuery(get_called_class());
    }
}
