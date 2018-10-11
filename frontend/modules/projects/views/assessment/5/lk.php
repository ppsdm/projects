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

?>

            <table border="0" cellpadding="0" cellspacing="0" class="MsoNormalTable" width="80%">
	<tr>
		<td colspan="3" nowrap style="border-top: solid windowtext 1.0pt;border-left: solid windowtext 1.0pt;;border-bottom: solid black 1.0pt;border-right:none;padding:3px;" >
			<p style="text-align:center">
				<b>HASIL PEMERIKSAAN PSIKOLOGIS</b>
			</p>
		</td>
		<td nowrap style="border-top: solid windowtext 1.0pt;; border-left:solid windowtext 1.0pt;border-bottom:solid black 1.0pt; border-right: solid windowtext 1.0pt;;padding:3px;" >
			<p style="text-align:center">
				<b>KETERANGAN</b>
			</p>
		</td>
	</tr>
	<tr>
		<td nowrap style="border:none;border-left: solid windowtext 1.0pt;; padding:3px;" >Nomor Psikotest</td>
		<td nowrap style="padding:3px; " >
			<p style="text-align:center">:</p>
		</td>
		<td nowrap style="padding:3px; "  >
			<?php echo Html::input('text', 'psikotes_no', $psikotes_no, ['class' => 'form-control', 'readonly' => true]);?></td>
		<td nowrap style="border-top:none;border-left:solid windowtext 1.0pt; border-bottom:none;border-right: solid windowtext 1.0pt;;padding:3px; " >
			<p>....</p>
		</td>
	</tr>
    <tr>
        <td nowrap style="border:none;border-left: solid windowtext 1.0pt;; padding:3px;" >Nomor Registrasi</td>
        <td nowrap style="padding:3px; " >
            <p style="text-align:center">:</p>
        </td>
        <td nowrap style="padding:3px; "  >
            <?php echo Html::input('text', 'reg_no', $reg_no, ['class' => 'form-control' , 'readonly' => true]);?></td>
        <td nowrap style="border-top:none;border-left:solid windowtext 1.0pt; border-bottom:none;border-right: solid windowtext 1.0pt;;padding:3px; " >
            <p>....</p>
        </td>
    </tr>
	<tr>
		<td nowrap style="border:none;border-left: solid windowtext 1.0pt;; padding:3px;" >Nama Lengkap		</td>
		<td nowrap style="padding:3px;" >
			<p style="text-align:center;">:</p>
		</td>
		<td nowrap style="padding:3px;"  >
			<?php echo Html::input('text', 'first_name' , $prof->first_name, ['class' => 'form-control']);?></td>
		<td nowrap style="border-top:none;border-left:solid windowtext 1.0pt; border-bottom:none;border-right: solid windowtext 1.0pt;;padding:3px; " >7: Very Above Average</td>
	</tr>
	<tr >
		<td nowrap style="border:none;border-left: solid windowtext 1.0pt;; padding:3px;">Tempat, Tgl lahir</td>
		<td nowrap style="padding:3px; " >
			<p style="text-align:center">:</p>
		</td>
		<td nowrap style="padding:3px; "  >
			<?php echo Html::input('text', 'birthplace', $birthplace, ['class' => 'form-control']);?>
			<?php echo DatePicker::widget([
    'name' => 'birthdate',
    'type' => DatePicker::TYPE_INPUT,
    'value' => $birthdate,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd'
    ]
]);
?></td>
		<td nowrap style="border-top:none;border-left:solid windowtext 1.0pt; border-bottom:none;border-right: solid windowtext 1.0pt;;padding:3px; " >
			<p>6 : Above Average
			</p>
		</td>
	</tr>
	<tr >
		<td nowrap style="border:none;border-left: solid windowtext 1.0pt;; padding:3px;" >Pekerjaan Saat Ini</td>
		<td nowrap style="padding:3px; " >
			<p style="text-align:center">:</p>
		</td>
		<td nowrap style="padding:3px; "  >
			<?php echo Html::input('text', 'current_job', $current_job, ['class' => 'form-control']);?></td>
		<td nowrap style="border-top:none;border-left:solid windowtext 1.0pt; border-bottom:none;border-right: solid windowtext 1.0pt;;padding:3px; " >
			<p>5 : High Average <span/>
			</p>
		</td>
	</tr>
	<tr >
		<td nowrap style="border:none;border-left: solid windowtext 1.0pt;; padding:3px;">Jenis Kelamin</td>
		<td nowrap style="padding:3px; " >
			<p style="text-align:center">:</p>
		</td>
		<td nowrap style="padding:3px; "  >
			<?php echo Html::input('text', 'gender', $gender, ['class' => 'form-control']);?></td>
		<td nowrap style="border-top:none;border-left:solid windowtext 1.0pt; border-bottom:none;border-right: solid windowtext 1.0pt;;padding:3px; " >
			<p>4 : Average</p>
		</td>
	</tr>
	<tr >
		<td nowrap style="border:none;border-left: solid windowtext 1.0pt;; padding:3px;">Prospek Jabatan</td>
		<td nowrap style="padding:3px; " >
			<p style="text-align:center">:</p>
		</td>
		<td nowrap style="padding:3px; "  >
			<?php echo Html::input('text', 'job_prospect', $job_prospect, ['class' => 'form-control']);?></td>
		<td nowrap style="border-top:none;border-left:solid windowtext 1.0pt; border-bottom:none;border-right: solid windowtext 1.0pt;;padding:3px; " >
			<p>3 : Low Average</p>
		</td>
	</tr>
	<tr>
		<td nowrap style="border:none;border-left: solid windowtext 1.0pt;; padding:3px;" >Pendidikan Terakhir</td>
		<td nowrap style="padding:3px; " >
			<p style="text-align:center;">:</p>
		</td>
		<td nowrap style="padding:3px; "  >
			<?php echo Html::input('text', 'latest_education', $latest_education, ['class' => 'form-control']);?></td>
		<td nowrap style="border-top:none;border-left:solid windowtext 1.0pt; border-bottom:none;border-right: solid windowtext 1.0pt;;padding:3px; " >
			<p>2 : Below Average</p>
		</td>
	</tr>
	<tr>
		<td nowrap style="border:none;border-left: solid windowtext 1.0pt;; padding:3px;">Asal Perguruan Tinggi</td>
		<td nowrap style="padding:3px; " >
			<p style="text-align:center">:</p>
		</td>
		<td nowrap style="padding:3px; "  >
			<?php echo Html::input('text', 'univ', $univ, ['class' => 'form-control']);
