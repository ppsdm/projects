<?php

namespace app\modules\cats\models;

/**
 * This is the ActiveQuery class for [[JobExtNote]].
 *
 * @see JobExtNote
 */
class JobExtNoteQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return JobExtNote[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return JobExtNote|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
