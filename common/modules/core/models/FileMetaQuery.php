<?php

namespace common\modules\core\models;

/**
 * This is the ActiveQuery class for [[FileMeta]].
 *
 * @see FileMeta
 */
class FileMetaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return FileMeta[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return FileMeta|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
