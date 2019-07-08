<?php

namespace common\modules\profile\models;

/**
 * This is the ActiveQuery class for [[UserCredit]].
 *
 * @see UserCredit
 */
class UserCreditQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return UserCredit[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return UserCredit|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
