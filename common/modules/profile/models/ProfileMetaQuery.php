<?php

namespace common\modules\profile\models;

/**
 * This is the ActiveQuery class for [[ProfileMeta]].
 *
 * @see ProfileMeta
 */
class ProfileMetaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ProfileMeta[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ProfileMeta|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
