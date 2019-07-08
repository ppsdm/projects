<?php

namespace app\models;


use yii\db\Expression;
use Yii;

/**
 * This is the model class for table "log".
 *
 * @property string $id
 * @property integer $user_id
 * @property string $type
 * @property string $controller
 * @property string $action
 * @property string $notes
 * @property string $timestamp
 */
class Log extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['notes'], 'string'],
            [['timestamp'], 'safe'],
            [['type', 'controller', 'action'], 'string', 'max' => 255],
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
            'type' => Yii::t('app', 'Type'),
            'controller' => Yii::t('app', 'Controller'),
            'action' => Yii::t('app', 'Action'),
            'notes' => Yii::t('app', 'Notes'),
            'timestamp' => Yii::t('app', 'Timestamp'),
        ];
    }

    /**
     * @inheritdoc
     * @return LogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LogQuery(get_called_class());
    }

    public static function add($controller, $action, $type)
    {
        $log = new Log();
        $log->user_id = Yii::$app->user->id;
$log->type = $type;
$log->controller = $controller;
$log->action = $action;
  $log->timestamp = new Expression('NOW()');
  
  $log->save();
    }

}
