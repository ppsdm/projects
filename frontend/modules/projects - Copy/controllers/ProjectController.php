<?php

namespace app\modules\projects\controllers;

use app\modules\projects\models\Project;
use app\modules\projects\models\ProjectMeta;
use app\modules\projects\models\ProjectActivity;
use app\modules\projects\models\ProjectActivityMeta;
use common\modules\profile\models\Profile;
use common\modules\profile\models\ProfileMeta;

use Yii;
use Yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;

class ProjectController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');

        
    }

    public function actionFindactivity($id)
    {

        if ($_POST){
            echo $_POST['assessorname'];
        }
        return $this->render('findactivity');
    }

    public function beforeAction($action) {


 // Log::add(Yii::$app->controller->id, $action->id,'activity');

//echo "test";

    return parent::beforeAction($action);
}

    public function actionDashboard($id)
    {

            if (Yii::$app->user->isGuest) {
                echo 'you have to login first!';
            }
            else {
    	$profile_model = Yii::$app->user->identity->profile->id;
        //Profile::find()->andWhere(['user_id' => Yii::$app->user->id])->One();
        

    	if (null !== $profile_model) {
    		$project_meta_model = ProfileMeta::find()
    			->andWhere(['type' => 'project-role'])
                ->andWhere(['profile_id' => Yii::$app->user->identity->profile->id])
    			->andWhere(['key' => $id])
    			->All();
            if(sizeof($project_meta_model) > 0 ) {
            
            
        	return $this->render('dashboard',[
        			'project_meta_model' => $project_meta_model,
                    //'assessor_activity_ids' => $assessor_activity_ids,
        		]);
                }
                else echo "no project";
    	} else {
    		echo 'NO PROFILE YET ASSOCIATED WITH THIS USER!';
    	   }
        }
    }

    public function actionActivities($profile_id, $project_id)
    {
        return $this->render('activities',[
             
            ]); 
    }

    public function actionEmailall($message)
    {

    }

    public function actionAssessorlist($id)
    {

            $assessor_query = ProfileMeta::find()
            ->andWhere(['type' => 'project-role'])
            ->andWhere(['key' => $id])
            ->andWhere(['value' => 'assessor'])->asArray()->All();

            $ids = ArrayHelper::getColumn($assessor_query, 'profile_id');

            $profile_query = Profile::find()->andWhere(['in','id',$ids]);

            $assessorDataProvider = new ActiveDataProvider([
                'query' => $profile_query,
                'pagination' => [
                    'pageSize' => 10,
                ],
                'sort' => [
                    'defaultOrder' => [
            //            'created_at' => SORT_DESC,
              //          'title' => SORT_ASC, 
                    ]
                ],
            ]);


        return $this->render('assessorlist',[
                'assessorDataProvider' => $assessorDataProvider,
            ]); 
    }


    public function actionCheckactivitiesstatuses($id)
    {
            $projects = ProjectActivity::find()->andWhere(['project_id' => $id])->asArray()->All();
            $ids = ArrayHelper::getColumn($projects, 'id');

            $activities_schedules = ProjectActivityMeta::find()->andWhere(['in','project_activity_id',$ids])->andWhere(['type' => 'schedule'])
            ->andWhere(['key' => 'scheduled'])->All();

            foreach ($activities_schedules as $key => $value) {
                # code...
                echo $key . ' : ' . $value->value;

                $date1 = new \DateTime("now");
                $date2 = new \DateTime($value->value);
$interval = date_diff($date1, $date2);
echo '--->  ' . $interval->format('%R%a days');

                echo '<br/>';
            }
        //check semua activities kalau ada yang mau atau sudah expired
        //yang sudah expire di rubah status dan kirim notifikasi
        //yang mau expire kirim notifikasi ke assessornya 
    }

    public function actionSelect()
    {
            $profile_model = Yii::$app->user->identity->profile->id;
            //Profile::find()->andWhere(['user_id' => Yii::$app->user->id])->One();
            if(null !== $profile_model)
            {
            $project_meta_models = ProfileMeta::find()
            ->andWhere(['type' => 'project-role'])
            ->andWhere(['profile_id' => Yii::$app->user->identity->profile->id])
            ->groupBy(['key'])->asArray()
            ->All();

            $projects_ids = ArrayHelper::getColumn($project_meta_models, 'key');


            $project_query = Project::find()
            ->andWhere(['in','id',$projects_ids]);

            $projectDataProvider = new ActiveDataProvider([
                'query' => $project_query,
                'pagination' => [
                    'pageSize' => 10,
                ],
                'sort' => [
                    'defaultOrder' => [
            //            'created_at' => SORT_DESC,
              //          'title' => SORT_ASC, 
                    ]
                ],
            ]);


//echo '<pre>';
            //print_r($project_models);
    	return $this->render('select',[
    			'projectDataProvider' => $projectDataProvider,
    		]);	
        
            } else {echo "ProFil kosong";}
            
    }

}
