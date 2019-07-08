<?php

namespace common\modules\profile\controllers;
use common\models\Log;
use yii\db\Expression;
use Yii;

class CreditController extends \yii\web\Controller
{
    public function actionIndex()
    {

        echo 'this is base class for CreditController';
       // return $this->render('/credit/index');
    }

            public function beforeAction($action) {

  Log::add(Yii::$app->controller->id, $action->id,'activity');
    if (Yii::$app->session->has('lang')) {
        Yii::$app->language = Yii::$app->session->get('lang');
    } else {
        //or you may want to set lang session, this is just a sample
        //Yii::$app->language = 'us';
    }
    return parent::beforeAction($action);
}





}
