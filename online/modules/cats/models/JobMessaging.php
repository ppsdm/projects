<?php

namespace app\modules\cats\models;

use Yii;

/**
 * This is the model class for table "job_messaging".
 *
 * @property string $id
 * @property integer $job_candidate_id
 * @property string $direction
 * @property string $message
 * @property string $datetime
 *
 * @property JobCandidate $jobCandidate
 */
class JobMessaging extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'job_messaging';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'job_candidate_id'], 'integer'],
            [['message'], 'string'],
            [['datetime'], 'safe'],
            [['direction'], 'string', 'max' => 10],
            [['job_candidate_id'], 'exist', 'skipOnError' => true, 'targetClass' => JobCandidate::className(), 'targetAttribute' => ['job_candidate_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'job_candidate_id' => Yii::t('app', 'Job Candidate ID'),
            'direction' => Yii::t('app', 'Direction'),
            'message' => Yii::t('app', 'Message'),
            'datetime' => Yii::t('app', 'Datetime'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobCandidate()
    {
        return $this->hasOne(JobCandidate::className(), ['id' => 'job_candidate_id']);
    }

    /**
     * @inheritdoc
     * @return JobMessagingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new JobMessagingQuery(get_called_class());
    }
}
