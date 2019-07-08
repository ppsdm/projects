<?php

namespace common\modules\core\models;

use Yii;

/**
 * This is the model class for table "ref_relation".
 *
 * @property integer $id
 * @property string $subject
 * @property string $predicate
 * @property string $object
 * @property string $status
 * @property string $created_at
 * @property string $modified_at
 */
class RefRelation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_relation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'modified_at'], 'safe'],
            [['subject', 'predicate', 'object', 'status'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'subject' => Yii::t('app', 'Subject'),
            'predicate' => Yii::t('app', 'Predicate'),
            'object' => Yii::t('app', 'Object'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'modified_at' => Yii::t('app', 'Modified At'),
        ];
    }

    /**
     * @inheritdoc
     * @return RefRelationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RefRelationQuery(get_called_class());
    }
}
