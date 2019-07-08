<?php

namespace app\modules\learn\controllers;

use common\modules\profile\models\ProfileGeneral;
use common\modules\profile\models\ProfileExtended;
use Yii;

use common\modules\ref\models\Log;
use common\models\ImageUpload;
use yii\db\Expression;
use yii\helpers\Url;
use yii\web\UploadedFile;

use common\models\LoginForm;
use common\models\SignupForm;

class LearnController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSignup()
    {
    	 $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {

            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {


            $type = 'cats';
            //$add_user_result = true;
             $add_user_result = Yii::$app->runAction('tao/adduser', ['userid' => $user->id, 'password' => $model->password, 'type' => $type]);


			if($add_user_result) {
			 //Yii::$app->session->setFlash('danger', 'YES');
			    return $this->redirect('index');
			} else {
			                           Yii::$app->session->setFlash('danger', 'User is created but not registered to TAO');
			}

			                }
			            }


			        }

			        return $this->render('signup', [
			            'model' => $model,
			        ]);
	}


	public function actionLoginpop()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {

            if($model->login()) {
                        return $this->redirect('index');

            } else {
                        return $this->render('loginpop', [
                'model' => $model,
            ]);
        }


        }
            return $this->renderPartial('loginpop', [
                'model' => $model,
            ]);
    }

    public function actionMateri()
    {
      return $this->render('materi');
    }

    public function actionSoal()
    {
      return $this->render('soal');
    }

    public function actionVideo()
    {
      return $this->render('video');
    }

    public function actionTryout()
    {
      return $this->render('tryout');
    }


}
