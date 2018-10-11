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

$catalog_id = 30;


$proj_act = ProjectActivity::findOne($_GET['id']);



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

if (($statusproject->value == 'done') || ($statusproject->value == 'so_reviewed') || ($statusproject->value == 'under_review') )
        {
  //Yii::$app->session->addFlash('warning', 'anda sudah tidak dapat mangakses lagi');
//Yii::$app->request->redirect(['project/dashboard?id=2']);
//return Yii::$app->response->redirect(Url::to(['project/dashboard', 'id' => '2']));
//Yii::$app->request->redirect(['site/hat']));
        }

                    $assessee_model = ProjectActivityMeta::find()
                    ->andWhere(['project_activity_id' => $_GET['id']])
                    ->andWhere(['type' => 'general'])
                    ->andWhere(['key' => 'assessee'])->One();
                    if (null !== $assessee_model) {
                    $assessee_profile_model = Profile::findOne($assessee_model->value);
                    $profile_id = $assessee_profile_model->id;



$Pa = ProjectAssessment::find()->andWhere(['activity_id'=> $_GET['id']])->One();




                } else {
                        $profile_id = 'NO-ID';
                }

$user_profile = Profile::find()->andWhere(['user_id' => Yii::$app->user->id])->One();


/*
$is_so = ProjectActivityMeta::find()
->andWhere(['project_activity_id' => $_GET['id']])
->andWhere(['type' => 'general'])
->andWhere(['key' => 'second_opinion'])
->andWhere(['value'=> $user_profile->id])
->One();

$is_assessor = ProjectActivityMeta::find()
->andWhere(['project_activity_id' => $_GET['id']])
->andWhere(['type' => 'general'])
->andWhere(['key' => 'assessor'])
->andWhere(['value'=> $user_profile->id])
->One();




if (null !== $is_so) { //IF SO
        if (($statusproject->value == 'done') || ($statusproject->value == 'so_reviewed') || ($statusproject->value == 'under_review') )
        {
            $readonly = false;
        } else {
            $readonly = true;
        }
} else { //IF ASSESSOR
        if (($statusproject->value == 'new') || ($statusproject->value == 'open') || ($statusproject->value == 'so_returned'))
        {
            $readonly = false;
        } else {
            $readonly = true;
        }
    }

    */
?>
 <link rel="stylesheet" type="text/css" href="<?=Url::to('@web/css/cakim.css');?>">
<div class="activity-view">



<?php



/**
value dibawah ini hanya untuk dummy saat dev saja
*/


 $assessment_report = new AssessmentReport();


//echo //disinni model





    ?>


<?php


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



</script>



 <head>
  <meta charset="utf-8">
  

  <!-- Normalize or reset CSS with your favorite library -->
  <link rel="stylesheet" type="text/css" href="<?=Url::to('@web/css/normalize.css');?>">

  <!-- Load paper.css for happy printing  -->
  <link rel="stylesheet" type="text/css"href="<?=Url::to('@web/css/paper.css');?>">
 
  <link rel="stylesheet" type="text/css" href="<?=Url::to('@web/css/psikogramTable.css');?>">

  <!-- Set page size here: A5, A4 or A3 -->
  <!-- Set also "landscape" if you need -->

  <script src="<?=Url::to('@web/js/d3.min.js');?>" charset="utf-8"></script>
  <link rel="stylesheet" type="text/css" href="<?=Url::to('@web/css/cakim.css');?>">



</head>
<body class="A4">

<section class="sheet padding-20mm">
<div class="headerReport">
<h2>RAHASIA</h2>
<br/>
</div>

<article>

