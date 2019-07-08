<?php

namespace common\config;

use Yii;
use yii\base\BootstrapInterface;

use common\modules\core\models\RefConfig;

/*
/* The base class that you use to retrieve the settings from the database
*/

class settings implements BootstrapInterface {

    private $db;

    public function __construct() {
        $this->db = Yii::$app->db;
    }

    /**
    * Bootstrap method to be called during application bootstrap stage.
    * Loads all the settings into the Yii::$app->params array
    * @param Application $app the application currently running
    */

    public function bootstrap($app) {
        $tao_root = RefConfig::find()->andWhere(['type' => 'tao_config'])->andWhere(['key'=>'tao_root'])->One();
                $tao_testtaker_root = RefConfig::find()->andWhere(['type' => 'tao_config'])->andWhere(['key'=>'tao_testtaker_root'])->One();
        $pao_home = RefConfig::find()->andWhere(['type' => 'tao_config'])->andWhere(['key'=>'pao_home'])->One();
                $tao_delivery_returnurl = RefConfig::find()->andWhere(['type' => 'tao_config'])->andWhere(['key'=>'tao_delivery_returnurl'])->One();
  $tao_delivery_finishurl = RefConfig::find()->andWhere(['type' => 'tao_config'])->andWhere(['key'=>'tao_delivery_finishurl'])->One();


            if (isset($tao_root->value)) {
                Yii::$app->params['TAO_ROOT'] = $tao_root->value;
            } else {
                Yii::$app->params['TAO_ROOT'] = 'na';
            }
            if (isset($tao_testtaker_root->value)) {
                Yii::$app->params['TESTTAKER_ROOT'] = $tao_testtaker_root->value;
            } else {
                Yii::$app->params['TESTTAKER_ROOT'] = 'na';
            }
            if (isset($pao_home->value)) {
                Yii::$app->params['PAO_HOME'] = $pao_home->value;
            } else {
                Yii::$app->params['PAO_HOME'] = 'na';
            }
            if (isset($tao_delivery_finishurl->value)) {
                Yii::$app->params['TAO_DELIVERY_FINISHURL'] = $tao_delivery_finishurl->value;
            } else {
                Yii::$app->params['TAO_DELIVERY_FINISHURL'] = 'na';
            }
            if (isset($tao_delivery_returnurl->value)) {
                Yii::$app->params['TAO_DELIVERY_RETURNURL'] = $tao_delivery_returnurl->value;
            } else {
                Yii::$app->params['TAO_DELIVERY_RETURNURL'] = 'na';
            }



    }

}

?>