<?php

namespace common\modules\catalog\models;

use Yii;

/**
 * This is the model class for table "catalog_transaction".
 *
 * @property string $id
 * @property integer $catalog_id
 * @property integer $user_id
 * @property string $status
 * @property string $attribute_1
 * @property string $attribute_2
 * @property string $attribute_3
 * @property string $timestamp
 *
 * @property CatalogGeneral $catalog
 */
class CatalogTransaction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_transaction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['catalog_id', 'user_id'], 'integer'],
            [['timestamp'], 'safe'],
            [['status', 'attribute_1', 'attribute_2', 'attribute_3'], 'string', 'max' => 255],
            [['catalog_id'], 'exist', 'skipOnError' => true, 'targetClass' => CatalogGeneral::className(), 'targetAttribute' => ['catalog_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'catalog_id' => Yii::t('app', 'Catalog ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'status' => Yii::t('app', 'Status'),
            'attribute_1' => Yii::t('app', 'Attribute 1'),
            'attribute_2' => Yii::t('app', 'Attribute 2'),
            'attribute_3' => Yii::t('app', 'Attribute 3'),
            'timestamp' => Yii::t('app', 'Timestamp'),
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
     * @return CatalogTransactionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CatalogTransactionQuery(get_called_class());
    }
}
