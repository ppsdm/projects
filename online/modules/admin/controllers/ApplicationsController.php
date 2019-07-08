<?php

namespace cats\modules\admin\controllers;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use app\modules\cats\models\JobCatalog;
use app\modules\cats\models\JobCandidate;
use app\modules\cats\models\JobExtNote;
use app\modules\cats\models\JobLog;
use common\modules\profile\models\ProfileGeneral;
use common\modules\profile\models\ProfileExtended;
use app\models\ContactForm;
use Yii;


use common\modules\ref\models\Log;
use app\models\ImageUpload;
use yii\db\Expression;
use yii\helpers\Url;
use yii\web\UploadedFile;
use common\models\User;

class ApplicationsController extends \yii\web\Controller
{
    public function actionIndex()
    {
    		$query = JobCandidate::find();

    		$provider = new ActiveDataProvider([
    'query' => $query,

]);



        return $this->render('index',[
        	'dataProvider' => $provider,
        	]);
    }



    public function actionView($id)
    {

    	$model = JobCandidate::findOne($id);

            return $this->render('view', [
                'model' => $model,
            ]);
        

    }

    public function actionMessage($id)
    {

            $message_query = JobLog::find()
            ->andWHere(['candidate_id' => $id])
            ->andWHere(['in','type',['message-candidate','message-admin']]);




            $dataProvider = new ActiveDataProvider([
    'query' => $message_query,
    'pagination' => [
        'pageSize' => 20,
    ],
]);


        return $this->render('messages', [
                'dataProvider' => $dataProvider,
                'id' => $id,

            ]);


    }


    public function actionNotes($id)
    {

            $notes_query = JobLog::find()
            ->andWHere(['candidate_id' => $id])
            ->andWHere(['type' => 'notes']);




            $dataProvider = new ActiveDataProvider([
    'query' => $notes_query,
    'pagination' => [
        'pageSize' => 20,
    ],
]);


        return $this->render('notes', [
                'dataProvider' => $dataProvider,
                'id' => $id,

            ]);
    }

    public function actionCreatenote($id)
    {

        $model = new JobLog;
        $model->type = 'notes';
        $model->candidate_id = $id;
        $model->admin_id = Yii::$app->user->id;
        //$model->datetime = new Expression('NOW()');

                if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                         $model->datetime = new Expression('NOW()');
                        $model->save();
                         Yii::$app->session->setFlash('success', 'note is saved.');
                            //return $this->goBack();
                         $this->redirect(['notes','id' => $id]);
                }


        return $this->render('createnote', [
                'model' => $model,

            ]);
    }

    public function actionCreatemessage($id)
    {

        $model = new JobLog;
        $model->type = 'message-admin';
        $model->candidate_id = $id;
        $model->admin_id = Yii::$app->user->id;
        //$model->datetime = new Expression('NOW()');

                if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                         $model->datetime = new Expression('NOW()');
                        $model->save();

        $admin_model = ProfileGeneral::findOne(Yii::$app->user->id);
       // $user_model = User::findOne($model->candidate->user);

        
$subject = 'You have a message!';
$body = $model->value;
$to_email = $model->candidate->user->email;
$from_email = Yii::$app->user->identity->email;
$from_name = $admin_model->first_name . ' ' . $admin_model->last_name;

        Yii::$app->mailer->compose()
            ->setTo($to_email)
            ->setFrom([$from_email => $from_name])
            ->setSubject($subject)
            ->setTextBody($body)
            ->send();


                         Yii::$app->session->setFlash('success', 'message is saved.');
                                 //return $this->redirect(Yii::$app->request->referrer);
                            //return $this->goBack();
                         $this->redirect(['message','id' => $id]);
                         
                }


        return $this->render('createmessage', [
                'model' => $model,

            ]);
    }

    public function actionEditnote($id)
    {

            $model = JobLog::findOne($id);


                if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                        
                        //$model->datetime = newexpredsadadada;
                         $model->datetime = new Expression('NOW()');
                        $model->save();
                         

                         Yii::$app->session->setFlash('success', 'note is saved.');
                         $this->redirect(['notes','id' => $model->candidate_id]);
                }



                    return $this->render('createnote', [
                'model' => $model,

            ]);

    }


    public function actionDeletemessage($id)
    {

            $model = JobLog::findOne($id);
            $model->delete();
            Yii::$app->session->setFlash('success', 'message is deleted.');
            return $this->redirect(Yii::$app->request->referrer);

    }



    public function actionCreate()
    {
        $model = new JobCandidate();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }

    }

    public function actionBlacklist($id)
    {
        $jobcandidate = JobCandidate::findOne($id);
       $blacklist = JobExtNote::find()->andWhere(['user_id' => $jobcandidate->user_id])
       ->andWhere(['organization_id' => $jobcandidate->job->organization_id])
       ->andWhere(['type' => 'blacklist'])
       ->One();
       if (null == $blacklist) {
        $blacklist = new JobExtNote;
        $blacklist->type = 'blacklist';
        $blacklist->organization_id = $jobcandidate->job->organization_id;
        $blacklist->user_id = $jobcandidate->user_id;
        $blacklist->admin_id = Yii::$app->user->id;
       }

       $blacklist->notes = 'true';
            $blacklist->datetime = new Expression('NOW()');
       $blacklist->save();

         Yii::$app->session->setFlash('warning', 'candidate is blacklisted in this organization.');
        $this->redirect(Yii::$app->request->referrer);

    }
    public function actionUnblacklist($id)
    {

        $jobcandidate = JobCandidate::findOne($id);
       $blacklist = JobExtNote::find()->andWhere(['user_id' => $jobcandidate->user_id])
       ->andWhere(['organization_id' => $jobcandidate->job->organization_id])
       ->andWhere(['type' => 'blacklist'])
       ->One();
       if (null == $blacklist) {
        $blacklist = new JobExtNote;
        $blacklist->type = 'blacklist';
        $blacklist->organization_id = $jobcandidate->job->organization_id;
        $blacklist->user_id = $jobcandidate->user_id;
        $blacklist->admin_id = Yii::$app->user->id;
       }

       $blacklist->notes = 'false';
               $blacklist->datetime = new Expression('NOW()');
       $blacklist->save();

         Yii::$app->session->setFlash('success', 'candidate is un-blacklisted in this organization.');
         $this->redirect(Yii::$app->request->referrer);
    }


}
