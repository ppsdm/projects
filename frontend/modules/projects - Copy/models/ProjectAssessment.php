<?php

namespace app\modules\projects\models;
use common\modules\catalog\models\CatalogMeta;
use common\modules\catalog\models\Catalog;
use yii\data\SqlDataProvider;
use Yii;

/**
 * This is the model class for table "project_assessment".
 *
 * @property integer $id
 * @property integer $activity_id
 * @property integer $catalog_id
 * @property string $status
 * @property string $created_at
 * @property string $modified_at
 *
 * @property ProjectAssessmentMeta[] $projectAssessmentMetas
 * @property ProjectAssessmentResult[] $projectAssessmentResults
 */
class ProjectAssessment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project_assessment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['activity_id', 'catalog_id'], 'integer'],
            [['created_at', 'modified_at'], 'safe'],
            [['status'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'activity_id' => Yii::t('app', 'Activity ID'),
            'catalog_id' => Yii::t('app', 'Catalog ID'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'modified_at' => Yii::t('app', 'Modified At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectAssessmentMetas()
    {
        return $this->hasMany(ProjectAssessmentMeta::className(), ['project_assessment_id' => 'id']);
    }


    public function getCatalog()
    {
 return $this->hasOne(Catalog::className(), ['id' => 'catalog_id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectAssessmentResults()
    {
        return $this->hasMany(ProjectAssessmentResult::className(), ['project_assessment_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return ProjectAssessmentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProjectAssessmentQuery(get_called_class());
    }
}
