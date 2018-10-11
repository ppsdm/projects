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

    <h1>Aspek Kompetensi : Orientasi pada Hasil</h1>
<p>
Kemampuan mempertahankan komitmen pribadi yang tinggi untuk menyelesaikan tugas, dapat diandalkan, bertanggung jawab, mampu secara sistimatis mengidentifikasi risiko dan peluang dengan memperhatikan keterhubungan antara perencanaan dan hasil, untuk keberhasilan organisasi.</p>
</p>
    <?php $form = ActiveForm::begin(); ?>
<?php
$lki = $model->orientasihasil_lki;
$uraian = $model->orientasihasil_uraian;
$lkj_1 = $lkj->kompetensigram_orientasihasil;
$indikator_1 = $model->orientasihasil_indikator;

$model_lki = 'orientasihasil_lki';
$model_uraian = 'orientasihasil_uraian';

$keyvalue = 'orientasihasil' . $lki;
$indikators = RefAssessmentDictionary::find()->andWhere(['key' => $keyvalue])->andWhere(['>', 'value',0])->asArray()->All();

$indikator = [

];


$gap = $lki - $lkj_1;
if ($gap > 0) {
	$gap = 0;
	}



$daftar_lki =  ['0' => '0','1' => '1 - Bertanggung jawab untuk memenuhi standar kerja',
		'2' => '2 - Berupaya meningkatkan hasil kerja pribadi yang lebih tinggi dari standar yang ditetapkan, mencari, mencoba metode alternatif untuk peningkatan kinerja',
		'3' => '3 - Menetapkan target kerja yang menantang bagi unit kerja, memberi apresiasi dan teguran untuk mendorong kinerja',
		 '4' => '4 - Mendorong unit kerja mencapai target yang ditetapkan atau melebihi hasil kerja sebelumnya',
		 '5' => '5 - Meningkatkan mutu pencapaian kerja organisasi'];

echo    $form->field($model, $model_lki)->dropDownList($daftar_lki, ['prompt' => 'select...']);
echo Html::submitButton(Yii::t('app', 'Simpan LKI'), ['class' =>'btn btn-primary', 'value' => 'refresh', 'name'=>'submit2']);
echo '<h3>LKI = ' . $model->orientasihasil_lki . '</h3>';
echo '<h3>LKJ = ' . $lkj_1 . '</h3>';
echo '<h3>GAP = ' . $gap . '</h3>';
echo '<hr/>';
$uraian_aspek = $model->orientasihasil_lki;
if (isset($daftar_lki[$uraian_aspek] )) {
	echo '<h3>' . $daftar_lki[$uraian_aspek] . '</h3>';
} else {

}
echo '<p>';
				echo Html::label('Indikator Perilaku', $model_lki);
				echo '</p>';
				echo Html::activeCheckboxList($model, 'indikatorarrayorientasihasil', ArrayHelper::map($indikators, 'value', 'textvalue'));

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

        foreach($dom->getElementsByTagName('ul') as $ul) {
            $ul->parentNode->replaceChild($new_element,$ul);
            $dom->saveHTML();
    
        }
        foreach($dom->getElementsByTagName('ol') as $ol) {
            $ol->parentNode->replaceChild($new_element,$ol);
            $dom->saveHTML();
    
        }


       $replaced_dom = preg_replace('#\<(.+?)\>#', ' ', $dom->saveHTML());
        $word_count = str_word_count(strip_tags($replaced_dom));
	}
	
		$total_count = $word_count + $li_count;
		


echo $hint_text = 'words : ' . $total_count . ' , characters : ' . strlen(str_replace(' ','',strip_tags($uraian)));
			echo '</p>';
?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Simpan Uraian') : Yii::t('app', 'Update Uraian'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'value' => 'update', 'name' => 'submit2']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
