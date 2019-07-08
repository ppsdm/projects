<?php

namespace app\modules\cats\models;

/**
 * This is the ActiveQuery class for [[JobCandidate]].
 *
 * @see JobCandidate
 */
class JobCandidateQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return JobCandidate[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return JobCandidate|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
