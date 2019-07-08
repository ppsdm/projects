<?php

namespace common\modules\profile\models;

use Yii;
use common\models\User as User;

/**
 * This is the model class for table "user_credit".
 *
 * @property integer $user_id
 * @property string $credit_type
 * @property integer $credit_point
 * @property string $status
 *
 * @property User $user
 */
class UserCredit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_credit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'credit_type', 'status'], 'required'],
            [['user_id', 'credit_point'], 'integer'],
            [['credit_type', 'status'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('app', 'User ID'),
            'credit_type' => Yii::t('app', 'Credit Type'),
            'credit_point' => Yii::t('app', 'Credit Point'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }


    public function deductCredit($user_id, $amount){

    }


    public function addCredit($user_id, $amount)
    {

    }

    /**
     * @inheritdoc
     * @return UserCreditQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserCreditQuery(get_called_class());
    }
}
