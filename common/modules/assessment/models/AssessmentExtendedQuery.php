<?php

namespace common\modules\assessment\models;

/**
 * This is the ActiveQuery class for [[AssessmentExtended]].
 *
 * @see AssessmentExtended
 */
class AssessmentExtendedQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return AssessmentExtended[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return AssessmentExtended|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
