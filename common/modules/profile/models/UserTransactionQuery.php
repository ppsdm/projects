<?php

namespace common\modules\profile\models;

/**
 * This is the ActiveQuery class for [[UserTransaction]].
 *
 * @see UserTransaction
 */
class UserTransactionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return UserTransaction[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return UserTransaction|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
