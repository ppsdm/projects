<?php

namespace common\modules\catalog\models;

/**
 * This is the ActiveQuery class for [[Catalog]].
 *
 * @see Catalog
 */
class CatalogQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Catalog[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Catalog|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
