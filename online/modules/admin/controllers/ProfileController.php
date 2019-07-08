<?php

namespace cats\modules\admin\controllers;

use common\modules\profile\models\ProfileExtended;
use common\modules\profile\models\ProfileGeneral;
use app\models\ImageUpload;
use kartik\sidenav\SideNav;
use kartik\file\FileInput;
use Yii;
use common\models\User;

class ProfileController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }


    public function actionGeneral($id)
    {

        $model = ProfileGeneral::findOne($id);



$avatarmodel = ProfileExtended::find()->andWhere(['user_id' => $id])->andWhere(['type'=>'profile-extended'])->andWhere(['key' => 'avatar'])->One();
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

        return $this->render('general', [
            'model' => $model,
            //'modelext' => $modelext,
            'avatarmodel' => $avatarmodel,
            'imageuploadmodel' => $imageuploadmodel,
        ]);

        

    }







    public function actionContacts($id)
    {

            $mobilemodel = ProfileExtended::find()->andWhere(['user_id' => $id])
            ->andWhere(['type' => 'profile-contacts'])
            ->andWhere(['key' => 'mobile'])->One();
             if (isset($mobilemodel)) {
            } else {
                $mobilemodel = new ProfileExtended;
				}

         $workmodel = ProfileExtended::find()->andWhere(['user_id' => $id])
            ->andWhere(['type' => 'profile-contacts'])
            ->andWhere(['key' => 'work'])->One();
             if (isset($workmodel)) {
            } else {
                $workmodel = new ProfileExtended;
				}

         $homemodel = ProfileExtended::find()->andWhere(['user_id' => $id])
            ->andWhere(['type' => 'profile-contacts'])
            ->andWhere(['key' => 'home'])->One();
             if (isset($homemodel)) {
            } else {
                $homemodel = new ProfileExtended;
				}

         $homeadressmodel = ProfileExtended::find()->andWhere(['user_id' => $id])
            ->andWhere(['type' => 'profile-contacts'])
            ->andWhere(['key' => 'home_address'])->One();
             if (isset($homeadressmodel)) {
            } else {
                $homeadressmodel = new ProfileExtended;
				}
         $workadressmodel = ProfileExtended::find()->andWhere(['user_id' => $id])
            ->andWhere(['type' => 'profile-contacts'])
            ->andWhere(['key' => 'work_address'])->One();
             if (isset($workadressmodel)) {
            } else {
                $workadressmodel = new ProfileExtended;
				}
    
            $email = User::findOne($id)->email;



        return $this->render('contacts', [
                'email' => $email,
                'mobile' => $mobilemodel->value,
                'home' => $homemodel->value,
                'work' => $workmodel->value,
                'home_address' => $homeadressmodel->value,
                'work_address' => $workadressmodel->value

            ]);
    }

}
