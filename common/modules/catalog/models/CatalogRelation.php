<?php

namespace common\modules\catalog\models;

use Yii;

/**
 * This is the model class for table "catalog_relation".
 *
 * @property integer $index
 * @property string $subject
 * @property string $predicate
 * @property string $object
 */
class CatalogRelation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_relation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['subject', 'predicate', 'object'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'index' => Yii::t('app', 'Index'),
            'subject' => Yii::t('app', 'Subject'),
            'predicate' => Yii::t('app', 'Predicate'),
            'object' => Yii::t('app', 'Object'),
        ];
    }

    /**
     * @inheritdoc
     * @return CatalogRelationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CatalogRelationQuery(get_called_class());
    }
}
