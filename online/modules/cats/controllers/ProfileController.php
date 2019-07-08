<?php

namespace app\modules\cats\controllers;
use yii;

use common\modules\profile\models\ProfileExtended;

class ProfileController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionEducation()
    {
        return $this->render('education');
    }
    public function actionWork()
    {
        return $this->render('work');
    }
    public function actionContacts()
    {

            $mobilemodel = ProfileExtended::find()->andWhere(['user_id' => Yii::$app->user->id])
            ->andWhere(['type' => 'profile-contacts'])
            ->andWhere(['key' => 'mobile'])->One();
            if (isset($mobilemodel)) {
                $mobile = $mobilemodel;
            } else {
                $mobile = new ProfileExtended;
                $mobile->user_id = Yii::$app->user->id;
                $mobile->key = 'mobile';
                $mobile->type = 'profile-contacts';
                   $mobile->value = '';

            }

         $workmodel = ProfileExtended::find()->andWhere(['user_id' => Yii::$app->user->id])
            ->andWhere(['type' => 'profile-contacts'])
            ->andWhere(['key' => 'work'])->One();
            if (isset($workmodel)) {
                $work = $workmodel;
            } else {
                $work = new ProfileExtended;
                $work->user_id = Yii::$app->user->id;
                $work->key = 'work';
                $work->type = 'profile-contacts';
                   $work->value = '';
            }

         $homemodel = ProfileExtended::find()->andWhere(['user_id' => Yii::$app->user->id])
            ->andWhere(['type' => 'profile-contacts'])
            ->andWhere(['key' => 'home'])->One();
            if (isset($homemodel)) {
                $home = $homemodel;
            } else {
                $home = new ProfileExtended;
                $home->user_id = Yii::$app->user->id;
                $home->key = 'home';
                $home->type = 'profile-contacts';
                $home->value = '';
            }

         $homeadressmodel = ProfileExtended::find()->andWhere(['user_id' => Yii::$app->user->id])
            ->andWhere(['type' => 'profile-contacts'])
            ->andWhere(['key' => 'home_address'])->One();
            if (isset($homeadressmodel)) {
                $home_address = $homeadressmodel;
            } else {
                $home_address = new ProfileExtended;
                $home_address->user_id = Yii::$app->user->id;
                $home_address->key = 'home_address';
                $home_address->type = 'profile-contacts';
                   $home_address->value = '';
            }
         $workadressmodel = ProfileExtended::find()->andWhere(['user_id' => Yii::$app->user->id])
            ->andWhere(['type' => 'profile-contacts'])
            ->andWhere(['key' => 'work_address'])->One();
            if (isset($workadressmodel)) {
                $work_address = $workadressmodel;
            } else {
                $work_address = new ProfileExtended;
                $work_address->user_id = Yii::$app->user->id;
                $work_address->key = 'work_address';
                $work_address->type = 'profile-contacts';
                   $work_address->value = '';
            }
    
            $email = Yii::$app->user->identity->email;


    if(Yii::$app->request->post()) {

                $work->value = $_POST['work'];
                $mobile->value = $_POST['mobile'];
                $home->value = $_POST['home'];
                $home_address->value = $_POST['home_address'];
                $work_address->value = $_POST['work_address'];
                Yii::$app->user->identity->email = $_POST['email'];

                $work->save();
                $mobile->save();
                $home->save();
                $home_address->save();
                $work_address->save();
                //$email->save();
         Yii::$app->session->addFlash('success','saved');
                //return $this->redirect('index');
    } else {

}



        return $this->render('contacts', [
                'email' => $email,
                'mobile' => $mobile->value,
                'home' => $home->value,
                'work' => $work->value,
                'home_address' => $home_address->value,
                'work_address' => $work_address->value

            ]);
    }

}
