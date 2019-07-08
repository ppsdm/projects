<?php

namespace app\modules\cats\models;

use Yii;

/**
 * This is the model class for table "job_log".
 *
 * @property string $id
 * @property integer $candidate_id
 * @property integer $admin_id
 * @property string $type
 * @property string $value
 * @property string $datetime
 *
 * @property JobCandidate $candidate
 */
class JobLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'job_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['candidate_id', 'admin_id'], 'integer'],
            [['datetime'], 'safe'],
            [['type', 'value'], 'string', 'max' => 255],
            [['candidate_id'], 'exist', 'skipOnError' => true, 'targetClass' => JobCandidate::className(), 'targetAttribute' => ['candidate_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'candidate_id' => Yii::t('app', 'Candidate ID'),
            'admin_id' => Yii::t('app', 'Admin ID'),
            'type' => Yii::t('app', 'Type'),
            'value' => Yii::t('app', 'Value'),
            'datetime' => Yii::t('app', 'Datetime'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCandidate()
    {
        return $this->hasOne(JobCandidate::className(), ['id' => 'candidate_id']);
    }

    /**
     * @inheritdoc
     * @return JobLogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new JobLogQuery(get_called_class());
    }
}