<table  style="font-size:10pt;" cellpadding="0" cellspacing="0"  width="100%">
	<tr bgcolor='#C4D79B'>
		<td colspan="3" nowrap style="border-top: solid windowtext 1.0pt;border-left: solid windowtext 1.0pt;;border-bottom: solid black 1.0pt;border-right:none;" >
			<p style="text-align:center;font-size:10pt;">
				<b>HASIL PEMERIKSAAN PSIKOLOGIS</b>
			</p>
		</td>
		<td nowrap style="border-top: solid windowtext 1.0pt;; border-left:solid windowtext 1.0pt;border-bottom:solid black 1.0pt; border-right: solid windowtext 1.0pt;;" >
			<p style="text-align:center">
				<b>KETERANGAN</b>
			</p>
		</td>
	</tr>
	<tr>
		<td nowrap style="border:none;border-left: solid windowtext 1.0pt;; " >&nbsp;Nomor Psikotest</td>
		<td nowrap style=" " >
			<p style="text-align:center">:</p>
		</td>
		<td nowrap style=" "  >
    <?=$psikotes_no;?></td>
		<td nowrap style="border-top:none;border-left:solid windowtext 1.0pt; border-bottom:none;border-right: solid windowtext 1.0pt;; " >
			
		</td>
	</tr>
	<tr>
		<td nowrap style="border:none;border-left: solid windowtext 1.0pt;; " >&nbsp;Nomor Registrasi</td>
		<td nowrap style=" " >
			<p style="text-align:center">:</p>
		</td>
		<td nowrap style=" "  >
        <?=$reg_no;?></td>
		<td nowrap style="border-top:none;border-left:solid windowtext 1.0pt; border-bottom:none;border-right: solid windowtext 1.0pt;; " >
			
		</td>
	</tr>    
	<tr>
		<td nowrap style="border:none;border-left: solid windowtext 1.0pt;; " >&nbsp;Nama Lengkap		</td>
		<td nowrap style="" >
			<p >:</p>
		</td>
		<td nowrap style=""  >
        <?=$prof->first_name;?></td>
		<td nowrap style="border-top:none;border-left:solid windowtext 1.0pt; border-bottom:none;border-right: solid windowtext 1.0pt;; " >&nbsp;7: Very Above Average</td>
	</tr>
	<tr >
		<td nowrap style="border:none;border-left: solid windowtext 1.0pt;; ">&nbsp;Tempat, Tgl lahir</td>
		<td nowrap style=" " >
			<p style="text-align:center">:</p>
		</td>
		<td nowrap style=" "  ><?=$birthplace;?>, <?=$birthdate;?></td>
		<td nowrap style="border-top:none;border-left:solid windowtext 1.0pt; border-bottom:none;border-right: solid windowtext 1.0pt;; " >
			<p>&nbsp;6 : Above Average
			</p>
		</td>
	</tr>
	<tr >
		<td nowrap style="border:none;border-left: solid windowtext 1.0pt;; " >&nbsp;Pekerjaan Saat Ini</td>
		<td nowrap style=" " >
			<p style="text-align:center">:</p>
		</td>
		<td nowrap style=" "  >
			<?=$current_job;?></td>
		<td nowrap style="border-top:none;border-left:solid windowtext 1.0pt; border-bottom:none;border-right: solid windowtext 1.0pt;; " >
			<p>&nbsp;5 : High Average <span/>
			</p>
		</td>
	</tr>
	<tr >
		<td nowrap style="border:none;border-left: solid windowtext 1.0pt;; ">&nbsp;Jenis Kelamin</td>
		<td nowrap style=" " >
			<p style="text-align:center">:</p>
		</td>
		<td nowrap style=" "  >
			<?=$gender;?></td>
		<td nowrap style="border-top:none;border-left:solid windowtext 1.0pt; border-bottom:none;border-right: solid windowtext 1.0pt;; " >
			<p>&nbsp;4 : Average</p>
		</td>
	</tr>
	<tr >
		<td nowrap style="border:none;border-left: solid windowtext 1.0pt;; ">&nbsp;Prospek Jabatan</td>
		<td nowrap style=" " >
			<p style="text-align:center">:</p>
		</td>
		<td nowrap style=" "  >
			<?=$job_prospect;?></td>
		<td nowrap style="border-top:none;border-left:solid windowtext 1.0pt; border-bottom:none;border-right: solid windowtext 1.0pt;; " >
			<p>&nbsp;3 : Low Average</p>
		</td>
	</tr>
	<tr>
		<td nowrap style="border:none;border-left: solid windowtext 1.0pt;; " >&nbsp;Pendidikan Terakhir</td>
		<td nowrap style=" " >
			<p >:</p>
		</td>
		<td nowrap style=" "  >
        <?=$latest_education;?></td>
		<td nowrap style="border-top:none;border-left:solid windowtext 1.0pt; border-bottom:none;border-right: solid windowtext 1.0pt;; " >
			<p>&nbsp;2 : Below Average</p>
		</td>
	</tr>
	<tr>
		<td nowrap style="border:none;border-left: solid windowtext 1.0pt;; ">&nbsp;Asal Perguruan Tinggi</td>
		<td nowrap style=" " >
			<p style="text-align:center">:</p>
		</td>
		<td nowrap style=" "  >
			<?=$univ;?></td>
		<td nowrap style="border-top:none;border-left:solid windowtext 1.0pt; border-bottom:none;border-right: solid windowtext 1.0pt;; " >
			<p>&nbsp;1 : Very Below Average</p>
		</td>
	</tr>
	<tr style="mso-yfti-irow:10;mso-yfti-lastrow:yes;">
		<td nowrap style="border-top:none;border-left: solid windowtext 1.0pt;; border-bottom: solid windowtext 1.0pt;;border-right:none; ">&nbsp;Tempat / Tanggal Test</td>
		<td nowrap style="border:none;border-bottom: solid windowtext 1.0pt;; " >
			<p style="text-align:center">:</p>
		</td>
		<td nowrap style="border:none;border-bottom: solid windowtext 1.0pt;"  >
			<?=$schedule_place;?>, <?=$schedule_time;?>
		</td>
		<td nowrap style="border-top:none;border-left:solid windowtext 1.0pt; border-bottom: solid windowtext 1.0pt;;border-right: solid windowtext 1.0pt;; " >
			
		</td>
	</tr>
</table>

