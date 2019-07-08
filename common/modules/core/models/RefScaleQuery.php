<?php

namespace common\modules\core\models;

/**
 * This is the ActiveQuery class for [[RefScale]].
 *
 * @see RefScale
 */
class RefScaleQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return RefScale[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return RefScale|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
