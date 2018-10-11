<?php

namespace app\modules\projects\controllers;

class AssessmentController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionDebug($id)
    {
    	return $this->render('debug');
    }

    public function actionPrintreport($id)
    {

    }

    public function actionPrintblankreport($id)
    {
    	
    }

    public function actionPrintdisc($id)
    {

    }

    public function actionPrintprestatif($id)
    {

    }


}
