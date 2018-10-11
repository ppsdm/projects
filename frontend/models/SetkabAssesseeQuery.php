<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[SetkabAssessee]].
 *
 * @see SetkabAssessee
 */
class SetkabAssesseeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return SetkabAssessee[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SetkabAssessee|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
