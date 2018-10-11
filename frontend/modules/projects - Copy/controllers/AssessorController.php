<?php

namespace app\modules\projects\controllers;
use app\modules\projects\models\Project;
use app\modules\projects\models\ProjectMeta;
use app\modules\projects\models\ProjectActivity;
use app\modules\projects\models\AssessmentReport;
use app\modules\projects\models\ProjectActivityMeta;
use common\modules\profile\models\ProfileMeta;
use common\modules\profile\models\Profile;
use common\modules\catalog\models\RefAssessmentDictionary;

use Yii;
use Yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;

class AssessorController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionActivities($profile_id, $project_id)
    {






    	$metas = ProjectActivityMeta::find()
    	->andWhere(['type' => 'general'])
    	->andWhere(['key' => 'assessor'])
    	->andWhere(['value' => '2'])
    	->All();

		$ids = ArrayHelper::getColumn($metas, 'project_activity_id');

		$activities = ProjectActivity::find()
		->andWhere(['in' ,'id', $ids])
		->All();

		//echo '<pre>';
		//print_r($activities);

            $query = ProjectActivity::find()->andWhere(['in' ,'id', $ids]);

            $dataProvider = new ActiveDataProvider([
                'query' => $query,
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


		return $this->render('activities', [

			'dataProvider' => $dataProvider,
			]);

		//echo sizeof($metas);
    	//ProjectActivity::find()
    	//->andWhere(['type'])
    }



}
