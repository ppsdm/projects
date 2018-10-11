<?php


use yii\helpers\Html;
use yii\widgets\DetailView;
//use kartik\detail\DetailView;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\widgets\DatePicker;


use yii\web\View;
use app\assets\AppAsset;
use common\modules\core\models\RefValue;
use app\modules\projects\models\Project;
use app\modules\projects\models\ProjectMeta;
use app\modules\projects\models\ProjectActivity;
use app\modules\projects\models\AssessmentReport;
use app\modules\projects\models\ProjectActivityMeta;
use app\modules\projects\models\ProjectAssessment;
use app\modules\projects\models\ProjectAssessmentResult;
use common\modules\profile\models\ProfileMeta;
use common\modules\profile\models\Profile;
use common\modules\catalog\models\RefAssessmentDictionary;
use common\modules\catalog\models\Catalog;
use common\modules\catalog\models\CatalogMeta;

use kartik\grid\GridView;
use machour\yii2\notifications\widgets\NotificationsWidget;
use common\modules\core\models\Notification;
use kartik\editable\Editable;
use yii2tech\html2pdf\Manager;

/* @var $this yii\web\View */
/* @var $model app\modules\projects\models\Activity */

$this->title = $model->name;

$catalog_id = 70;


$proj_act = ProjectActivity::findOne($_GET['id']);

$Pa = ProjectAssessment::find()->andWhere(['activity_id'=> $_GET['id']])->One();


$options = [1 => '1',2 => '2',3=>'3',4=>'4',5=>'5',6=>'6',7 => '7'];

    $form = ActiveForm::begin([
        'action' => ['savecakim'],
        'method' => 'post',
    ]);
//Notification::notify(Notification::KEY_NEW_MESSAGE, '2', '99');

$statusproject = ProjectActivityMeta::find()
->andWhere(['project_activity_id' => $_GET['id']])
->andWhere(['type' => 'assessment'])
->andWhere(['key' => 'status'])
->One();
$user_profile = Profile::find()->andWhere(['user_id' => Yii::$app->user->id])->One();
$is_so = ProfileMeta::find()
->andWhere(['profile_id' => $user_profile->id])
->andWhere(['type' => 'project-role'])
->andWhere(['value' => 'second_opinion'])
->andWhere(['key'=> '2'])
->One();

                    $assessee_model = ProjectActivityMeta::find()
                    ->andWhere(['project_activity_id' => $_GET['id']])
                    ->andWhere(['type' => 'general'])
                    ->andWhere(['key' => 'assessee'])->One();
                    if (null !== $assessee_model) {
                    $assessee_profile_model = Profile::findOne($assessee_model->value);
                    $profile_id = $assessee_profile_model->id;
						$this->params['breadcrumbs'][] = $this->title .'(cat='.$catalog_id . ', assessment='. $Pa->id. ')';


                } else {
                        $profile_id = 'NO-ID';
                }




?>
 <link rel="stylesheet" type="text/css" href="<?=Url::to('@web/css/cakim.css');?>">
<div class="activity-view">
<h3>Assesor : 
			            			<?php 
									
									
	$assessee_id_model = ProjectActivityMeta::find()
			            		->andWhere(['project_activity_id' => $_GET['id']])
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
			            			echo $assessor_list;
			            		} else {
			            			echo 	Html::a('== no assessor ==' , ['cakim/claim', 'id' => $_GET['id']], 
			            				[
        'class' => 'btn btn-warning',
        'data' => [
            'confirm' => Yii::t('app', 'PERHATIAN!! : Anda akan menambahkan diri '.$userprofile->first_name.' sebagai assessor'),
            'method' => 'post',
        ],
        ]);


			            		}
								
									
									
?>
</h3>
    <h1><span>
        <?php
        
        echo Html::img('@web/project-uploads/'.$proj_act->project_id.'/photos/'.$profile_id.'.jpg', ['alt' => '--missing image--','style'=> 'max-width:200px;max-height:200px'
            ]);
        ?>
    </span><?= Html::encode($this->title) ?></h1>


