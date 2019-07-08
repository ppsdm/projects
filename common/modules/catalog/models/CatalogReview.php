<?php

namespace common\modules\catalog\models;

use Yii;

/**
 * This is the model class for table "catalog_review".
 *
 * @property string $id
 * @property integer $catalog_id
 * @property integer $user_id
 * @property string $review
 * @property integer $rating
 * @property string $datetime
 *
 * @property CatalogGeneral $catalog
 * @property User $user
 */
class CatalogReview extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_review';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'catalog_id', 'user_id', 'rating'], 'integer'],
            [['review'], 'string'],
            [['datetime'], 'safe'],
            [['catalog_id'], 'exist', 'skipOnError' => true, 'targetClass' => CatalogGeneral::className(), 'targetAttribute' => ['catalog_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'review' => Yii::t('app', 'Review'),
            'rating' => Yii::t('app', 'Rating'),
            'datetime' => Yii::t('app', 'Datetime'),
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
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     * @return CatalogReviewQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CatalogReviewQuery(get_called_class());
    }
}
