<?php

namespace common\modules\core\models;

/**
 * This is the ActiveQuery class for [[RefValue]].
 *
 * @see RefValue
 */
class RefValueQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return RefValue[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return RefValue|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
