<?php

namespace common\modules\core\models;

use Yii;

/**
 * This is the model class for table "email_verification".
 *
 * @property integer $user_id
 * @property string $email
 * @property string $verification_string
 * @property string $status
 * @property string $created_at
 * @property string $modified_at
 */
class EmailVerification extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'email_verification';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'email'], 'required'],
            [['user_id'], 'integer'],
            [['created_at', 'modified_at'], 'safe'],
            [['email', 'verification_string', 'status'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('app', 'User ID'),
            'email' => Yii::t('app', 'Email'),
            'verification_string' => Yii::t('app', 'Verification String'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'modified_at' => Yii::t('app', 'Modified At'),
        ];
    }

    /**
     * @inheritdoc
     * @return EmailVerificationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EmailVerificationQuery(get_called_class());
    }
}
