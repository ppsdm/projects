<?php

namespace common\modules\core\models;


/**
 * This is the ActiveQuery class for [[RefConfig]].
 *
 * @see RefConfig
 */
class RefConfigQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return RefConfig[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return RefConfig|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
