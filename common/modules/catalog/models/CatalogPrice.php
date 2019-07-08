<?php

namespace common\modules\catalog\models;

use Yii;

/**
 * This is the model class for table "catalog_price".
 *
 * @property integer $catalog_id
 * @property string $required_point
 * @property string $credit_type
 * @property string $price_info
 *
 * @property CatalogGeneral $catalog
 */
class CatalogPrice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_price';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['catalog_id', 'credit_type'], 'required'],
            [['catalog_id'], 'integer'],
            [['price_info'], 'string'],
            [['required_point', 'credit_type'], 'string', 'max' => 255],
            [['catalog_id'], 'exist', 'skipOnError' => true, 'targetClass' => CatalogGeneral::className(), 'targetAttribute' => ['catalog_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'catalog_id' => Yii::t('app', 'Catalog ID'),
            'required_point' => Yii::t('app', 'Required Point'),
            'credit_type' => Yii::t('app', 'Credit Type'),
            'price_info' => Yii::t('app', 'Price Info'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalog()
    {
        return $this->hasOne(CatalogGeneral::className(), ['id' => 'catalog_id']);
    }

    /**
     * @inheritdoc
     * @return CatalogPriceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CatalogPriceQuery(get_called_class());
    }
}
