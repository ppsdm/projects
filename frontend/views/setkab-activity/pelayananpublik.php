<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\redactor\widgets\Redactor as Redactor;
use yii\web\View;
use yii\helpers\ArrayHelper;
use common\modules\catalog\models\RefAssessmentDictionary;
/* @var $this yii\web\View */
/* @var $model frontend\models\SetkabActivity */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Setkab Activity',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Setkab Activities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="setkab-activity-update">

    <h1>Aspek Kompetensi : Pelayanan Publik</h1>
<p>
Kemampuan dalam melaksanakan tugas-tugas pemerintahan, pembangunan dan kegiatan pemenuhan kebutuhan pelayanan publik secara profesional, transparan, mengikuti standar pelayanan yang objektif, netral, tidak memihak, tidak diskriminatif, serta tidak terpengaruh kepentingan pribadi/kelompok/golongan/partai politik    <?php $form = ActiveForm::begin(); ?>
</p>
<?php
$lki = $model->pelayananpublik_lki;
$uraian = $model->pelayananpublik_uraian;
$lkj_1 = $lkj->kompetensigram_pelayananpublik;
$indikator_1 = $model->pelayananpublik_indikator;

$model_lki = 'pelayananpublik_lki';
$model_uraian = 'pelayananpublik_uraian';

$keyvalue = 'pelayananpublik' . $lki;
$indikators = RefAssessmentDictionary::find()->andWhere(['key' => $keyvalue])->andWhere(['>', 'value',0])->asArray()->All();

$indikator = [

];


$gap = $lki - $lkj_1;
if ($gap > 0) {
	$gap = 0;
	}



$daftar_lki =  ['0' => '0','1' => '1 - Menjalankan tugas mengikuti standar pelayanan.', 
		'2' => '2 - Mampu mensupervisi/mengawasi/menyelia dan menjelaskan proses pelaksanaan tugas-tugas pemerintahan/pelayanan publik secara transparan', 
		'3' => '3 - Mampu memanfaatkan kekuatan kelompok serta memperbaiki standar pelayanan publik di lingkup unit kerja',
		 '4' => '4 - Mampu memonitor, mengevaluasi, memperhitungkan dan mengantisipasi dampak dari isu-isu jangka panjang, kesempatan, atau kekuatan politik dalam hal pelayanan kebutuhan pemangku kepentingan yang transparan, objektif, dan profesional', 
		 '5' => '5 - Mampu memastikan kebijakan kebijakan pelayanan publik yang menjamin terselenggaranya pelayanan publik yang objektif, netral, tidak memihak, tidak diskriminatif, serta tidak terpengaruh kepentingan pribadi/kelompok/partai politik.'];

echo    $form->field($model, $model_lki)->dropDownList($daftar_lki, ['prompt' => 'select...']);
echo Html::submitButton(Yii::t('app', 'Simpan LKI'), ['class' =>'btn btn-primary', 'value' => 'refresh', 'name'=>'submit2']);
echo '<h3>LKJ = ' . $lkj_1 . '</h3>';
echo '<h3>GAP = ' . $gap . '</h3>';
echo '<hr/>';
echo '<p>';
				echo Html::label('Indikator Perilaku', $model_lki);
				echo '</p>';
				echo Html::activeCheckboxList($model, 'indikatorarray', ArrayHelper::map($indikators, 'value', 'textvalue'));
				
                                echo Html::submitButton(Yii::t('app', 'Tunjukkan usulan uraian'), ['class' =>'btn btn-primary', 'value' => 'refresh', 'name'=>'submit2']);
                                echo '<hr/>';
				echo '<p>';

				$uraian_kamus = "";

				$activeIndikators = explode(',', str_replace(['[', ']', '"'], '', $indikator_1));
				foreach($activeIndikators as $activeIndikator) {
					foreach($indikators as $indikator) {
						if ($indikator['value'] == $activeIndikator) {
							$uraian_kamus .= $indikator['textvalue'] . "\n";
						}
					}
				}

				echo Html::label('Uraian Kamus', 'uraian_kamus');
				echo '</p>';
echo '<p>';


				echo Html::textArea('uraian_kamus', $uraian_kamus,['readonly' => true, 'rows' => '6', 'cols' => '100', 'disable' => true]);
				echo '</p>';

				
echo '<p>';


	echo $form->field($model, $model_uraian)->widget(\yii\redactor\widgets\Redactor::className(), [

    'clientOptions' => [
		'plugins' => ['clips', 'fontcolor','fullscreen', 'counter']
    ]
]);
echo $hint_text = 'words : ' . str_word_count(strip_tags($uraian)) . ' , characters : ' . strlen(str_replace(' ','',strip_tags($uraian)));
			echo '</p>';
?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Simpan Uraian') : Yii::t('app', 'Update Uraian'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'value' => 'update', 'name' => 'submit2']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
