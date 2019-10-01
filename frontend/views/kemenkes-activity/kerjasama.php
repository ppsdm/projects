<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\redactor\widgets\Redactor as Redactor;
use yii\web\View;
use yii\helpers\ArrayHelper;
use common\modules\catalog\models\RefAssessmentDictionary;
use yii\helpers\HtmlPurifier;
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

    <h1>Aspek Kompetensi : Kerjasama</h1>
<p>
Kemampuan menjalin, membina, mempertahankan hubungan kerja yang efektif, memiliki komitmen saling membantu dalam penyelesaian tugas, dan mengoptimalkan segala sumberdaya untuk mencapai tujuan strategis organisasi.
</p>
    <?php $form = ActiveForm::begin(); ?>
<?php


$keyvalue = 'kerjasama' . $model->kerjasama_lki;
$indikators = RefAssessmentDictionary::find()->andWhere(['key' => $keyvalue])->andWhere(['>', 'value',0])->asArray()->All();
$indikator = [

];


$gap = $model->kerjasama_lki - $lkj->kompetensigram_kerjasama;
if ($gap > 0) {
	$gap = 0;
	}



$daftar_lki =  ['0' => '0','1' => '1 - Berpartisipasi dalam kelompok kerja',
		'2' => '2 - Menumbuhkan tim kerja yang partisipatif dan efektif',
		'3' => '3 - Efektif membangun tim kerja untuk peningkatan kinerja organisasi',
		 '4' => '4 - Membangun komitmen tim, sinergi',
		 '5' => '5 - Menciptakan situasi kerja sama secara konsisten, baik di dalam maupun di luar instansi'];

echo    $form->field($model, 'kerjasama_lki')->dropDownList($daftar_lki, ['prompt' => 'select...']);
echo Html::submitButton(Yii::t('app', 'Simpan LKI'), ['class' =>'btn btn-primary', 'value' => 'refresh', 'name'=>'submit2']);
echo '<h3>LKI = ' . $model->kerjasama_lki . '</h3>';
echo '<h3>LKJ = ' . $lkj->kompetensigram_kerjasama . '</h3>';
echo '<h3>GAP = ' . $gap . '</h3>';
echo '<hr/>';
$uraian_aspek = $model->kerjasama_lki;
if (isset($daftar_lki[$uraian_aspek] )) {
	echo '<h3>' . $daftar_lki[$uraian_aspek] . '</h3>';
} else {

}
echo '<p>';
				echo Html::label('Indikator Perilaku', 'kerjasama_lki');
				echo '</p>';
				echo Html::activeCheckboxList($model, 'indikatorarraykerjasama', ArrayHelper::map($indikators, 'value', 'textvalue'));

                                echo Html::submitButton(Yii::t('app', 'Tunjukkan usulan uraian'), ['class' =>'btn btn-primary', 'value' => 'refresh', 'name'=>'submit2']);
                                echo '<hr/>';
				echo '<p>';

				$uraian_kamus = "";

				$activeIndikators = explode(',', str_replace(['[', ']', '"'], '', $model->kerjasama_indikator));
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


	echo $form->field($model, 'kerjasama_uraian')->widget(\yii\redactor\widgets\Redactor::className(), [

    'clientOptions' => [
		'plugins' => ['clips', 'fontcolor','fullscreen', 'counter']
    ]
]);

$dom = new DOMDocument;
$li_count = 0;
$word_count = 0;

if (!empty($model->kerjasama_uraian)) {
$dom->loadHTML(HtmlPurifier::process($model->kerjasama_uraian));

$new_element = $dom->createElement('test', ' ');
    foreach($dom->getElementsByTagName('li') as $li) {
        $li_count = $li_count + str_word_count(strip_tags($li->textContent));
    }



       $replaced_dom = preg_replace('#\<(.+?)\>#', ' ', $dom->saveHTML());
        $word_count = str_word_count(strip_tags($replaced_dom));
	}
	
		$total_count = $word_count;
		

echo $hint_text = 'words : ' . $total_count . ' , characters : ' . strlen(str_replace(' ','',strip_tags($model->kerjasama_uraian)));
			echo '</p>';
?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Simpan Uraian') : Yii::t('app', 'Update Uraian'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'value' => 'update', 'name' => 'submit2']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>




<?php

			$this->registerJs(
    "$(function(){
    $('#setkabactivity-kerjasama_lki').change(function(){


    });
});",
    View::POS_READY,
    'my-button-handler'
);


?>