<br/>
      <table border="1" cellpadding="0" cellspacing="0" class="MsoTableGrid"
      style="border-right: solid windowtext 1.0pt;border-collapse:collapse; border:none; mso-padding-alt:0in 5.4pt 0in 5.4pt">
        <tr bgcolor='#C4D79B'>
          <td colspan="2"
          style="border-top:solid 1.0pt; border-left:solid 1.0pt;border-bottom:solid 1.0pt;border-right:solid 1.0pt; border-color:windowtext;mso-border-left-alt: solid 1.0pt; padding:2px;"
          >
            <p align="center" style="margin-left:0in;text-align: center;">
              <b>ASPEK - ASPEK</b>
            </p>
          </td>
          <td colspan="7" rowspan="2"
          style="border-top: solid windowtext 1.0pt;; border-left:none;border-bottom: solid windowtext 1.0pt;;border-right: solid windowtext 1.0pt;; padding:2px; "
          >
            <p align="center" style="margin-left:0in;text-align: center;">
              <b>
                <span style="mso-bidi-font-size: 10.0pt;">RATING</span>
              </b>
            </p>
          </td>
        </tr>
        <tr bgcolor='#C4D79B'>
          <td colspan="2"
          style="border-top:none;border-left: solid windowtext 1.0pt;border-bottom: solid windowtext 1.0pt;;border-right: solid windowtext 1.0pt;padding:2px; "
          >
            <p align="left" style="margin-left:0in;text-align:left;">
              <b>A. ASPEK KECERDASAN</b>
            </p>
          </td>
        </tr>
        <tr>
          <td rowspan="3" class="deskripsiCakim" width="38">
            <p align="center" >
              1</span>
            </p>
          </td>
          <td rowspan="3" class="deskripsiCakim" width="850">
         <div style="font-size:10pt;"><b>Kemampuan Umum</b>
          <br />Kemampuan dalam menangkap, mengolah, mencerna dan memahami informasi, kemudian memakai atau menggunakannya utuk
          memecahkan masalah sesuai dengan kebutuhan yang ada</div></td>
          <td class="rater" ><div style="font-size:10pt;">1</div></td>
          <td class="rater" ><div style="font-size:10pt;">2</div></td>
          <td class="rater" ><div style="font-size:10pt;">3</div></td>
          <td class="rater" ><div style="font-size:10pt;">4</div></td>
          <td class="rater" ><div style="font-size:10pt;">5</div></td>
          <td class="rater" ><div style="font-size:10pt;">6</div></td>
          <td class="rater" ><div style="font-size:10pt;">7</div></td>
        </tr>
        <tr>
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
           <td class="bawahRaterSelected" >&nbsp;</td>
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
        </tr>
        <tr >
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['kemampuan_umum'] == '1') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['kemampuan_umum'] == '2') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['kemampuan_umum'] == '3') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['kemampuan_umum'] == '4') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['kemampuan_umum'] == '5') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['kemampuan_umum'] == '6') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['kemampuan_umum'] == '7') ? 'x' : '';?>
          </td>
        </tr>
        <tr style="mso-yfti-irow:5;">
          <td rowspan="3" class="deskripsiCakim" width="38">
            <p align="center" >
              2</span>
            </p>
          </td>
          <td rowspan="3" class="deskripsiCakim" width="800">
          <div style="font-size:10pt;"><b>Kemampuan Berfikir Analisa Sintesa</b>
          <br />Kemampuan untuk meninjau permasalahan secara mendalam dengan menguraikan masalah secara lebih rinci dan menemukan
          hubungan sebab-akibat dari suatu situasi</div></td>
          <td class="rater" ><div style="font-size:10pt;">1</div></td>
          <td class="rater" ><div style="font-size:10pt;">2</div></td>
          <td class="rater" ><div style="font-size:10pt;">3</div></td>
          <td class="rater" ><div style="font-size:10pt;">4</div></td>
          <td class="rater" ><div style="font-size:10pt;">5</div></td>
          <td class="rater" ><div style="font-size:10pt;">6</div></td>
          <td class="rater" ><div style="font-size:10pt;">7</div></td>
        </tr>
        <tr>
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
           <td class="bawahRaterSelected" >&nbsp;</td>
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" ></td>
        </tr>
        <tr>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['analisa_sintesa'] == '1') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['analisa_sintesa'] == '2') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['analisa_sintesa'] == '3') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['analisa_sintesa'] == '4') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['analisa_sintesa'] == '5') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['analisa_sintesa'] == '6') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['analisa_sintesa'] == '7') ? 'x' : '';?>
          </td>
        </tr>
        <tr>
          <td rowspan="3" class="deskripsiCakim" width="38">
            <p align="center" >
              3
            </p>
          </td>
          <td rowspan="3" class="deskripsiCakim" width="800">
          <div style="font-size:10pt;"><b>Kemampuan Berfikir Konseptual</b>
          <br />Kemampuan individu untuk melakukan pertimbangan yang logis dan mengorganisir data dalam suatu pemikiran yang
          berlandaskan pendekatan atau teori tertentu</div></td>
          <td class="rater" ><div style="font-size:10pt;">1</div></td>
          <td class="rater" ><div style="font-size:10pt;">2</div></td>
          <td class="rater" ><div style="font-size:10pt;">3</div></td>
          <td class="rater" ><div style="font-size:10pt;">4</div></td>
          <td class="rater" ><div style="font-size:10pt;">5</div></td>
          <td class="rater" ><div style="font-size:10pt;">6</div></td>
          <td class="rater" ><div style="font-size:10pt;">7</div></td>
        </tr>
        <tr>
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
           <td class="bawahRaterSelected" >&nbsp;</td>
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
        </tr>
        <tr>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['berfikir_konseptual'] == '1') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['berfikir_konseptual'] == '2') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['berfikir_konseptual'] == '3') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['berfikir_konseptual'] == '4') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['berfikir_konseptual'] == '5') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['berfikir_konseptual'] == '6') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['berfikir_konseptual'] == '7') ? 'x' : '';?>
          </td>
        </tr>
        <tr style="mso-yfti-irow:11;">
          <td rowspan="3" class="deskripsiCakim" width="38">
            <p align="center" >
              4</span>
            </p>
          </td>
          <td rowspan="3" class="deskripsiCakim" width="800">
          <div style="font-size:10pt;"><b>Kemampuan Dan Proses Belajar</b>
          <br />Kemampuan dan kelancaran individu untuk menguasai suatu perilaku dan atau bahan pelajaran serta hal hal yang
          baru</div></td>
          <td class="rater" ><div style="font-size:10pt;">1</div></td>
          <td class="rater" ><div style="font-size:10pt;">2</div></td>
          <td class="rater" ><div style="font-size:10pt;">3</div></td>
          <td class="rater" ><div style="font-size:10pt;">4</div></td>
          <td class="rater" ><div style="font-size:10pt;">5</div></td>
          <td class="rater" ><div style="font-size:10pt;">6</div></td>
          <td class="rater" ><div style="font-size:10pt;">7</div></td>
        </tr>
        <tr style="mso-yfti-irow:12;">
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
           <td class="bawahRaterSelected" >&nbsp;</td>
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
        </tr>
        <tr>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['proses_belajar'] == '1') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['proses_belajar'] == '2') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['proses_belajar'] == '3') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['proses_belajar'] == '4') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['proses_belajar'] == '5') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['proses_belajar'] == '6') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['proses_belajar'] == '7') ? 'x' : '';?>
          </td>
        </tr>
 
        <tr bgcolor='#C4D79B' >
          <td colspan="2"
          style="border-top: solid windowtext 1.0pt;;border-left: solid windowtext 1.0pt;border-bottom: solid windowtext 1.0pt;;border-right: solid windowtext 1.0pt;padding: 0in 5.4pt 0in 5.4pt;height:23.7pt"
          >
            <p align="left" style="margin-left:0in;text-align:left;">
              <b>B. ASPEK SIKAP DAN CARA KERJA</b>
            </p>
          </td>
          <td colspan="7"
          style="border-top: solid windowtext 1.0pt;;border-left: none;border-bottom: solid windowtext 1.0pt;;border-right: solid windowtext 1.0pt;; padding:2px;height:23.7pt"
          >
            <p align="center" style="margin-left:0in;text-align: center;">
              <b>
                <span style="mso-bidi-font-size: 10.0pt;">RATING</span>
              </b>
            </p>
          </td>
        </tr>
        <tr style="mso-yfti-irow:15;height:14.95pt">
          <td rowspan="3" class="deskripsiCakim" width="38">
            <p align="center" >
              <span style="font-size:10.0pt; color:#0D0D0D">1</span>
            </p>
          </td>
          <td rowspan="3" class="deskripsiCakim" width="800">
          <div style="font-size:10pt;"><b>Motivasi Berprestasi.</b>
          <br />Keinginan meningkatkan hasil kerja dan selalu Berfokus pada profit opportunities. Kemampuan individu untuk bekerja
          dengan baik atau usaha untuk mencapai standard yang luar biasa</div></td>
          <td class="rater" ><div style="font-size:10pt;">1</div></td>
          <td class="rater" ><div style="font-size:10pt;">2</div></td>
          <td class="rater" ><div style="font-size:10pt;">3</div></td>
          <td class="rater" ><div style="font-size:10pt;">4</div></td>
          <td class="rater" ><div style="font-size:10pt;">5</div></td>
          <td class="rater" ><div style="font-size:10pt;">6</div></td>
          <td class="rater" ><div style="font-size:10pt;">7</div></td>
        </tr>
        <tr>
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
           <td class="bawahRaterSelected" >&nbsp;</td>
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
        </tr>
        <tr>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['motivasi_prestasi'] == '1') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['motivasi_prestasi'] == '2') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['motivasi_prestasi'] == '3') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['motivasi_prestasi'] == '4') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['motivasi_prestasi'] == '5') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['motivasi_prestasi'] == '6') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['motivasi_prestasi'] == '7') ? 'x' : '';?>
          </td>
        </tr>
        <tr style="mso-yfti-irow:18;">
          <td rowspan="3" class="deskripsiCakim" width="38">
            <p align="center" >
              <span style="font-size:10.0pt; color:#0D0D0D">2</span>
            </p>
          </td>
          <td rowspan="3" class="deskripsiCakim" width="800">
          <div style="font-size:10pt;"><b>Inisiatif</b><br/>
          Kemampuan bertindak melebihi dari tuntutan atau harapan suatu tugas dengan tujuan untuk meningkatkan hasil serta
          menghindari masalah dan menemukan atau menciptakan kesempatan-kesempatan baru</div></td>
          <td class="rater" ><div style="font-size:10pt;">1</div></td>
          <td class="rater" ><div style="font-size:10pt;">2</div></td>
          <td class="rater" ><div style="font-size:10pt;">3</div></td>
          <td class="rater" ><div style="font-size:10pt;">4</div></td>
          <td class="rater" ><div style="font-size:10pt;">5</div></td>
          <td class="rater" ><div style="font-size:10pt;">6</div></td>
          <td class="rater" ><div style="font-size:10pt;">7</div></td>
        </tr>
        <tr>
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
           <td class="bawahRaterSelected" >&nbsp;</td>
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
        </tr>
        <tr style="mso-yfti-irow:20;">
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['inisiatif'] == '1') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['inisiatif'] == '2') ? 'x' : '';?> 
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['inisiatif'] == '3') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
         <?php echo ($result_object['psikogram_cakim']['inisiatif'] == '4') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['inisiatif'] == '5') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['inisiatif'] == '6') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
             <?php echo ($result_object['psikogram_cakim']['inisiatif'] == '7') ? 'x' : '';?>
          </td>
        </tr>
        <tr style="mso-yfti-irow:21;">
          <td rowspan="3" class="deskripsiCakim" width="38">
            <p align="center" >
              <span style="font-size:10.0pt; color:#0D0D0D">3</span>
            </p>
          </td>
          <td rowspan="3" class="deskripsiCakim" width="800">
          <div style="font-size:10pt"><b>Sistematika Kerja.</b>
          <br />Kemampuan dan ketrampilan menyelesaikan suatu tugas secara runtut, proporsional, sesuai dengan skala prioritas
          tertentu sehingga unjuk kerjanya efektif, efisien dengan hasil yang optimal</div></td>
          <td class="rater" ><div style="font-size:10pt;">1</div></td>
          <td class="rater" ><div style="font-size:10pt;">2</div></td>
          <td class="rater" ><div style="font-size:10pt;">3</div></td>
          <td class="rater" ><div style="font-size:10pt;">4</div></td>
          <td class="rater" ><div style="font-size:10pt;">6</div></td>
          <td class="rater" ><div style="font-size:10pt;">6</div></td>
          <td class="rater" ><div style="font-size:10pt;">7</div></td>
        </tr>
        <tr style="mso-yfti-irow:22;">
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
           <td class="bawahRaterSelected" >&nbsp;</td>
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
        </tr>
        <tr style="mso-yfti-irow:23;height:14.95pt">
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['sistematika_kerja'] == '1') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['sistematika_kerja'] == '2') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['sistematika_kerja'] == '3') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['sistematika_kerja'] == '4') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['sistematika_kerja'] == '5') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['sistematika_kerja'] == '6') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['sistematika_kerja'] == '7') ? 'x' : '';?>
          </td>
        </tr>
        <tr style="mso-yfti-irow:24;">
          <td rowspan="3" class="deskripsiCakim" width="38">
            <p align="center" >
              4
            </p>
          </td>
          <td rowspan="3" class="deskripsiCakim" width="800">
          <div style="font-size:10pt"><b>Ketelitian, Keteraturan Dan Kualitas.</b>
          <br />Kemampuan menyelesaikan tugas sesuai dengan target yang telah ditentukan secara ukuran kualitas yang tertinggi</div></td>
          <td class="rater" ><div style="font-size:10pt;">1</div></td>
          <td class="rater" ><div style="font-size:10pt;">2</div></td>
          <td class="rater" ><div style="font-size:10pt;">3</div></td>
          <td class="rater" ><div style="font-size:10pt;">4</div></td>
          <td class="rater" ><div style="font-size:10pt;">6</div></td>
          <td class="rater" ><div style="font-size:10pt;">6</div></td>
          <td class="rater" ><div style="font-size:10pt;">7</div></td>
        </tr>
        <tr style="mso-yfti-irow:25;">
          <td class="bawahRater" ></td>
          <td class="bawahRater" ></td>
          <td class="bawahRater" ></td>
          <td class="bawahRater" ></td>
          <td class="bawahRaterSelected" >&nbsp;</td>
          <td class="bawahRater" ></td>
          <td class="bawahRater" ></td>
        </tr>
        <tr style="mso-yfti-lastrow:yes;">
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['kkk'] == '1') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['kkk'] == '2') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['kkk'] == '3') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['kkk'] == '4') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['kkk'] == '5') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['kkk'] == '6') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['kkk'] == '7') ? 'x' : '';?>
          </td>
        </tr>
      </table>
    
    
      </article>
