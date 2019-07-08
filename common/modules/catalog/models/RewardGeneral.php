<?php

namespace common\modules\catalog\models;

use Yii;

/**
 * This is the model class for table "reward_general".
 *
 * @property integer $id
 * @property string $name
 * @property string $reward_type
 * @property integer $reward_point
 * @property integer $reward_limit
 * @property string $note
 * @property string $status
 */
class RewardGeneral extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reward_general';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['reward_point', 'reward_limit'], 'integer'],
            [['note'], 'string'],
            [['name', 'reward_type', 'status'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'reward_type' => Yii::t('app', 'Reward Type'),
            'reward_point' => Yii::t('app', 'Reward Point'),
            'reward_limit' => Yii::t('app', 'Reward Limit'),
            'note' => Yii::t('app', 'Note'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @inheritdoc
     * @return RewardGeneralQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RewardGeneralQuery(get_called_class());
    }

    public function giveReward($userid, $rewardid)
    {
        return $rewardid;
    }


}
