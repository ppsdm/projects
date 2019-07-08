<?php

namespace app\config;

use Yii;
use yii\base\BootstrapInterface;

use common\modules\ref\models\RefConfig;

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

                        Yii::$app->params['TAO_ROOT'] = $tao_root->value;
                        Yii::$app->params['TESTTAKER_ROOT'] = $tao_testtaker_root->value;
        

    }

}

?>