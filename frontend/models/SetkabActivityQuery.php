<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[SetkabActivity]].
 *
 * @see SetkabActivity
 */
class SetkabActivityQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return SetkabActivity[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SetkabActivity|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