<?php
echo '<br/>';



/**
value dibawah ini hanya untuk dummy saat dev saja
*/


 $assessment_report = new AssessmentReport();



//echo $Pa->id;
$results = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $Pa->id])->All();
$profile_metas = ProfileMeta::find()->andWhere(['profile_id' => $profile_id])->All();
$activity_metas = ProjectActivityMeta::find()->andWhere(['project_activity_id' => $_GET['id']])->All();

$prof = Profile::findOne($profile_id);

$result_object = [];
$result_object['psikogram_cakim']['analisa_sintesa'] = '1';
$result_object['psikogram_cakim']['kemampuan_umum'] = '1';
$result_object['psikogram_cakim']['proses_belajar'] = '1';
$result_object['psikogram_cakim']['penampilan_fisik'] = '1';
$result_object['psikogram_cakim']['fleksibilitas'] = '1';
$result_object['psikogram_cakim']['integritas_diri'] = '1';
$result_object['psikogram_cakim']['loyalitas'] = '1';
$result_object['psikogram_cakim']['pengendalian_diri'] = '1';
$result_object['psikogram_cakim']['self_confidence'] = '1';
$result_object['psikogram_cakim']['stabilitas_emosi'] = '1';
$result_object['psikogram_cakim']['teamwork'] = '1';
$result_object['psikogram_cakim']['inisiatif'] = '1';
$result_object['psikogram_cakim']['kkk'] = '1';
$result_object['psikogram_cakim']['motivasi_prestasi'] = '1';
$result_object['psikogram_cakim']['sistematika_kerja'] = '1';
$result_object['psikogram_cakim']['berfikir_konseptual'] = '1';

$profile_object['first_name'] = $prof->first_name;
$profile_object['last_name'] = $prof->last_name;
$profile_object['birthdate'] = $prof->birthdate;
$profile_object['gender'] = $prof->gender;
$activity_object = [];


foreach ($results as $key => $value) {
    $result_object[$value['type']][$value['key']] = !is_null($value['value']) ? $value['value'] :'1';
}

foreach ($profile_metas as $prof_key => $prof_value) {
        $profile_object[$prof_value['type']][$prof_value['key']] = $prof_value['value'];
}

foreach ($activity_metas as $act_key => $act_value) {
    $activity_object[$act_value['type']][$act_value['key']] = $act_value['value'];
}

/*
input field name

***PROFILE***
name -> first_name + last_name
tanggal_lahir           [birthdate]
gender                  [gender]
***PROFILE_META***
tempat_lahir            [personal][birthplace]


Pekerjaan               [work][current_job]
pendidikan_terakhir     [education][latest]
asal_perguruantinggi    [education][univ]


***PROJECT_ACTIVITY_META***
nomortest       [general][regno]
prospek_jabatan [general][job_prospect]
tempat_test     [schedule][place]
tanggal_test    [schedule][time]


*/

/*$reg_no = isset($f['work']['reg_no']) ? $profile_object['work']['reg_no'] : '';
$psikotes_no = isset($f['work']['psikotes_no']) ? $profile_object['work']['psikotes_no'] : '';
*/
$reg_no = isset($profile_object['work']['reg_no']) ? $profile_object['work']['reg_no'] : '';
$psikotes_no = isset($result_object['cakim']['nomor_psikotes']) ? $result_object['cakim']['nomor_psikotes'] : '';


$birthplace = isset($profile_object['personal']['birthplace']) ? $profile_object['personal']['birthplace'] : '';
$birthdate = $prof->birthdate;
$gender = $prof->gender;
$job_prospect = isset($profile_object['work']['prospect_position']) ? $profile_object['work']['prospect_position'] : '';
$latest_education = isset($profile_object['education']['latest']) ? $profile_object['education']['latest'] : '';
$univ = isset($profile_object['education']['univ']) ? $profile_object['education']['univ'] : '';
$schedule_place = isset($activity_object['schedule']['place']) ? $activity_object['schedule']['place'] : '';
$schedule_time = isset($activity_object['schedule']['scheduled']) ? $activity_object['schedule']['scheduled'] : '';
$current_job = isset($profile_object['work']['current_job']) ? $profile_object['work']['current_job'] : '';


