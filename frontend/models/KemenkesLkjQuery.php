<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[KemenkesLkj]].
 *
 * @see KemenkesLkj
 */
class KemenkesLkjQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return KemenkesLkj[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return KemenkesLkj|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
