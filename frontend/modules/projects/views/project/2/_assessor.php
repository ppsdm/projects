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
use yii\widgets\ActiveForm;



?>
<div class="activity-form">

    <?php $form = ActiveForm::begin(); 

$location = '--no location--';

$profile_model = Profile::find()->andWhere(['user_id' => Yii::$app->user->id])->One();


//echo $profile_model->id;
$location_model = ProfileMeta::find()->andWhere(['profile_id' => $profile_model->id])->andWhere(['type' => 'cakim'])->andWhere(['key' => 'location'])->One();
$location = isset($location_model->value) ? $location_model->value : '--no location--';
echo '<h3>Location : ' . $location . '</h3>';
echo Html::input('text', 'psikotes_no', '', ['class' => 'form-control']);

								?>


    <div class="form-group">
        <?php 

        echo Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-success']);

        ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php


if ($_POST)
{
	$activity_list = ProjectActivity::find()->andWhere(['project_id' => '2'])->asArray()->All();
	$ids = ArrayHelper::getColumn($activity_list, 'id');

$activities_based_on_location = ProjectActivityMeta::find()->andWhere(['in', 'project_activity_id', $ids])
	->andWhere(['type' => 'schedule'])->andWhere(['key' => 'place'])->andWhere(['value' => strtoupper($location)])->asArray()
->All();

$id_locs = ArrayHelper::getColumn($activities_based_on_location, 'project_activity_id');

$activities_based_on_location_2 = ProjectActivityMeta::find()->andWhere(['in', 'project_activity_id', $id_locs])
	->andWhere(['type' => 'schedule'])->andWhere(['key' => 'place'])->andWhere(['value' => strtoupper($location)])
->All();


//print_r($activities_based_on_location_2);
	$psikotes_no = $_POST['psikotes_no'];

if (sizeof($activities_based_on_location_2) > 0) {
		foreach ($activities_based_on_location_2 as $key => $value) {
		# code...
		
		$no_reg = ProjectActivityMeta::find()->andWhere(['type' => 'general'])->andWhere(['key' => 'reg_no'])
		->andWhere(['project_activity_id' => $value->project_activity_id])->One();
		if(isset($no_reg->value)) {
		if ($no_reg->value == $psikotes_no) {
			$activi = ProjectActivity::findOne($value->project_activity_id);
		echo Html::a($no_reg->value . ' ' . $activi->name , ['activity/view', 'id' => $value->project_activity_id], ['class' => 'profile-link']);
		}
		}
	}
} else {
	echo 'tidak ada peserta dengan no registrasi tersebut untuk daerah anda';
}


} else {
	echo 'EMPTY';
}




echo '<h2>ASSESSOR SECTION</h2><hr/>';



