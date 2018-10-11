<?php

namespace app\modules\projects\models;

/**
 * This is the ActiveQuery class for [[ProjectAssessmentMeta]].
 *
 * @see ProjectAssessmentMeta
 */
class ProjectAssessmentMetaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ProjectAssessmentMeta[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ProjectAssessmentMeta|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
