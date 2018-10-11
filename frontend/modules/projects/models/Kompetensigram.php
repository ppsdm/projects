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
class Kompetensigram extends \app\modules\projects\models\ProjectAssessmentResult
{

    //public $uraian;



    /**
     * @inheritdoc
     */
    public function rules()
    {


        return [
            [['project_assessment_id'], 'integer'],
            //[['textvalue'], 'string'],
                 ['textvalue', 'string', 'min' => 0],
/*['textvalue', 'validatePanjanguraian', 'when' => function ($model) {
    return strlen($model->textvalue) > 0;
}],
*/
            [['type', 'key', 'value', 'attribute_1', 'attribute_2'], 'string', 'max' => 255],
            [['attribute_3'], 'string', 'max' => 2455],
            [['project_assessment_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProjectAssessment::className(), 'targetAttribute' => ['project_assessment_id' => 'id']],
        ];

    }

public function validatePanjanguraian($attribute, $params)
{

        $this->addError('textvalue', 'Panjang uraian masih kurang');
    
}


}
