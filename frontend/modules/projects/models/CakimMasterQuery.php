<?php

namespace app\modules\projects\models;

/**
 * This is the ActiveQuery class for [[CakimMaster]].
 *
 * @see CakimMaster
 */
class CakimMasterQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return CakimMaster[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CakimMaster|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