?>

<script type="text/javascript" src="<?=Url::to('@web/js/jquery-1.7.1.js');?>"></script>			
<script type = 'text/javascript' >
function calcscore() {
	var score = 0;
	$(".calc:checked").each(function () {
		score += parseInt($(this).val(), 10);
	});
	$("input[name=sum]").val(score)
}
function calcscore2() {
  var score = 0;
	$(".calc2:checked").each(function () {
		score += parseInt($(this).val(), 10) * $("input[name=sum]").val() ;
	});
	$("input[name=sum2]").val(score) 
}

$().ready(function () {
	$(".calc").change(function () {
		calcscore()
	});
  $(".calc2").change(function () {
		calcscore2();
    if (this.value == '0' ) {
        $(".baik").css("background", '');
        $(".cukup").css("background", '');
        $(".kurang").css("background", '');
        $(".buruk").css("background", 'grey');
    }else if(this.value >= '77' ) {
      $(".baik").css("background", 'grey');
        $(".cukup").css("background", '');
        $(".kurang").css("background", '');
        $(".buruk").css("background", '');
    }

	});
});

$(document).ready(calculate); 

</script>
<?php
echo Yii::$app->controller->renderPartial('../assessment/5/lk', ['psikotes_no' => $psikotes_no,
	'reg_no' => $reg_no,
	'prof' => $prof,
	'birthplace' => $birthplace,
	'current_job' => $current_job,
	'gender' => $gender,
	'job_prospect' => $job_prospect,
	'latest_education' => $latest_education,
	'birthdate' => $birthdate,
	'univ' => $univ,
	'schedule_place' => $schedule_place,
	'schedule_time' => $schedule_time

]);

?>


<br/>
<div style="align:right">
<?php



        echo Html::a(Yii::t('app', 'CAKIM Save Profile'), ['cakim/saveprofile', 'id' => $_GET['id']], [
        'class' => 'btn btn-warning',
        'data' => [
            'confirm' => Yii::t('app', 'Are you sure you want to save this report?'),
            'method' => 'post',
        ],
    ]);






/*

        echo Html::a(Yii::t('app', 'Temporary Save'), ['cakim/sosaved', 'id' => $_GET['id']], [
        'class' => 'btn btn-info',
        'data' => [
            'confirm' => Yii::t('app', 'Are you sure you want to finish review this item?'),
            'method' => 'post',
        ],
    ]);
        */
    

?>
</div>
<br/>
<br/>
<?php


$readonly = false;

/*

        echo $this->render('/assessment/'.$proj_act->project_id.'/70', [
            //'searchModel' => $searchModel,
            //'dataProvider' => $dataProvider,
            'kompetensiDataProvider' => $kompetensiDataProvider,
            'kompetensiSQLDataProvider' => $kompetensiSQLDataProvider,
            'psikogramDataProvider' => $psikogramDataProvider,
            'psikogramSQLDataProvider' => $psikogramSQLDataProvider,
            'psikogramSearchModel' => $psikogramSearchModel,
            'kompetensigramSearchModel' => $kompetensigramSearchModel,
            'catalog_id' => $catalog_id,
            'assessment_report' => $assessment_report,
            'form' => $form,
            'readonly' => $readonly,
            'result_object' => $result_object,
            'profile_object' => $profile_object,
            'activity_object' => $activity_object,
        ]);
		*/

?>
<br/>

    <p>
        <?php 
        echo '<div style="display: inline-block;">'. Html::a(Yii::t('app', 'Print'), ['cakimpdf', 'id' => $model->id], ['class' => 'btn btn-info']).'</div>';
     
        echo '&nbsp;';


        ?>
    </p>
	
    <?php ActiveForm::end(); 



echo '<pre>';

//print_r($profile_object);
//print_r($result_object);
//print_r($activity_object);
    
    
    ?>


