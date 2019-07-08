<?php

namespace common\modules\tao\models;

use Yii;

/**
 * This is the model class for table "tao_uri_map".
 *
 * @property integer $id
 * @property string $type
 * @property string $uri
 */
class TaoUriMap extends \yii\db\ActiveRecord
{


    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tao_uri_map';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type'], 'required'],
            [['id'], 'integer'],
            [['uri'], 'string'],
            [['type'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', 'Type'),
            'uri' => Yii::t('app', 'Uri'),
        ];
    }

    /**
     * @inheritdoc
     * @return TaoUriMapQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaoUriMapQuery(get_called_class());
    }
}
