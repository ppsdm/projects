<?php

namespace app\modules\cats\models;

use common\models\User;
use Yii;

 use app\models\Organization;

/**
 * This is the model class for table "job_catalog".
 *
 * @property integer $id
 * @property integer $organization_id
 * @property string $name
 * @property string $description
 * @property string $notes
 * @property string $open_date
 * @property string $close_date
 * @property string $url
 * @property string $status
 * @property string $datetime
 * @property string $tag
 *
 * @property JobCandidate[] $jobCandidates
 * @property Organization $organization
 */
class JobCatalog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'job_catalog';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['organization_id'], 'integer'],
            [['description', 'notes', 'tag'], 'string'],
            [['open_date', 'close_date', 'datetime'], 'safe'],
            [['name', 'url', 'status'], 'string', 'max' => 255],
            [['organization_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organization::className(), 'targetAttribute' => ['organization_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'organization_id' => Yii::t('app', 'Organization ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'notes' => Yii::t('app', 'Notes'),
            'open_date' => Yii::t('app', 'Open Date'),
            'close_date' => Yii::t('app', 'Close Date'),
            'url' => Yii::t('app', 'Url'),
            'status' => Yii::t('app', 'Status'),
            'datetime' => Yii::t('app', 'Datetime'),
            'tag' => Yii::t('app', 'Tag'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobCandidates()
    {
        return $this->hasMany(JobCandidate::className(), ['job_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganization()
    {
        return $this->hasOne(Organization::className(), ['id' => 'organization_id']);
    }

    /**
     * @inheritdoc
     * @return JobCatalogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new JobCatalogQuery(get_called_class());
    }
}
