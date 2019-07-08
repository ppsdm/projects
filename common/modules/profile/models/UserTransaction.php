<?php

namespace common\modules\profile\models;

use Yii;
    use common\models\User as User; 
use common\modules\catalog\models\CatalogGeneral;
use common\modules\catalog\models\CatalogTransaction;
/**
 * This is the model class for table "user_transaction".
 *
 * @property string $id
 * @property integer $user_id
 * @property integer $catalog_id
 * @property string $credit_type
 * @property integer $credit_point
 * @property string $transaction_type
 * @property string $payment_type
 * @property integer $payment_amount
 * @property string $payment_info
 * @property string $payment_status
 * @property string $payment_due
 * @property string $timestamp
 *
 * @property User $user
 */
class UserTransaction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_transaction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'catalog_id', 'credit_point', 'payment_amount'], 'integer'],
            [['payment_info'], 'string'],
            [['payment_due', 'timestamp'], 'safe'],
            [['credit_type', 'transaction_type', 'payment_type', 'payment_status'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'catalog_id' => Yii::t('app', 'Catalog ID'),
            'credit_type' => Yii::t('app', 'Credit Type'),
            'credit_point' => Yii::t('app', 'Credit Point'),
            'transaction_type' => Yii::t('app', 'Transaction Type'),
            'payment_type' => Yii::t('app', 'Payment Type'),
            'payment_amount' => Yii::t('app', 'Payment Amount'),
            'payment_info' => Yii::t('app', 'Payment Info'),
            'payment_status' => Yii::t('app', 'Payment Status'),
            'payment_due' => Yii::t('app', 'Payment Due'),
            'timestamp' => Yii::t('app', 'Timestamp'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }


    public function getCatalog()
    {
        return $this->hasOne(CatalogGeneral::className(), ['id' => 'catalog_id']);
    }


    /**
     * @inheritdoc
     * @return UserTransactionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserTransactionQuery(get_called_class());
    }
}