</section>
<section class="sheet padding-20mm">
<div class="headerReport">
<h2>RAHASIA</h2>
<br/>
</div>

<article>


      <table border="1" cellpadding="0" cellspacing="0" class="MsoTableGrid"
      style="border-collapse:collapse; border:none; mso-padding-alt:0in 5.4pt 0in 5.4pt" >
        <tr bgcolor='#C4D79B'>
          <td colspan="2"
          style="border-top:solid 1.0pt; border-left:solid 1.0pt;border-bottom:solid 1.0pt;border-right:solid 1.0pt; border-color:windowtext;mso-border-left-alt: solid 1.0pt; padding:2px;"
          >
            <p align="left" style="margin-left:0in;text-align:left;">
              <b>C. ASPEK KEPRIBADIAN</b>
            </p>
          </td>
          <td colspan="7"
          style="border-top: solid windowtext 1.0pt;; border-left:none;border-bottom:solid windowtext 1.0pt;border-right: solid windowtext 1.0pt;; mso-border-right-alt: solid 1.0pt;padding:2px; "
          >
            <p align="center" style="margin-left:0in;text-align: center;">
              <b>
                <span style="mso-bidi-font-size: 10.0pt;">RATING</span>
              </b>
            </p>
          </td>
        </tr>
        <tr style="height:14.9pt">
          <td rowspan="3" class="deskripsiCakim" width="38">
            <p align="center" >
              1
            </p>
          </td>
          <td rowspan="3" class="deskripsiCakim" width="800">
          <div style="font-size:10pt"><b>Integritas Diri</b>
          <br />Menunjukkan kematangan pribadi, kejujuran terhadap nilai-nilai universal, kesesuaian pikiran, perkataan dan
          perbuatan serta kemampuan memberikan pertimbangan yang optimal dalam situasi yang penuh konflik.</div></td>
          <td class="rater" ><div style="font-size:10pt;">1</div></td>
          <td class="rater" ><div style="font-size:10pt;">2</div></td>
          <td class="rater" ><div style="font-size:10pt;">3</div></td>
          <td class="rater" ><div style="font-size:10pt;">4</div></td>
          <td class="rater" ><div style="font-size:10pt;">5</div></td>
          <td class="rater" ><div style="font-size:10pt;">6</div></td>
          <td class="rater" ><div style="font-size:10pt;">7</div></td>
        </tr>
        <tr>
          <td class="bawahRater" ></td>
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
           <td class="bawahRaterSelected" >&nbsp;</td>
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
        </tr>
        <tr>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['integritas_diri'] == '1') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['integritas_diri'] == '2') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['integritas_diri'] == '3') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['integritas_diri'] == '4') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['integritas_diri'] == '5') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['integritas_diri'] == '6') ? 'x' : '';?>
          </td>
          <td class="radioRater" >
          <?php echo ($result_object['psikogram_cakim']['integritas_diri'] == '7') ? 'x' : '';?>
          </td>
        </tr>
        <tr>
          <td rowspan="3" class="deskripsiCakim" width="38">
            <p align="center" >2</p>
          </td>
          <td rowspan="3" class="deskripsiCakim" width="800">
          <div style="font-size:10pt"><b>Loyalitas</b>
          <br />Kesetiaan dan kesediaan untuk memberikan dukungan yang terus menerus kepada organisasi dan profesi</div></td>
          <td class="rater"><div style="font-size:10pt;">1</div></td>
          <td class="rater"><div style="font-size:10pt;">2</div></td>
          <td class="rater"><div style="font-size:10pt;">3</div></td>
          <td class="rater"><div style="font-size:10pt;">4</div></td>
          <td class="rater"><div style="font-size:10pt;">5</div></td>
          <td class="rater"><div style="font-size:10pt;">6</div></td>
          <td class="rater"><div style="font-size:10pt;">7</div></td>
        </tr>
        <tr>
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
           <td class="bawahRaterSelected" >&nbsp;</td>
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
        </tr>
        <tr>
        <td class="radioRater" >
        <?php echo ($result_object['psikogram_cakim']['loyalitas'] == '1') ? 'x' : '';?>
        </td>
        <td class="radioRater" >
        <?php echo ($result_object['psikogram_cakim']['loyalitas'] == '2') ? 'x' : '';?>
        </td>
        <td class="radioRater" >
        <?php echo ($result_object['psikogram_cakim']['loyalitas'] == '3') ? 'x' : '';?>
        </td>
        <td class="radioRater" >
        <?php echo ($result_object['psikogram_cakim']['loyalitas'] == '4') ? 'x' : '';?>
        </td>
        <td class="radioRater" >
        <?php echo ($result_object['psikogram_cakim']['loyalitas'] == '5') ? 'x' : '';?>
        </td>
        <td class="radioRater" >
        <?php echo ($result_object['psikogram_cakim']['loyalitas'] == '6') ? 'x' : '';?>
        </td>
        <td class="radioRater" >
        <?php echo ($result_object['psikogram_cakim']['loyalitas'] == '7') ? 'x' : '';?>
        </td>
      </tr>
        <tr>
          <td rowspan="3" class="deskripsiCakim" width="38">
            <p align="center" >3</p>
          </td>
          <td rowspan="3" class="deskripsiCakim" width="800">
          <div style="font-size:10pt"><b>Stabilitas Emosi</b>
          <br />Kematangan pribadi dan memiliki konsep diri yang positif serta Kemampuan untuk berespon secara optimal meskipun
          dalam situasi atau kondisi yang tidak menyenangkan.</div></td>
          <td class="rater"><div style="font-size:10pt;">1</div></td>
          <td class="rater"><div style="font-size:10pt;">2</div></td>
          <td class="rater"><div style="font-size:10pt;">3</div></td>
          <td class="rater"><div style="font-size:10pt;">4</div></td>
          <td class="rater"><div style="font-size:10pt;">5</div></td>
          <td class="rater"><div style="font-size:10pt;">6</div></td>
          <td class="rater"><div style="font-size:10pt;">7</div></td>
        </tr>
        <tr>
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
           <td class="bawahRaterSelected" >&nbsp;</td>
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
        </tr>
        <tr>
        <td class="radioRater" >
        <?php echo ($result_object['psikogram_cakim']['stabilitas_emosi'] == '1') ? 'x' : '';?>
        </td>
        <td class="radioRater" >
        <?php echo ($result_object['psikogram_cakim']['stabilitas_emosi'] == '2') ? 'x' : '';?>
        </td>
        <td class="radioRater" >
        <?php echo ($result_object['psikogram_cakim']['stabilitas_emosi'] == '3') ? 'x' : '';?>
        </td>
        <td class="radioRater" >
        <?php echo ($result_object['psikogram_cakim']['stabilitas_emosi'] == '4') ? 'x' : '';?>
        </td>
        <td class="radioRater" >
        <?php echo ($result_object['psikogram_cakim']['stabilitas_emosi'] == '5') ? 'x' : '';?>
        </td>
        <td class="radioRater" >
        <?php echo ($result_object['psikogram_cakim']['stabilitas_emosi'] == '6') ? 'x' : '';?>
        </td>
        <td class="radioRater" >
        <?php echo ($result_object['psikogram_cakim']['stabilitas_emosi'] == '7') ? 'x' : '';?>
        </td>
      </tr>
        <tr>
          <td rowspan="3" class="deskripsiCakim" width="38">
            <p align="center" >4</p>
          </td>
          <td rowspan="3" class="deskripsiCakim" width="800">
          <div style="font-size:10pt"><b>Pengendalian Diri</b>
          <br />Kemampuan mengendalikan diri dan emosi dalam situasidan kondisi ”menekan” / ”stressfull” dengan tetap dapat
          menampilkan unjuk kerja dan unjuk diri yang efektif serta optimal</div></td>
          <td class="rater"><div style="font-size:10pt;">1</div></td>
          <td class="rater"><div style="font-size:10pt;">2</div></td>
          <td class="rater"><div style="font-size:10pt;">3</div></td>
          <td class="rater"><div style="font-size:10pt;">4</div></td>
          <td class="rater"><div style="font-size:10pt;">5</div></td>
          <td class="rater"><div style="font-size:10pt;">6</div></td>
          <td class="rater"><div style="font-size:10pt;">7</div></td>
        </tr>
        <tr>
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
           <td class="bawahRaterSelected" >&nbsp;</td>
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
        </tr>
        <tr>
        <td class="radioRater" >
        <?php echo ($result_object['psikogram_cakim']['pengendalian_diri'] == '1') ? 'x' : '';?>
        </td>
        <td class="radioRater" >
        <?php echo ($result_object['psikogram_cakim']['pengendalian_diri'] == '2') ? 'x' : '';?>
        </td>
        <td class="radioRater" >
        <?php echo ($result_object['psikogram_cakim']['pengendalian_diri'] == '3') ? 'x' : '';?>
        </td>
        <td class="radioRater" >
        <?php echo ($result_object['psikogram_cakim']['pengendalian_diri'] == '4') ? 'x' : '';?>
        </td>
        <td class="radioRater" >
        <?php echo ($result_object['psikogram_cakim']['pengendalian_diri'] == '5') ? 'x' : '';?>
        </td>
        <td class="radioRater" >
        <?php echo ($result_object['psikogram_cakim']['pengendalian_diri'] == '6') ? 'x' : '';?>
        </td>
        <td class="radioRater" >
        <?php echo ($result_object['psikogram_cakim']['pengendalian_diri'] == '7') ? 'x' : '';?>
        </td>
      </tr>
        <tr>
          <td rowspan="3" class="deskripsiCakim" width="38">
            <p align="center" >5</p>
          </td>
          <td rowspan="3" class="deskripsiCakim" width="800">
          <div style="font-size:10pt"><b>Fleksibilitas / Penyesuaian Diri</b>
          <br />Mampu menyesuaikan diri dengan berbagai situasi dan berbagai tuntutan tugas, tanggung jawab atau orang-orang di
          sekitarnya</div></td>
          <td class="rater"><div style="font-size:10pt;">1</div></td>
          <td class="rater"><div style="font-size:10pt;">2</div></td>
          <td class="rater"><div style="font-size:10pt;">3</div></td>
          <td class="rater"><div style="font-size:10pt;">4</div></td>
          <td class="rater"><div style="font-size:10pt;">5</div></td>
          <td class="rater"><div style="font-size:10pt;">6</div></td>
          <td class="rater"><div style="font-size:10pt;">7</div></td>
        </tr>
        <tr>
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
           <td class="bawahRaterSelected" >&nbsp;</td>
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
        </tr>
        <tr>
        <td class="radioRater" >
        <?php echo ($result_object['psikogram_cakim']['fleksibilitas'] == '1') ? 'x' : '';?>
        </td>
        <td class="radioRater" >
        <?php echo ($result_object['psikogram_cakim']['fleksibilitas'] == '2') ? 'x' : '';?>
        </td>
        <td class="radioRater" >
        <?php echo ($result_object['psikogram_cakim']['fleksibilitas'] == '3') ? 'x' : '';?>
        </td>
        <td class="radioRater" >
        <?php echo ($result_object['psikogram_cakim']['fleksibilitas'] == '4') ? 'x' : '';?>
        </td>
        <td class="radioRater" >
        <?php echo ($result_object['psikogram_cakim']['fleksibilitas'] == '5') ? 'x' : '';?>
        </td>
        <td class="radioRater" >
        <?php echo ($result_object['psikogram_cakim']['fleksibilitas'] == '6') ? 'x' : '';?>
        </td>
        <td class="radioRater" >
        <?php echo ($result_object['psikogram_cakim']['fleksibilitas'] == '7') ? 'x' : '';?>
        </td>
      </tr>
        <tr>
          <td rowspan="3" class="deskripsiCakim" width="38">
            <p align="center" >6</p>
          </td>
          <td rowspan="3" class="deskripsiCakim" width="800">
          <div style="font-size:10pt"><b>Self Confidence / Kepercayaan Diri</b>
          <br />Kepercayaan individu terhadap dirinya untuk menyelesaikan tugas, mengatasi situasi menantang, mengambil keputusan
          atau menyampaikan pendapat dan mengatasi kegagalan secara konstruktif</div></td>
          <td class="rater"><div style="font-size:10pt;">1</div></td>
          <td class="rater"><div style="font-size:10pt;">2</div></td>
          <td class="rater"><div style="font-size:10pt;">3</div></td>
          <td class="rater"><div style="font-size:10pt;">4</div></td>
          <td class="rater"><div style="font-size:10pt;">5</div></td>
          <td class="rater"><div style="font-size:10pt;">6</div></td>
          <td class="rater"><div style="font-size:10pt;">7</div></td>
        </tr>
        <tr>
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
           <td class="bawahRaterSelected" >&nbsp;</td>
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
        </tr>
        <tr>
        <td class="radioRater" >
        <?php echo ($result_object['psikogram_cakim']['self_confidence'] == '1') ? 'x' : '';?>
        </td>
        <td class="radioRater" >
        <?php echo ($result_object['psikogram_cakim']['self_confidence'] == '2') ? 'x' : '';?>
        </td>
        <td class="radioRater" >
        <?php echo ($result_object['psikogram_cakim']['self_confidence'] == '3') ? 'x' : '';?>
        </td>
        <td class="radioRater" >
        <?php echo ($result_object['psikogram_cakim']['self_confidence'] == '4') ? 'x' : '';?>
        </td>
        <td class="radioRater" >
        <?php echo ($result_object['psikogram_cakim']['self_confidence'] == '5') ? 'x' : '';?>
        </td>
        <td class="radioRater" >
        <?php echo ($result_object['psikogram_cakim']['self_confidence'] == '6') ? 'x' : '';?>
        </td>
        <td class="radioRater" >
        <?php echo ($result_object['psikogram_cakim']['self_confidence'] == '7') ? 'x' : '';?>
        </td>
      </tr>
        <tr>
          <td rowspan="3" class="deskripsiCakim" width="38">
            <p align="center" >7</p>
          </td>
          <td rowspan="3" class="deskripsiCakim" width="800">
          <div style="font-size:10pt"><b>Teamwork</b>
          <br />Kemampuan bekerja secara efektif dalam kelompok dengan berbagi peran dan informasi untuk mencapai tujuuan atau
          target kerja kelompok</div></td>
          <td class="rater"><div style="font-size:10pt;">1</div></td>
          <td class="rater"><div style="font-size:10pt;">2</div></td>
          <td class="rater"><div style="font-size:10pt;">3</div></td>
          <td class="rater"><div style="font-size:10pt;">4</div></td>
          <td class="rater"><div style="font-size:10pt;">5</div></td>
          <td class="rater"><div style="font-size:10pt;">6</div></td>
          <td class="rater"><div style="font-size:10pt;">7</div></td>
        </tr>
        <tr>
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
           <td class="bawahRaterSelected" >&nbsp;</td>
          <td class="bawahRater" width="25px" />
          <td class="bawahRater" width="25px" />
        </tr>
        <tr>
        <td class="radioRater" >
        <?php echo ($result_object['psikogram_cakim']['teamwork'] == '1') ? 'x' : '';?>
        </td>
        <td class="radioRater" >
        <?php echo ($result_object['psikogram_cakim']['teamwork'] == '2') ? 'x' : '';?>
        </td>
        <td class="radioRater" >
        <?php echo ($result_object['psikogram_cakim']['teamwork'] == '3') ? 'x' : '';?>
        </td>
        <td class="radioRater" >
        <?php echo ($result_object['psikogram_cakim']['teamwork'] == '4') ? 'x' : '';?>
        </td>
        <td class="radioRater" >
        <?php echo ($result_object['psikogram_cakim']['teamwork'] == '5') ? 'x' : '';?>
        </td>
        <td class="radioRater" >
        <?php echo ($result_object['psikogram_cakim']['teamwork'] == '6') ? 'x' : '';?>
        </td>
        <td class="radioRater" >
        <?php echo ($result_object['psikogram_cakim']['teamwork'] == '7') ? 'x' : '';?>
        </td>
      </tr>

