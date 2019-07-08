<?php

namespace common\modules\core\models;

use Yii;

/**
 * This is the model class for table "rawscan".
 *
 * @property integer $id
 * @property integer $file_id
 * @property string $data
 * @property string $create_at
 * @property string $modified_at
 *
 * @property RawscanMeta[] $rawscanMetas
 */
class Rawscan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rawscan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file_id'], 'integer'],
            [['data'], 'string'],
            [['create_at', 'modified_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'file_id' => Yii::t('app', 'File ID'),
            'data' => Yii::t('app', 'Data'),
            'create_at' => Yii::t('app', 'Create At'),
            'modified_at' => Yii::t('app', 'Modified At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRawscanMetas()
    {
        return $this->hasMany(RawscanMeta::className(), ['rawscan_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return RawscanQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RawscanQuery(get_called_class());
    }
}
