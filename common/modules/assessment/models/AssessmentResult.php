<?php

namespace common\modules\assessment\models;


use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use Yii;


/**
 * This is the model class for table "assessment_result".
 *
 * @property string $id
 * @property integer $assessment_id
 * @property string $testtaker_id
 * @property string $delivery_id
 * @property string $result_id
 * @property string $result_json
 * @property string $score_string
 * @property double $score_double
 * @property string $timestamp
 */
class AssessmentResult extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'assessment_result';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['assessment_id'], 'integer'],
            [['result_json', 'score_string'], 'string'],
            [['score_double'], 'number'],
            [['timestamp'], 'safe'],
            [['testtaker_id', 'delivery_id', 'result_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'assessment_id' => Yii::t('app', 'Assessment ID'),
            'testtaker_id' => Yii::t('app', 'Testtaker ID'),
            'delivery_id' => Yii::t('app', 'Delivery ID'),
            'result_id' => Yii::t('app', 'Result ID'),
            'result_json' => Yii::t('app', 'Result Json'),
            'score_string' => Yii::t('app', 'Score String'),
            'score_double' => Yii::t('app', 'Score Double'),
            'timestamp' => Yii::t('app', 'Timestamp'),
        ];
    }

    /**
     * @inheritdoc
     * @return AssessmentResultQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AssessmentResultQuery(get_called_class());
    }

    public function behaviors()
    {
        return [

        [
        'class' => TimestampBehavior::className(),
        'attributes'=>[
            ActiveRecord::EVENT_BEFORE_INSERT => ['timestamp'], ActiveRecord::EVENT_BEFORE_UPDATE => ['timestamp'],
            ],
            'value' => new Expression('NOW()'),],

        ];

        }

}