<?php

$totalSkor = 
$result_object['psikogram_cakim']['analisa_sintesa']+
$result_object['psikogram_cakim']['kemampuan_umum']+
$result_object['psikogram_cakim']['proses_belajar']+
$result_object['psikogram_cakim']['fleksibilitas']+
$result_object['psikogram_cakim']['integritas_diri']+
$result_object['psikogram_cakim']['loyalitas']+
$result_object['psikogram_cakim']['pengendalian_diri']+
$result_object['psikogram_cakim']['self_confidence']+
$result_object['psikogram_cakim']['stabilitas_emosi']+
$result_object['psikogram_cakim']['teamwork']+
$result_object['psikogram_cakim']['inisiatif']+
$result_object['psikogram_cakim']['kkk']+
$result_object['psikogram_cakim']['motivasi_prestasi']+
$result_object['psikogram_cakim']['sistematika_kerja']+
$result_object['psikogram_cakim']['berfikir_konseptual']
?>



        <tr>
          <td colspan="2"
          style="border-top:none;border-left: solid windowtext 1.0pt;border-bottom: solid windowtext 1.0pt;;border-right: solid windowtext 1.0pt;padding: 0in 5.4pt 0in 5.4pt;height:29.15pt"
          >
            <p align="right" style="text-align:right;">Total Skor</p>
          </td>
          <td colspan="8"
          style="border-top:none; border-left:none;border-bottom: solid windowtext 1.0pt;;border-right: solid windowtext 1.0pt;; padding:2px;height:29.15pt"
          >
            <center><?=$totalSkor;?></center>
          </td>
        </tr>

        <tr bgcolor='#C4D79B'>
          <td colspan="2"
          style="border-top: solid windowtext 1.0pt;;border-left: solid windowtext 1.0pt;border-bottom: solid windowtext 1.0pt;;border-right: solid windowtext 1.0pt;padding: 0in 5.4pt 0in 5.4pt;height:29.15pt"
          >
            <p align="left" style="margin-left:0in;text-align:left;">
              <b>D. ASPEK SELF APPEARANCE (KEPATUTAN DIRI)</b>
            </p>
          </td>
          <td colspan="8"
          style="border-top: solid windowtext 1.0pt;;border-left: none;border-bottom: solid windowtext 1.0pt;;border-right: solid windowtext 1.0pt;; padding:2px;height:29.15pt"
          >
            <p align="center" style="margin-left:0in;text-align: center;">
              <b>RATING</b>
            </p>
          </td>
        </tr>
        <tr>
          <td rowspan="3" class="deskripsiCakim" width="38">
            <p align="center">1</p>
          </td>
          <td rowspan="3" class="deskripsiCakim" width="800">
          <div style="font-size:10pt"><b>Penampilan Fisik secara Umum</b>
          <br />Memiliki berat dan tinggi badan yang seimbang / proporsional, tanpa adanya kecacatan fisik, serta dapat menunjukan
          perilaku optimal tanpa adanya gangguan gerakan lain.</div></td>
          <td colspan="4"  class="rater"><div style="font-size:10pt;"><center>0</center></div></td>
          <td colspan="4"  class="rater"><div style="font-size:10pt;"><center>1</center></div></td>
        </tr>
        <tr>
        <td colspan="4"  class="bawahRater"/>
        <td colspan="4"  class="bawahRaterSelected">&nbsp;</td>
        </tr>
        <tr style="height:16.4pt">
          <td colspan="4"
          style="width:63.75pt;border-top:none; border-left:none;border-bottom: solid windowtext 1.0pt;;border-right:solid windowtext 1.0pt; mso-border-bottom-alt: solid 1.0pt; padding:2px;height:16.4pt"
          width="85">
            <center>
            <?php echo ($result_object['psikogram_cakim']['penampilan_fisik'] == '0') ? 'x' : '';?>
            </center>
          </td>
          <td colspan="4"
          style="width:63.8pt;border-top:none; border-left:none;border-bottom: solid windowtext 1.0pt;;border-right: solid windowtext 1.0pt;; padding:2px;height:16.4pt"
          width="85">
            <center>
            <?php echo ($result_object['psikogram_cakim']['penampilan_fisik'] == '1') ? 'x' : '';?>
            </center>
          </td>
        </tr>

        <tr style="height:27.7pt">
          <td colspan="2"
          style="border-top:none;border-left: solid windowtext 1.0pt;border-bottom: solid windowtext 1.0pt;;border-right: solid windowtext 1.0pt;padding: 0in 5.4pt 0in 5.4pt;height:27.7pt"
          >
          <div style="font-size:10pt"> <p align="right" style="text-align:right;">Total Skor x Rating Self Appearance</p></div>
          </td>
          <td colspan="8"
          style="border-top:none;border-left: none;border-bottom: solid windowtext 1.0pt;;border-right: solid windowtext 1.0pt;; padding:2px;height:27.7pt"
          > <center><?=$totalSkor*$result_object['psikogram_cakim']['penampilan_fisik'];?></center></td>
        </tr>
      </table>

