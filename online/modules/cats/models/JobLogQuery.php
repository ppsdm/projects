<?php

namespace app\modules\cats\models;

/**
 * This is the ActiveQuery class for [[JobLog]].
 *
 * @see JobLog
 */
class JobLogQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return JobLog[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return JobLog|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
