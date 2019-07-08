<?php

namespace common\modules\assessment\models;

use Yii;
use common\modules\assessment\models\Assessment;
/**
 * This is the model class for table "result".
 *
 * @property string $id
 * @property string $assessment_id
 * @property integer $catalog_id
 * @property string $type
 * @property string $attribute_1 
 * @property string $value
 * @property string $status
 * @property string $created_at
 */
class Result extends \yii\db\ActiveRecord
{

    public $totalscore;
        public $totalcount;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'result';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['assessment_id', 'catalog_id'], 'integer'],
            [['created_at'], 'safe'],
                   [['type', 'attribute_1', 'value', 'status'], 'string', 'max' => 255],
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
            'catalog_id' => Yii::t('app', 'Catalog ID'),
            'type' => Yii::t('app', 'Type'),
               'attribute_1' => Yii::t('app', 'Attribute 1'), 
            'value' => Yii::t('app', 'Value'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * @inheritdoc
     * @return ResultQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ResultQuery(get_called_class());
    }

    public function getAssessment()
    {
        return $this->hasOne(Assessment::className(), ['id' => 'assessment_id']);
    }


}
