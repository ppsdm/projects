<?php

namespace app\modules\projects\models;
use common\modules\profile\models\ProfileMeta;
use common\modules\profile\models\Profile;
use Yii;

/**
 * This is the model class for table "project_activity".
 *
 * @property integer $id
 * @property integer $project_id
 * @property string $name
 * @property string $status
 * @property string $created_at
 * @property string $modified_at
 *
 * @property Project $project
 * @property ProjectActivityMeta[] $projectActivityMetas
 */
class ProjectActivity extends \yii\db\ActiveRecord
{

            public $assessor;
            public $assessors;
            public $so;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project_activity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id'], 'integer'],
            [['created_at', 'modified_at'], 'safe'],
  [['assessor', 'assessors','so'], 'safe'],
            [['name', 'status'], 'string', 'max' => 255],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'project_id' => Yii::t('app', 'Project ID'),
            'name' => Yii::t('app', 'Name'),
            'assessor' => Yii::t('app', 'Assessor'),
            'assessors' => Yii::t('app', 'Assessors'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'modified_at' => Yii::t('app', 'Modified At'),
        ];
    }


    public function init()
    {

    }

    public function afterFind()
    {
            parent::afterFind();
            $assessor = ProjectActivityMeta::find()
            ->andWhere(['project_activity_id' => $this->id])
            ->andWhere(['key' => 'assessor'])
->andWhere(['!=','value','2'])->One()
;
            //$this->assessors = $this->getAssessors();
if(isset($assessor->value)) {
$assessorprofile = Profile::findOne($assessor->value);
$fn = isset($assessorprofile->first_name)? $assessorprofile->first_name : '';
$ln = isset($assessorprofile->last_name) ? $assessorprofile->last_name : '';
$this->assessor =  $fn . ' ' . $ln;
} else {
     $this->assessor = '';
}
        
       
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectActivityMetas()
    {
        return $this->hasMany(ProjectActivityMeta::className(), ['project_activity_id' => 'id']);
    }


    public function getAssessor()
    {

return $this->hasOne(ProjectActivityMeta::className(), ['project_activity_id' => 'id'])
->andWhere(['key' => 'assessor'])
->andWhere(['!=','value','2'])
;
//return $this->assessor;

    }
    public function getAssessors()
    {


$this->assessors = $this->hasMany(ProjectActivityMeta::className(), ['project_activity_id' => 'id'])
->andWhere(['key' => 'assessor']);
return $this->assessors;
    }

    /**
     * @inheritdoc
     * @return ProjectActivityQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProjectActivityQuery(get_called_class());
    }
}
