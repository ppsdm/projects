<?php

namespace app\modules\cats\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "job_candidate".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $job_id
 * @property string $status
 *
 * @property JobCatalog $job
 * @property User $user
 * @property JobLog[] $jobLogs
 */
class JobCandidate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'job_candidate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'job_id'], 'integer'],
            [['status'], 'string', 'max' => 255],
            [['job_id'], 'exist', 'skipOnError' => true, 'targetClass' => JobCatalog::className(), 'targetAttribute' => ['job_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'job_id' => Yii::t('app', 'Job ID'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJob()
    {
        return $this->hasOne(JobCatalog::className(), ['id' => 'job_id']);
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
    public function getJobLogs()
    {
        return $this->hasMany(JobLog::className(), ['candidate_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return JobCandidateQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new JobCandidateQuery(get_called_class());
    }
}
