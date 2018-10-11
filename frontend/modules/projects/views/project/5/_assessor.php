<?php
use app\modules\projects\models\Project;
use app\modules\projects\models\ProjectMeta;
use app\modules\projects\models\ProjectActivity;
use app\modules\projects\models\ProjectActivitySearch;
use app\modules\projects\models\ProjectAssessment;
use app\modules\projects\models\ProjectActivityMeta;
use common\modules\profile\models\Profile;
use common\modules\profile\models\ProfileMeta;
use yii\data\ActiveDataProvider;
//use Yii;
use Yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;


?>

<?php
echo '<h2>ASSESSOR SECTION</h2><hr/>';
$profile_model = Profile::find()->andWhere(['user_id' => Yii::$app->user->id])->One();

	$projectActivitySearch = new ProjectActivitySearch();
            $distinct_assessor_activities_model = ProjectActivityMeta::find()
                ->andWhere(['type' => 'general'])
                ->andWhere(['key' => 'assessor'])
                ->andWhere(['value' => $profile_model->id])
                ->asArray()->All();

            $assessor_activity_ids = ArrayHelper::getColumn($distinct_assessor_activities_model, 'project_activity_id');


            $activityQuery = ProjectActivity::find()
            ->andWhere(['project_id' => $_GET['id']])
            ->andWhere(['status' => 'active'])
            ->andWhere(['in','id',$assessor_activity_ids]);

			$activityDataProvider = new ActiveDataProvider([
			    'query' => $activityQuery,
			    'pagination' => [
			        'pageSize' => 50,
			    ],
			    'sort' => [
			        'defaultOrder' => [
			//            'created_at' => SORT_DESC,
			  //          'title' => SORT_ASC, 
			        ]
			    ],
			]);



			 echo GridView::widget([
			        'dataProvider' => $activityDataProvider,
			        'filterModel' => $projectActivitySearch,
    'rowOptions'=>function($model, $index, $widget, $grid){
    		$status_model = ProjectActivityMeta::find()
    		->andWhere(['project_activity_id' => $model->id])
    		->andWhere(['type' => 'assessment'])
    		->andWhere(['key' => 'status'])
    		->One();
            if($status_model->value == 'done'){
                return ['class' => 'success'];
            } else if($status_model->value == 'expired'){
                return ['class' => 'danger'];
            }  else if($status_model->value == 'so_reviewed'){
                return ['class' => 'primary'];
            }  else if($status_model->value == 'so_returned'){
                return ['class' => 'danger'];
            }  else if($status_model->value == 'under_review'){
                return ['class' => 'active'];
            } else {
            	                return ['class' => 'warning'];
            }
            
    },
			       // 'filterModel' => $searchModel,
			        'columns' => [
			            ['class' => 'yii\grid\SerialColumn'],

			            //'id',
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
			            	'label' => 'Assessment id',
			            	//'attribute' => 'id',
			            	//'format' => 'raw',
			            	'value' => function($data){
			            		$assessment = ProjectAssessment::find()->andWhere(['activity_id'=>$data->id])->andWhere(['status' => 'active'])->One();
			            		return (null !== $assessment)? $assessment->id : '';
			            	}
			            ],
			           /* [
			            	'label' => 'Project Name',
			            	'value' => function($data)
			            	{
			            		return $data->project->name;
			            	}

			            ],
			            */
			            [
			            	'label' => 'Nama',
			            	'value' => function($data)
			            	{
			            		$assessee_id_model = ProjectActivityMeta::find()
			            		->andWhere(['project_activity_id' => $data->id])
			            		->andWhere(['type' => 'general'])
			            		->andWhere(['key' => 'assessee'])->One();

			            		$assessee_model = Profile::findOne($assessee_id_model->value);
			            		$fn = isset($assessee_model->first_name ) ? $assessee_model->first_name : '';
			            		$ln = isset($assessee_model->last_name) ? $assessee_model->last_name : '';
			            		return $fn .' ' . $ln;
			            	}

			            ],
						[
			            	'label' => 'NIP',
			            	'value' => function($data)
			            	{
			            		$assessee_id_model = ProjectActivityMeta::find()
			            		->andWhere(['project_activity_id' => $data->id])
			            		->andWhere(['type' => 'general'])
			            		->andWhere(['key' => 'assessee'])->One();

								//$assessee_model = Profile::findOne($assessee_id_model->value);
								
								$assessee_profile_id = ProfileMeta::find()
			            		->andWhere(['profile_id' => $assessee_id_model->value])
			            		->andWhere(['type' => 'work'])
			            		->andWhere(['key' => 'nip'])->One();

			            		return $assessee_profile_id->value;
			            	}

			            ],           	
						[
			            	'label' => 'Jabatan',
			            	'value' => function($data)
			            	{
			            		$assessee_id_model = ProjectActivityMeta::find()
			            		->andWhere(['project_activity_id' => $data->id])
			            		->andWhere(['type' => 'general'])
			            		->andWhere(['key' => 'assessee'])->One();

								//$assessee_model = Profile::findOne($assessee_id_model->value);
								
								$assessee_profile_id = ProfileMeta::find()
			            		->andWhere(['profile_id' => $assessee_id_model->value])
			            		->andWhere(['type' => 'work'])
			            		->andWhere(['key' => 'level'])->One();

			            		return $assessee_profile_id->value;
			            	}

						],  
						[
			            	'label' => 'Jadwal',
			            	'value' => function($data)
			            	{
			            		$assessee_id_model = ProjectActivityMeta::find()
			            		->andWhere(['project_activity_id' => $data->id])
			            		->andWhere(['type' => 'schedule'])
			            		->andWhere(['key' => 'scheduled'])->One();

								return $assessee_id_model->value;

			            	}

						],  
			            [
			            	'label' => 'Assessor',
			            	'value' => function($data)
			            	{
			            		$assessee_id_model = ProjectActivityMeta::find()
			            		->andWhere(['project_activity_id' => $data->id])
			            		->andWhere(['type' => 'general'])
			            		->andWhere(['key' => 'assessor'])->All();
			            		$assessor_list = '';
			            		foreach ($assessee_id_model as $key => $value) {
			            			$assessee_model = Profile::findOne($value->value);
			            		$fn = isset($assessee_model->first_name ) ? $assessee_model->first_name : '';
			            		$ln = isset($assessee_model->last_name) ? $assessee_model->last_name : '';
			            			$assessor_list = $assessor_list .' ,' . $fn .' ' . $ln;
			            		}
			            	
			            		
			            		return substr($assessor_list,2);
			            	}

			            ],
			            [
			            	'label' => 'Second Opinion',
			            	'value' => function($data)
			            	{
			            		$assessee_id_model = ProjectActivityMeta::find()
			            		->andWhere(['project_activity_id' => $data->id])
			            		->andWhere(['type' => 'general'])
			            		->andWhere(['key' => 'second_opinion'])->All();
			            		$assessor_list = '';
			            		foreach ($assessee_id_model as $key => $value) {
			            			$assessee_model = Profile::findOne($value->value);
			            		$fn = isset($assessee_model->first_name ) ? $assessee_model->first_name : '';
			            		$ln = isset($assessee_model->last_name) ? $assessee_model->last_name : '';
			            			$assessor_list = $assessor_list .' ,' . $fn .' ' . $ln;
			            		}
			            	
			            		
			            		return substr($assessor_list,2);
			            	}

			            ],
						[
							'label' => 'Status',
							'format' => 'Raw',
		            	'value' => function($data)
			            	{
			            		$assessee_id_model = ProjectActivityMeta::find()
			            		->andWhere(['project_activity_id' => $data->id])
			            		->andWhere(['type' => 'assessment'])
			            		->andWhere(['key' => 'status'])->One();

								//return '<h1>'.$assessee_id_model->value.'</h1>';
								return $assessee_id_model->value;

			            	} 

			            ],  												
			        ],
			    ]);


?>