$profile_model = Profile::find()->andWhere(['user_id' => Yii::$app->user->id])->One();






	$projectActivitySearch = new ProjectActivitySearch();
            $distinct_assessor_activities_model = ProjectActivityMeta::find()
                ->andWhere(['type' => 'schedule'])
                ->andWhere(['key' => 'place'])
                ->andWhere(['value' => $location])
                ->asArray()->All();

            $assessor_activity_ids = ArrayHelper::getColumn($distinct_assessor_activities_model, 'project_activity_id');


            $activityQuery = ProjectActivity::find()
            ->andWhere(['project_id' => $_GET['id']])
            ->andWhere(['status' => 'active'])
            ->andWhere(['in','id',$assessor_activity_ids]);

			$activityDataProvider = new ActiveDataProvider([
			    'query' => $activityQuery,
			    'pagination' => [
			        'pageSize' => 1000,
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
			         //   ['class' => 'yii\grid\SerialColumn'],

			            //'id',
			         /*   [
			            	'label' => 'Activity',
			            	'attribute' => 'id',
			            	'format' => 'raw',
			            	'value' => function($data){
			            		$link = Html::a($data->id, ['activity/view', 'id' => $data->id], ['class' => 'profile-link']);
			            		return $link;
			            	}
			            ],
						*/
			          /*  [
			            	'label' => 'Assessment id',
			            	//'attribute' => 'id',
			            	//'format' => 'raw',
			            	'value' => function($data){
			            		$assessment = ProjectAssessment::find()->andWhere(['activity_id'=>$data->id])->andWhere(['status' => 'active'])->One();
			            		return (null !== $assessment)? $assessment->id : '';
			            	}
			            ],
						*/
									            [
			            	'label' => 'Nomor Registrasi',
							'format' => 'raw',
			            	'value' => function($data)
			            	{
			            		$regno_model = ProjectActivityMeta::find()
			            		->andWhere(['project_activity_id' => $data->id])
			            		->andWhere(['type' => 'general'])
			            		->andWhere(['key' => 'reg_no'])->One();
								
								if (null!== $regno_model) {
									$registrasi = $regno_model->value;
								} else {
									$registrasi = 'TIDAK ADA NOMOR REGISTRASI';
								}
			            		//return $regno_model->value;
											$link = Html::a($registrasi, ['activity/view', 'id' => $data->id], ['class' => 'profile-link']);
			            		return $link;
			            	}

			            ],
						
						
						/*
			            [
			            	'label' => 'Nomor Psikotes',
			            	'value' => function($data)
			            	{
			            		$regno_model = ProjectActivityMeta::find()
			            		->andWhere(['project_activity_id' => $data->id])
			            		->andWhere(['type' => 'general'])
			            		->andWhere(['key' => 'psikotes_no'])->One();
			            		return $regno_model->value;
			            	}

			            ],*/
			           /* [
			            	'label' => 'Nomor Registrasi',
			            	'value' => function($data)
			            	{
			            		$regno_model = ProjectActivityMeta::find()
			            		->andWhere(['project_activity_id' => $data->id])
			            		->andWhere(['type' => 'general'])
			            		->andWhere(['key' => 'reg_no'])->One();
			            		return $regno_model->value;
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
          	/*
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

			            		return isset($assessee_profile_id->value) ? $assessee_profile_id->value : '';
			            	}

						],  
						*/
						[
			            	'label' => 'Jadwal',
			            	'value' => function($data)
			            	{
			            		$assessee_id_model = ProjectActivityMeta::find()
			            		->andWhere(['project_activity_id' => $data->id])
			            		->andWhere(['type' => 'schedule'])
			            		->andWhere(['key' => 'scheduled'])->One();

								return isset($assessee_id_model->value) ? $assessee_id_model->value : '';

			            	}

						],  
			            [
			            	'label' => 'Assessor',
			            	'format' => 'raw',
			            	'value' => function($data)
			            	{
			            		$assessee_id_model = ProjectActivityMeta::find()
			            		->andWhere(['project_activity_id' => $data->id])
			            		->andWhere(['type' => 'general'])
			            		->andWhere(['key' => 'assessor'])
 								->andWhere(['<>','value','2'])
			            		->One();
			            		$assessor_list = '';

			            		$userprofile = Profile::find()->andWhere(['user_id' => Yii::$app->user->id])->One();
			            		
			            		if (null !== $assessee_id_model) {
			            			$assessee_model = Profile::findOne($assessee_id_model->value);
			            		$fn = isset($assessee_model->first_name ) ? $assessee_model->first_name : '';
			            		$ln = isset($assessee_model->last_name) ? $assessee_model->last_name : '';
			            			$assessor_list = $fn .' ' . $ln;
			            			
			            		} else {
$assessor_list = ' ';

		/*			            			

			            			return 	Html::a('== no assessor ==' , ['cakim/claim', 'id' => $data->id], 
			            				[
        'class' => 'btn btn-warning',
        'data' => [
            'confirm' => Yii::t('app', 'PERHATIAN!! : Anda akan menambahkan diri '.$userprofile->first_name.' sebagai assessor'),
            'method' => 'post',
        ],
        ]);
*/

			            		}
			            						return $assessor_list .	Html::a('change' , ['cakim/choose', 'id' => $data->id], 
			            				[
        'class' => 'btn btn-warning',
        'data' => [
          //  'confirm' => Yii::t('app', 'PERHATIAN!! : Anda akan menambahkan diri '.$userprofile->first_name.' sebagai assessor'),
            'method' => 'post',
        ],
        ]);
			            		
			            		
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