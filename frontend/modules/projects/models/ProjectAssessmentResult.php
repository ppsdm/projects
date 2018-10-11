<?php

namespace app\modules\projects\models;

use common\modules\catalog\models\CatalogMeta;
use common\modules\catalog\models\Catalog;

use yii\data\SqlDataProvider;
use Yii;

/**
 * This is the model class for table "project_assessment_result".
 *
 * @property string $id
 * @property integer $project_assessment_id
 * @property string $type
 * @property string $key
 * @property string $value
 * @property string $textvalue
 * @property string $attribute_1
 * @property string $attribute_2
 * @property string $attribute_3
 *
 * @property ProjectAssessment $projectAssessment
 */
class ProjectAssessmentResult extends \yii\db\ActiveRecord
{

    public $order;
    public $catalog_id;

        //public $catalogmeta;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project_assessment_result';
    }

    public function init()
    {
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_assessment_id'], 'integer'],
            [['textvalue'], 'string'],
                        [['order'], 'safe'],
                 //['textvalue', 'string', 'min' => 5, 'max' => 1100],
            [['type', 'key', 'value', 'attribute_1', 'attribute_2'], 'string', 'max' => 255],
            [['attribute_3'], 'string', 'max' => 2455],
            [['project_assessment_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProjectAssessment::className(), 'targetAttribute' => ['project_assessment_id' => 'id']],
   //[['assessment_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProjectAssessment::className(), 'targetAttribute' => ['project_assessment_id' => 'id']],            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'project_assessment_id' => Yii::t('app', 'Project Assessment ID'),
            'type' => Yii::t('app', 'Type'),
            'key' => Yii::t('app', 'Key'),
            'value' => Yii::t('app', 'Value'),
'order' => Yii::t('app', 'Order'),
            'textvalue' => Yii::t('app', 'Textvalue'),
            'attribute_1' => Yii::t('app', 'Attribute 1'),
            'attribute_2' => Yii::t('app', 'Attribute 2'),
            'attribute_3' => Yii::t('app', 'Attribute 3'),
        ];
    }

    // this method is called after using Video::find()
    // you can set values for your virtual attributes here for example
    public function afterFind()
    {
        parent::afterFind();

    $assessment = ProjectAssessment::findOne($this->project_assessment_id);
  /*  $cat = CatalogMeta::find()
    ->andWhere(['catalog_id' => $assessment->catalog_id])
    ->One();
*/
    //return $this->catalogmeta->attribute_3;
//return $this->type;

    $ob = CatalogMeta::find()
->andWhere(['catalog_id' => $this->projectAssessment->catalog_id])
->andWhere(['type' => $this->type])
->andWhere(['value' => $this->key])
->One();
    //$this->ordervar =  $this->projectAssessment->catalog_id . '::' . $this->type .'::' . $this->key;
    $this->order = isset($ob->attribute_3) ? $ob->attribute_3 : '0';

        //$this->ordervar = $this->projectAssessment->catalog->attribute_3;
        //$this->catalog_id = $this->catalog_id;

    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectAssessment()
    {
        return $this->hasOne(ProjectAssessment::className(), ['id' => 'project_assessment_id']);
    }

    /**
     * @inheritdoc
     * @return ProjectAssessmentResultQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProjectAssessmentResultQuery(get_called_class());
    }

/* ActiveRelation */
public function getCatalogMeta()
{
return $this->hasMany(CatalogMeta::className(), ['catalog_id' => 'catalog_id'])
 ->via('projectAssessment')
;
}





public function getCatalog()
{
        return $this->hasOne(Catalog::className(), ['catalog.id' =>'catalog_id'])
        ->via('projectAssessment')
        ;
}

public function getAssessment() {
        $assessment = ProjectAssessment::findOne($this->project_assessment_id);
    $cat = CatalogMeta::find()
    ->andWhere(['catalog_id' => $assessment->catalog_id])
    ->One();
return $assessment->catalog_id;

}









}
