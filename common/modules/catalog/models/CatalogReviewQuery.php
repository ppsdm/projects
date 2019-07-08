<?php

namespace common\modules\catalog\models;

/**
 * This is the ActiveQuery class for [[CatalogReview]].
 *
 * @see CatalogReview
 */
class CatalogReviewQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return CatalogReview[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CatalogReview|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
