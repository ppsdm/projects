<?php
use app\modules\projects\models\Project;
use app\modules\projects\models\ProjectMeta;
use app\modules\projects\models\ProjectActivity;
use app\modules\projects\models\ProjectActivitySearch;
use app\modules\projects\models\ProjectActivityMeta;
use common\modules\profile\models\Profile;
use common\modules\profile\models\ProfileMeta;
use yii\data\ActiveDataProvider;
//use Yii;
use Yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;


?>
<hr/>
<?php 
echo '<h3>Admin Functions</h3>';
echo Html::a('Find activity', ['/projects/project/findactivity', 'id' => $_GET['id']], ['class' => 'btn btn btn-info']);
echo '   ';
echo Html::a('Map Assessor', ['/projects/activity/mapassessor', 'id' => $_GET['id']], ['class' => 'btn btn btn-info']);
echo '<hr/>';
echo '<h3>Admin Dashboard</h3>';


$profile_model = Profile::find()->andWhere(['user_id' => Yii::$app->user->id])->One();

            $distinct_assessor_activities_model = ProjectActivityMeta::find()
                ->andWhere(['type' => 'general'])
                ->andWhere(['key' => 'assessor'])
                ->andWhere(['value' => $profile_model->id])
                ->asArray()->All();
    
    $assessor_activity_ids = ArrayHelper::getColumn($distinct_assessor_activities_model, 'project_activity_id');

    $activityQuery = ProjectActivity::find()
                ->andWhere(['project_id' => $_GET['id']])
            ->andWhere(['status' => 'active'])
       //->andWhere(['in','id',$assessor_activity_ids])
            ;


 $activitySearchModel = new ProjectActivitySearch;
if(Yii::$app->request->queryParams) {
	$params = Yii::$app->request->queryParams;
	$params['ProjectActivitySearch']['project_id'] = $_GET['id'];
	//print_r($params);
      $activityDataProvider = $activitySearchModel->search($params);
} else {


/*
				$activityDataProvider = new ActiveDataProvider([
			    'query' => $activityQuery,
			    'pagination' => [
			        'pageSize' => 40,
			    ],
			    'sort' => [
			        'defaultOrder' => [
			        ]
			    ],
			]);
*/

}


/*

			 echo GridView::widget([
			        'dataProvider' => $activityDataProvider,
			        'filterModel' => $activitySearchModel,
			        'columns' => [
			            //['class' => 'yii\grid\SerialColumn'],
			            [
			            	'label' => 'Activity',
			            	'attribute' => 'id',
			            	'format' => 'raw',
			            	'value' => function($data){
			            		$link = Html::a($data->id, ['activity/view', 'id' => $data->id], ['class' => 'profile-link']);
			            		return $link;
			            	}
			            ],
			            [
			            	'label' => 'No Psikotes',
			            	'value' => function($data){
			            				$reg_no_model = ProjectActivityMeta::find()->andWhere(['project_activity_id' => $data->id])
			            				->andWhere(['type' => 'general'])->andWhere(['key' => 'psikotes_no'])
			            				->One();
			            				if (isset($reg_no_model->value))
			            				{
			            					return $reg_no_model->value;
			            				} else {
			            					return 'no psikotes';
			            				}

			            	}
			            ],

			            [
			            	'label' => 'No Registrasi',
			            	'value' => function($data){
			            				$reg_no_model = ProjectActivityMeta::find()->andWhere(['project_activity_id' => $data->id])
			            				->andWhere(['type' => 'general'])->andWhere(['key' => 'reg_no'])
			            				->One();
			            				if (isset($reg_no_model->value))
			            				{
			            					return $reg_no_model->value;
			            				} else {
			            					return 'no reg';
			            				}

			            	}
			            ],


			            //'project_id',

				            'name',
            				          //  'status',
				            [
				            	'label' => 'test',
				            	//'attribute' => 'project_activity_meta.key',
				            ],
			            [
			            'label' => 'Assessor',
			            'format' => 'raw',
			     		//'attribute' => 'assessor',
			            	'value' => function($data){
			            				$assessors = ProjectActivityMeta::find()->andWhere(['project_activity_id' => $data->id])
			            				->andWhere(['type' => 'general'])->andWhere(['key' => 'assessor'])
			            				->andWhere([ '<>','value', '2'])
			            				->One();


			            				$assessor_list = isset($assessors->value) ? $assessors->value : '--no assessor--';

			            				return Html::a($assessor_list, ['activity/addassessor', 'id' => $data->id], ['class' => 'profile-link']);
			            					//return $assessor_list;

			            	}
			            ],
            				

			        ],
			    ]);

*/
//echo '<pre>';
//print_r($_REQUEST);

?>