<?php

namespace app\modules\edulab\materi\controllers;

class MateriController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionMateri()
    {
      echo "materi";
    }

}