?></td>
		<td nowrap style="border-top:none;border-left:solid windowtext 1.0pt; border-bottom:none;border-right: solid windowtext 1.0pt;;padding:3px; " >
			<p>1 : Very Below Average</p>
		</td>
	</tr>
	<tr style="mso-yfti-irow:10;mso-yfti-lastrow:yes;">
		<td nowrap style="border-top:none;border-left: solid windowtext 1.0pt;; border-bottom: solid windowtext 1.0pt;;border-right:none;padding:3px; ">Tempat / Tanggal Test</td>
		<td nowrap style="border:none;border-bottom: solid windowtext 1.0pt;; padding:3px;" >
			<p style="text-align:center">:</p>
		</td>
		<td nowrap style="border:none;border-bottom: solid windowtext 1.0pt;padding:3px;"  >
			<?php echo Html::input('text', 'schedule_place', $schedule_place, ['class' => 'form-control', 'readonly' => true]);?>
<?php echo Html::input('text', 'schedule_time', $schedule_time, ['class' => 'form-control', 'readonly' => true]);?>
		</td>
		<td nowrap style="border-top:none;border-left:solid windowtext 1.0pt; border-bottom: solid windowtext 1.0pt;;border-right: solid windowtext 1.0pt;; padding:3px;" >
			<p>....</p>
		</td>
	</tr>
</table>
