<?php

namespace common\modules\catalog\models;

/**
 * This is the ActiveQuery class for [[CatalogTransaction]].
 *
 * @see CatalogTransaction
 */
class CatalogTransactionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return CatalogTransaction[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CatalogTransaction|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
