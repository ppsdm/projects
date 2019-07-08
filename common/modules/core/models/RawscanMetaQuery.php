<?php

namespace common\modules\core\models;

/**
 * This is the ActiveQuery class for [[RawscanMeta]].
 *
 * @see RawscanMeta
 */
class RawscanMetaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return RawscanMeta[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return RawscanMeta|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