<br>
<?php
$finalscore = $totalSkor*$result_object['psikogram_cakim']['penampilan_fisik'];

if ($finalscore >=77) {
  $bgclolor1 = '#C4D79B';$bgclolor2 = '#ffffff';$bgclolor3 = '#ffffff';$bgclolor4 = '#ffffff';
}

else if ($finalscore >=68  &&  $finalscore  <= 76) {
  $bgclolor1 = '#ffffff';$bgclolor2 = '#C4D79B';$bgclolor3 = '#ffffff';$bgclolor4 = '#ffffff';

}
else if ($finalscore >=59  &&  $finalscore  <= 67) {
  $bgclolor1 = '#ffffff';$bgclolor2 = '#ffffff';$bgclolor3 = '#C4D79B';$bgclolor4 = '#ffffff';

}

else {
$bgclolor1 = '#ffffff';$bgclolor2 = '#ffffff';$bgclolor3 = '#ffffff';$bgclolor4 = '#C4D79B';
}

?>


<table border="1" cellpadding="1" cellspacing="1" class="MsoTableGrid" width="70%"
      style="border-right: solid windowtext 1.0pt;border-collapse:collapse; border:none; mso-padding-alt:0in 5.4pt 0in 5.4pt; padding:2px;"
      >
<thead>
<tr>
<td  colspan="6"><strong> <div style="font-size:10pt">KESIMPULAN  : </strong>Memperhatikan seluruh hasil penilaian Psikologis yang dimiliki, dikaitkan dengan kemungkinan keberhasilannya  untuk bekerja memikul beban tugas dan tanggung jawab kerja Sebagai Hakim, maka  pencalonannya :</div></td>
</tr>
</thead>
<tbody>
<tr bgcolor="#B8CCE4">
<th style="font-size:10pt;" colspan="2" rowspan="1" scope="col">KUALITAS</th>
<th  style="font-size:10pt;"colspan="1" rowspan="1" scope="col">REKOMENDASI</th>
<th style="font-size:10pt;" colspan="3" rowspan="1" scope="col">NORMA</th>
</tr>
<tr style="font-size:10pt;" class="baik"bgcolor="<?=$bgclolor1;?>">
<td>K-1</td>
<td>Baik</td>
<td>Dapat Disarankan</td>
<td colspan="3">77 ke atas</td>
</tr>
<tr style="font-size:10pt;" class="cukup" bgcolor="<?=$bgclolor2;?>">
<td>K-2</td>
<td>Cukup</td>
<td>Masih Dapat Disarankan</td>
<td colspan="3">68 - 76</td>
</tr>
<tr style="font-size:10pt;" class="kurang" bgcolor="<?=$bgclolor3;?>">
<td>K-3</td>
<td>Kurang</td>
<td>Kurang Dapat Disarankan</td>
<td colspan="3">59 - 67</td>
</tr>
<tr style="font-size:10pt;" class="buruk" bgcolor="<?=$bgclolor4;?>">
<td>K-4</td>
<td>Buruk</td>
<td>Tidak Dapat Disarankan</td>
<td colspan="3">58 - ke bawah</td>
</tr>
</tbody>
</table>

<br/>

<div class ='signatureRekomendasi'>
<div class='center' style = "font-size:11pt;position:absolute;top:850px;right:50px;">
	Jakarta, 11 Oktober 2017<br/>
	<strong>A.n PSIKOLOGI PEMERIKSA :<br/>
	<img height="40" width="200"src="<?=Url::base();?>/images/1/signature.png">
	<br/>
Drs. BUDIMAN SANUSI, M.Psi.<br/>
No. SIP : 07231221
</strong>
</div>
</div>       
</article>
 </section>



</body>

<?php 



//echo '<pre>';
//print_r($profile_object);
//print_r($result_object);
//print_r($activity_object);
    
    
    ?>