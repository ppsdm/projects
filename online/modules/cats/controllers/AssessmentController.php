<?php

namespace app\modules\cats\controllers;
use Yii;
use common\modules\tao\models\TaoUriMap;

class AssessmentController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionView($id)
    {


$taouser = TaoUriMap::find()->andWhere(['type' => 'user'])->andWhere(['id'=>Yii::$app->user->id])->One();
    
              if (isset($taouser->uri)) {

             $add_group_result = Yii::$app->runAction('tao/addtogroup', ['userid' => Yii::$app->user->id, 'groupid' => $id]);
             if($add_group_result)
             {

             return $this->render('view');
            } else {
                echo 'no user OR group uri';
            }
         } else {

            echo 'no tao user uri';
         }
    }

    public function actionResult($id)
    {
        echo 'result for ' . $id;
    }


}
