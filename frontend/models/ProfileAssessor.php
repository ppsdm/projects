<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "profile_assessor".
 *
 * @property integer $id
 * @property string $assesse_name
 * @property string $assessor_name
 */
class ProfileAssessor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile_assessor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['assesse_name', 'assessor_name'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'assesse_name' => 'Assesse Name',
            'assessor_name' => 'Assessor Name',
        ];
    }
}
