<?php

namespace app\modules\profile\controllers;

use yii\web\Controller;
use common\models\User as User;
use common\modules\profile\models\ProfileGeneral;
use common\modules\profile\models\ProfileExtended;
use Yii;

use common\modules\ref\models\Log;
use app\models\ImageUpload;
use yii\db\Expression;
use yii\web\UploadedFile;



/**
 * Default controller for the `profile` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {


        //$this->layout = '@app/views/layouts/sidebar.php';
       // $this->layout = '@app/views/layouts/lefty/lefty.php';
        //Yii::$app->view->theme = 'lefty';
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
            //return $this->redirect(['view', 'id' => $model->user_id]);
            /*if (null !== $modelext) {
            $modelext->load(Yii::$app->request->post());
            $modelext->user_id = $model->user_id;
            $modelext->type = 'edulab';
            $modelext->key = 'ed_level';
            $modelext->save();
        }
           */

   
            $imageuploadmodel->imageFile = UploadedFile::getInstance($imageuploadmodel, 'imageFile');

           // print_r($imageuploadmodel);

if(sizeof($imageuploadmodel->imageFile) > 0) {
     $imageuploadmodel->upload();
  $avatarmodel->user_id = $model->user_id;
            $avatarmodel->type = 'profile-extended';
                    $avatarmodel->key = 'avatar';

            $avatarmodel->value = $imageuploadmodel->imageFile->baseName .'.' . $imageuploadmodel->imageFile->extension ;
            $avatarmodel->save();

}

            

            Yii::$app->session->setFlash('success', 'Your profile is updated');


        } 

        return $this->render('index', [
            'model' => $model,
            //'modelext' => $modelext,
            'avatarmodel' => $avatarmodel,
            'imageuploadmodel' => $imageuploadmodel,
        ]);



/*
    	//echo ;
        //return $this->render('index');

*/

/*

*/

        
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
