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

    <h1>Aspek Kompetensi : Perekat Bangsa</h1>
<p>

Kemampuan dalam mempromosikan sikap toleransi, keterbukaan, peka terhadap perbedaan individu/kelompok masyarakat; mampu menjadi perpanjangan tangan pemerintah dalam mempersatukan masyarakat dan membangun hubungan sosial psikologis dengan masyarakat di tengah kemajemukan Indonesia sehingga menciptakan kelekatan yang kuat antara ASN dan para pemangku kepentingan serta diantara para pemangku kepentingan itu sendiri; menjaga, mengembangkan, dan mewujudkan rasa persatuan dan kesatuan dalam kehidupan bermasyarakat, berbangsa dan bernegara Indonesia
</p>
    <?php $form = ActiveForm::begin(); ?>
<?php
$lki = $model->perekatbangsa_lki;
$uraian = $model->perekatbangsa_uraian;
$lkj_1 = $lkj->kompetensigram_perekatbangsa;
$indikator_1 = $model->perekatbangsa_indikator;

$model_lki = 'perekatbangsa_lki';
$model_uraian = 'perekatbangsa_uraian';

$keyvalue = 'perekatbangsa' . $lki;
$indikators = RefAssessmentDictionary::find()->andWhere(['key' => $keyvalue])->andWhere(['>', 'value',0])->asArray()->All();

$indikator = [

];


$gap = $lki - $lkj_1;
if ($gap > 0) {
	$gap = 0;
	}



$daftar_lki =  ['0' => '0','1' => '1 - Peka memahami dan menerima kemajemukan', 
		'2' => '2 - Aktif mengembangkan sikap saling menghargai, menekankan persamaan dan persatuan', 
		'3' => '3 - Mempromosikan, mengembangkan sikap toleransi dan persatuan',
		 '4' => '4 - Mendayagunakan perbedaan secara konstruktif dan kreatif untuk meningkatkan efektifitas organisasi', 
		 '5' => '5 - Wakil pemerintah untuk membangun hubungan sosial psikologis'];

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
