<?php

namespace app\modules\projects\models;

use Yii;

/**
 * This is the model class for table "project".
 *
 * @property integer $id
 * @property integer $organization_id
 * @property string $name
 * @property string $status
 *
 * @property Activity[] $activities
 * @property Assessment[] $assessments
 * @property Organization $organization
        * @property string $description
 * @property ProjectMeta[] $projectMetas
 * @property UserProjectRole[] $userProjectRoles
 */
class Project extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['organization_id'], 'integer'],
            [['description'], 'string'], 
            [['name', 'status'], 'string', 'max' => 255],
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
'description' => Yii::t('app', 'Description'),
            'name' => Yii::t('app', 'Name'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivities()
    {
        return $this->hasMany(Activity::className(), ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssessments()
    {
        return $this->hasMany(Assessment::className(), ['project_id' => 'id']);
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
    public function getProjectMetas()
    {
        return $this->hasMany(ProjectMeta::className(), ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserProjectRoles()
    {
        return $this->hasMany(UserProjectRole::className(), ['project_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return ProjectQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProjectQuery(get_called_class());
    }

  /**
    * @return \yii\db\ActiveQuery
    */
   public function getProjectActivities()
   {
       return $this->hasMany(ProjectActivity::className(), ['project_id' => 'id']);
   }
   /**
    * @return \yii\db\ActiveQuery
    */
   public function getProjectAssessments()
   {
       return $this->hasMany(ProjectAssessment::className(), ['project_id' => 'id']);
   }



}
