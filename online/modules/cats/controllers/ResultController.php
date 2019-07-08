<?php

namespace app\modules\cats\controllers;

class ResultController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }


    public function actionView($id)
    {

        return $this->render('view');
    }


}
