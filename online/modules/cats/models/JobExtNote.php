<?php

namespace app\modules\cats\models;

use Yii;
use app\models\Organization;
use common\models\User;

/**
 * This is the model class for table "job_ext_note".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $organization_id
 * @property integer $admin_id
 * @property string $type
 * @property string $notes
 * @property string $datetime
 *
 * @property Organization $organization
 * @property User $user
 * @property User $admin
 */
class JobExtNote extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'job_ext_note';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'organization_id', 'admin_id'], 'integer'],
            [['notes'], 'string'],
            [['datetime'], 'safe'],
            [['type'], 'string', 'max' => 255],
            [['organization_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organization::className(), 'targetAttribute' => ['organization_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['admin_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['admin_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'organization_id' => Yii::t('app', 'Organization ID'),
            'admin_id' => Yii::t('app', 'Admin ID'),
            'type' => Yii::t('app', 'Type'),
            'notes' => Yii::t('app', 'Notes'),
            'datetime' => Yii::t('app', 'Datetime'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganization()
    {
        return $this->hasOne(Organization::className(), ['id' => 'organization_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdmin()
    {
        return $this->hasOne(User::className(), ['id' => 'admin_id']);
    }

    /**
     * @inheritdoc
     * @return JobExtNoteQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new JobExtNoteQuery(get_called_class());
    }
}
