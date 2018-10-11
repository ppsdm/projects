<?php

namespace app\modules\projects\models;

/**
 * This is the ActiveQuery class for [[ProjectMeta]].
 *
 * @see ProjectMeta
 */
class ProjectMetaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ProjectMeta[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ProjectMeta|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
