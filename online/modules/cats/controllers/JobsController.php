<?php

namespace app\modules\cats\controllers;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use app\modules\cats\models\JobCatalog;
use app\modules\cats\models\JobCatalogSearch;
use app\modules\cats\models\JobCandidate;
use Yii;



use app\models\jobsimageUpload;
use yii\db\Expression;
use yii\web\UploadedFile;
use yii\helpers\Html;

class JobsController extends \yii\web\Controller
{
    public function actionIndex()
    {
            /*$query = JobCatalog::find()->andWhere(['status' => 'active']);
                        $provider = new ActiveDataProvider([
    'query' => $query,

]);
                        */
            $searchModel = new JobCatalogSearch;
              $params = Yii::$app->request->queryParams;
              $params['JobCatalogSearch']['status'] = 'active';
       $dataProvider = $searchModel->search($params);


        return $this->render('index',[
        	'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        	]);
    }

    public function actionView($id)
    {

        $model = JobCatalog::findOne($id);

            return $this->renderPartial('view', [
                'model' => $model,
            ]);
        

    }

    public function actionTest()
    {

        echo 'test';
    }

    public function actionRegister($id)
    {

    	$job = JobCandidate::find()
    	->andWhere(['user_id' => Yii::$app->user->id])
    	->andWhere(['job_id' => $id])->One();

    	if(null !== $job) {
            Yii::$app->session->addFlash('danger','You\'re already applied');
                   return $this->redirect('../applications/index');
    	} else {
    		$job = new JobCandidate;
    		$job->user_id = Yii::$app->user->id;
    		$job->job_id = $id;
    		$job->status = 'applied';
    		$job->save();

    		            Yii::$app->session->addFlash('success','You applied for this job!');
    		            return $this->redirect('../applications/index');
    	}
    }

}
