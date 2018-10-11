<?php

namespace app\modules\projects\models;

/**
 * This is the ActiveQuery class for [[ProjectActivity]].
 *
 * @see ProjectActivity
 */
class ProjectActivityQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ProjectActivity[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ProjectActivity|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
