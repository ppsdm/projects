<?php

namespace app\modules\cats\controllers;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use app\modules\cats\models\JobCatalog;
use app\modules\cats\models\JobCandidate;
use app\modules\cats\models\JobExtNote;
use app\modules\cats\models\JobLog;
use Yii;
use common\modules\profile\models\ProfileGeneral;
use common\modules\profile\models\ProfileExtended;
use app\modules\admin\models\OrganizationAdminuser;

use common\models\User;
use yii\data\ArrayDataProvider;

use yii\db\Expression;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;


class ApplicationsController extends \yii\web\Controller
{
    public function actionIndex()
    {
    		$query = JobCandidate::find()->andWhere(['user_id' => Yii::$app->user->id]);

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


    public function actionCreatemessage($id)
    {

        $model = new JobLog;
        $model->type = 'message-candidate';
        $model->candidate_id = $id;
        //$model->admin_id = Yii::$app->user->id;
        //$model->datetime = new Expression('NOW()');

                if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                            $model->datetime = new Expression('NOW()');
                        $model->save();

        $user_model = ProfileGeneral::findOne(Yii::$app->user->id);
        $admin_model = User::findOne($model->admin_id);

$subject = 'You have a message from ' . $user_model->first_name . ' ' . $user_model->last_name;
$body = $model->value;





$from_email = Yii::$app->user->identity->email;
$from_name = $user_model->first_name . ' ' . $user_model->last_name;

$admins = OrganizationAdminuser::find()->andWHere(['organization_id' => $model->candidate->job->organization_id])
->andWHere(['status' => 'active'])
->All();

foreach ($admins as $admin_key => $admin_value) {
    $to_email = $admin_value->user->email;
        Yii::$app->mailer->compose()
            ->setTo($to_email)
            ->setFrom([$from_email => $from_name])
            ->setSubject($subject)
            ->setTextBody($body)
            ->send();
            


 
}




                         Yii::$app->session->setFlash('success', 'message is saved.');
                                 //return $this->redirect(Yii::$app->request->referrer);
                            //return $this->goBack();
                         $this->redirect(['message','id' => $id]);
                         
                }


        return $this->render('createmessage', [
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


                //    print_r($dataProvider->getModels());




/*

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

        ]);
       

*/











}
