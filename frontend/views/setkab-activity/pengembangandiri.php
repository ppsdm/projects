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

    <h1>Aspek Kompetensi : Pengembangan Diri dan Orang Lain</h1>
<p>
Kemampuan untuk meningkatkan pengetahuan dan menyempurnakan keterampilan diri; menginspirasi orang lain untuk mengembangkan dan menyempurnakan pengetahuan dan keterampilan yang relevan dengan pekerjaan dan pengembangan karir jangka panjang, mendorong kemauan belajar sepanjang hidup, memberikan saran/bantuan, umpan balik, bimbingan untuk membantu orang lain untuk mengembangkan potensi dirinya.
</p>
    <?php $form = ActiveForm::begin(); ?>
<?php
$lki = $model->pengembangandiri_lki;
$uraian = $model->pengembangandiri_uraian;
$lkj_1 = $lkj->kompetensigram_pengembangandiri;
$indikator_1 = $model->pengembangandiri_indikator;

$model_lki = 'pengembangandiri_lki';
$model_uraian = 'pengembangandiri_uraian';

$keyvalue = 'pengembangandiri' . $lki;
$indikators = RefAssessmentDictionary::find()->andWhere(['key' => $keyvalue])->andWhere(['>', 'value',0])->asArray()->All();

$indikator = [

];


$gap = $lki - $lkj_1;
if ($gap > 0) {
	$gap = 0;
	}



$daftar_lki =  ['0' => '0','1' => '1 - Pengembangan diri',
		'2' => '2 - Meningkatkan kemampuan bawahan dengan memberikan contoh dan penjelasan cara melaksanakan suatu pekerjaan',
		'3' => '3 - Memberikan umpan balik, membimbing',
		 '4' => '4 - Menyusun program pengembangan jangka panjang dalam rangka mendorong manajemen pembelajaran',
		 '5' => '5 - Menciptakan situasi yang mendorong organisasi untuk mengembangkan kemampuan belajar secara berkelanjutan dalam rangka mendukung pencapaian hasil'];

echo    $form->field($model, $model_lki)->dropDownList($daftar_lki, ['prompt' => 'select...']);
echo Html::submitButton(Yii::t('app', 'Simpan LKI'), ['class' =>'btn btn-primary', 'value' => 'refresh', 'name'=>'submit2']);
echo '<h3>LKI = ' . $model->pengembangandiri_lki . '</h3>';
echo '<h3>LKJ = ' . $lkj_1 . '</h3>';
echo '<h3>GAP = ' . $gap . '</h3>';
echo '<hr/>';
$uraian_aspek = $model->pengembangandiri_lki;
if (isset($daftar_lki[$uraian_aspek] )) {
	echo '<h3>' . $daftar_lki[$uraian_aspek] . '</h3>';
} else {

}
echo '<p>';
				echo Html::label('Indikator Perilaku', $model_lki);
				echo '</p>';
				echo Html::activeCheckboxList($model, 'indikatorarraypengembangandiri', ArrayHelper::map($indikators, 'value', 'textvalue'));

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

$dom = new DOMDocument;
$li_count = 0;
$word_count = 0;

if (!empty($uraian)) {
$dom->loadHTML(HtmlPurifier::process($uraian));

$new_element = $dom->createElement('test', ' ');
    foreach($dom->getElementsByTagName('li') as $li) {
        $li_count = $li_count + str_word_count(strip_tags($li->textContent));
    }



       $replaced_dom = preg_replace('#\<(.+?)\>#', ' ', $dom->saveHTML());
        $word_count = str_word_count(strip_tags($replaced_dom));
	}
	
		$total_count = $word_count;
		



echo $hint_text = 'words : ' . $total_count . ' , characters : ' . strlen(str_replace(' ','',strip_tags($uraian)));
			echo '</p>';
?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Simpan Uraian') : Yii::t('app', 'Update Uraian'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'value' => 'update', 'name' => 'submit2']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
