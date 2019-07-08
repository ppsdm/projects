<?php

namespace app\modules\cats\controllers;

use common\modules\profile\models\ProfileGeneral;
use common\modules\profile\models\ProfileExtended;
use Yii;

use common\modules\ref\models\Log;
use app\models\ImageUpload;
use yii\db\Expression;
use yii\helpers\Url;
use yii\web\UploadedFile;

use common\models\LoginForm;
use app\models\SignupForm;
use app\modules\cats\models\JobCatalog;
use app\modules\cats\models\JobCatalogSearch;
use app\modules\cats\models\JobCandidate;





class CatsController extends \yii\web\Controller
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


    public function actionJobs()
    {

            $searchModel = new JobCatalogSearch;
              $params = Yii::$app->request->queryParams;
              $params['JobCatalogSearch']['status'] = 'active';
       $dataProvider = $searchModel->search($params);


        return $this->render('jobs',[
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            ]);

    }

    public function actionTest()
    {
        //echo 'sa';

echo Yii::$app->runAction('tao/info');
//return;



//http://localhost:8090/gamantha/pao/cats/web/index.php/tao/adduser?userid=39&password=abc123&type=cats


//$this->redirect('../../tao/test');

        //Yii::setAlias('@frontend', Url::to(['post/index']));
//echo Url::to('@frontend');
//        echo Url::canonical();
  ///      echo '<br/>';
// echo Url::base();
// echo '<Br/>';

    }

    public function actionAdmin()
    {
    	echo 'this is admin';
    }

    public function actionInfo()
    {
    	return $this->render('info');
    }

    public function actionFaq()
    {

     	return $this->render('faq');
    }

    public function actionProfile()
    {
if(null !== Profilegeneral::findOne(Yii::$app->user->id)) {

$model = Profilegeneral::findOne(Yii::$app->user->id);

} else {

        $model = new ProfileGeneral();
        $model->user_id = Yii::$app->user->id;
}

/*
$modelext = ProfileExtended::find()->andWhere(['user_id' => Yii::$app->user->id])->andWhere(['type'=>'edulab'])->andWhere(['key' => 'ed_level'])->One();
if (null !== $modelext) {
} else {
            $modelext = new ProfileExtended();
}
*/

$avatarmodel = ProfileExtended::find()->andWhere(['user_id' => Yii::$app->user->id])->andWhere(['type'=>'profile-extended'])->andWhere(['key' => 'avatar'])->One();
if (null !== $avatarmodel) {
} else {
            $avatarmodel = new ProfileExtended();
}



$imageuploadmodel = new ImageUpload;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
  
            $imageuploadmodel->imageFile = UploadedFile::getInstance($imageuploadmodel, 'imageFile');


if(sizeof($imageuploadmodel->imageFile) > 0) {
     $imageuploadmodel->upload();
  $avatarmodel->user_id = $model->user_id;
            $avatarmodel->type = 'profile-extended';
                    $avatarmodel->key = 'avatar';

            $avatarmodel->value = $imageuploadmodel->imageFile->baseName .'.' . $imageuploadmodel->imageFile->extension ;
            $avatarmodel->save();
        //echo '<br/><br/><br/><br/><br/><pre>';
          //              print_r($imageuploadmodel);
}

            
        
            Yii::$app->session->setFlash('success', 'Your profile is updated');
        } 

        return $this->render('profile', [
            'model' => $model,
            //'modelext' => $modelext,
            'avatarmodel' => $avatarmodel,
            'imageuploadmodel' => $imageuploadmodel,
        ]);

        
    }


}
