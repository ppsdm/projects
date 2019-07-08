<?php

namespace common\modules\catalog\models;

/**
 * This is the ActiveQuery class for [[CatalogRelation]].
 *
 * @see CatalogRelation
 */
class CatalogRelationQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return CatalogRelation[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CatalogRelation|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
