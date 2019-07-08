<?php

namespace common\modules\assessment\models;

    use common\modules\catalog\models\CatalogGeneral;
    use common\modules\assessment\models\Result;
        use common\modules\profile\models\ProfileGeneral;
    use common\modules\assessment\models\AssessmentResult;
use common\models\User;
use Yii;

/**
 * This is the model class for table "assessment".
 *
 * @property string $id
 * @property integer $user_id
 * @property integer $catalog_id
 * @property string $result_uri
 * @property string $result
 * @property string $status
 * @property string $timestamp
 *
 * @property CatalogGeneral $catalog
 * @property User $user
 */
class Assessment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'assessment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'catalog_id'], 'integer'],
            [['result'], 'string'],
            [['timestamp'], 'safe'],
            [['result_uri', 'status'], 'string', 'max' => 255],
            [['catalog_id'], 'exist', 'skipOnError' => true, 'targetClass' => CatalogGeneral::className(), 'targetAttribute' => ['catalog_id' => 'id']],
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
            'catalog_id' => Yii::t('app', 'Catalog ID'),
            'result_uri' => Yii::t('app', 'Result Uri'),
            'result' => Yii::t('app', 'Result'),
            'status' => Yii::t('app', 'Status'),
            'timestamp' => Yii::t('app', 'Timestamp'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalog()
    {
        return $this->hasOne(CatalogGeneral::className(), ['id' => 'catalog_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getProfile()
    {
        return $this->hasOne(ProfileGeneral::className(), ['user_id' => 'user_id']);
    }


    public function getResultsum()
    {
      return $this->hasMany(Result::className(), ['assessment_id' => 'id'])->andWhere(['attribute_1'=>'correct'])->sum('value');
    }


    public function getResults()
    {
        return $this->hasMany(Result::className(), ['assessment_id' => 'id']);
    }

    public function getAssessmentresults()
    {
        return $this->hasOne(AssessmentResult::className(), ['assessment_id' => 'id']);
    }



    /**
     * @inheritdoc
     * @return AssessmentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AssessmentQuery(get_called_class());
    }
}
