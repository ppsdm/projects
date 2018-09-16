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

    <h1>Aspek Kompetensi : Pengambilan Keputusan</h1>
<p>

Kemampuan membuat keputusan yang baik secara tepat waktu dan dengan keyakinan diri setelah mempertimbangkan prinsip kehati-hatian, dirumuskan secara sistematis dan seksama berdasarkan berbagai informasi, alternatif pemecahan masalah dan konsekuensinya, serta bertanggung jawab atas keputusan yang diambil.
</p>
    <?php $form = ActiveForm::begin(); ?>
<?php
$lki = $model->pengambilankeputusan_lki;
$uraian = $model->pengambilankeputusan_uraian;
$lkj_1 = $lkj->kompetensigram_pengambilankeputusan;
$indikator_1 = $model->pengambilankeputusan_indikator;

$model_lki = 'pengambilankeputusan_lki';
$model_uraian = 'pengambilankeputusan_uraian';

$keyvalue = 'pengambilankeputusan' . $lki;
$indikators = RefAssessmentDictionary::find()->andWhere(['key' => $keyvalue])->andWhere(['>', 'value',0])->asArray()->All();

$indikator = [

];


$gap = $lki - $lkj_1;
if ($gap > 0) {
	$gap = 0;
	}



$daftar_lki =  ['0' => '0','1' => '1 - Mengumpulkan informasi untuk bertindak sesuai kewenangan', 
		'2' => '2 - Menganalisis masalah secara mendalam', 
		'3' => '3 - Membandingkan berbagai alternatif, menyeimbangkan risiko keberhasilan dalam implementasi',
		 '4' => '4 - Menyelesaikan masalah yang mengandung risiko tinggi, mengantisipasi dampak keputusan, membuat tindakan pengamanan; mitigasi risiko', 
		 '5' => '5 - Menghasilkan solusi dan mengambil keputusan untuk mengatasi permasalahan jangka panjang/strategis, berdampak nasional'];

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
