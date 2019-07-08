<?php

namespace common\modules\institution\models;

/**
 * This is the ActiveQuery class for [[Institution]].
 *
 * @see Institution
 */
class InstitutionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Institution[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Institution|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
