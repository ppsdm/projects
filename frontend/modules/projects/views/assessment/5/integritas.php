<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\redactor\widgets\Redactor as Redactor;
use app\modules\projects\models\AssessmentReport;
use yii\bootstrap\Button;
use yii\bootstrap\Modal;

use kartik\widgets\DepDrop;
use yii\widgets\Pjax;
use yii\web\View;


$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>


    <div class="row">

            <?php $form = ActiveForm::begin(['id' => 'exsum-form']); ?>

			

<?php			
echo Html::label('LKI ', 'integritas_lki');
//echo ' ';
//Pjax::begin();
echo Html::dropDownList('integritas_lki',$assessment_report->integritas_lki,['1'=>'1 - Mampu bertindak sesuai nilai, norma,etika organisasi dalam kapasitas pribadi','2'=>'2 - Mampu bertindak sesuai nilai, norma,etika organisasi dalam kapasitas pribadi','3'=>'3 - Mampu bertindak sesuai nilai, norma,etika organisasi dalam kapasitas pribadi','4'=>'4 - Mampu bertindak sesuai nilai, norma,etika organisasi dalam kapasitas pribadi' ], ['id' => 'lki','prompt' => '--- select ---']);
//Pjax::end();


$indikator = [
    ['id' => '123', 'name' => 'aaa', 'class' => 'x'],
    ['id' => '124', 'name' => 'bbb', 'class' => 'x'],
    ['id' => '345', 'name' => 'ccc', 'class' => 'y'],
];

      $assessmentmodel = ProjectAssessment::find()
      ->andWhere(['activity_id' => $_GET['id']])
        ->andWhere(['status' => 'active'])->One();
        $resultmodel = ProjectAssessmentResult::find()
                ->andWhere(['project_assessment_id' => $assessmentmodel->id])
                ->andWhere(['type' => 'psikogram'])
                ->andWhere(['key' => $data->key])->One();
				
				
				echo Html::activeCheckboxList($assessment_report, 'integritas_lki', ArrayHelper::map($indikator, 'id', 'name'));
				
				


//Pjax::begin();
//echo Html::a('simpan LKI dan refresh daftar indikator', [null,null], ['value' => \yii\helpers\Url::to(['assessment/viewkamus']),'class'=>'btn btn-xs btn-primary']);
//Pjax::end();
//echo Html::button('Create List', ['id' => 'modelButton', 'value' => \yii\helpers\Url::to(['assessment/integritas']), 'class' => 'btn btn-success']);

echo Html::a('update indikator', ['assessment/integritas?id=35&lki=2'], ['class'=>'btn btn-xs btn-primary']);

echo '<br/><br/>';

 echo $form->field($assessment_report, 'indikator[]')->checkboxList(
			['1' => 'Bertingkah laku sesuai dengan perkataan; berkata sesuai dengan fakta;', '2' => 'Melaksanakan peraturan, kode etik organisasi dalam lingkungan kerja sehari- hari, pada tataran individu/pribadi;', '3' => 'Tidak menjanjikan/memberikan sesuatu yang bertentangan dengan aturan organisasi.']
   );
 
 
 echo '<br/><br/>';
 echo Html::a('refresh uraian', ['assessment/integritas?id=35&lki=2'], ['class'=>'btn btn-xs btn-primary']);
 echo '<br/>';
echo Html::label('Uraian Kamus ', 'integritas_info');
echo '<br/>';
if ($assessment_report->integritas_lki == 1)
	$contohkamus = 'Konsisten berperilaku selaras dengan nilai, norma dan/atau etika organisasi, dan jujur dalam hubungan dengan manajemen, rekan kerja, bawahan langsung, dan pemangku kepentingan, menciptakan budaya etika tinggi, bertanggungjawab atas tindakan atau keputusan beserta risiko yang menyertainya.';
else
	$contohkamus = 'Mampu memastikan, menanamkan keyakinan bersama agar anggota yang dipimpin bertindak sesuai nilai, norma, dan etika organisasi, dalam lingkup formal';
echo Html::textArea('integritas_info', $contohkamus, ['class' => 'form-control', 'readonly' => true]);
echo '<br/><br/>';
          
			

			
		echo "<div id='1' style='display: none;'>Level 1</div>";
echo "<div id='2' style='display: none;'>level 2</div>";
echo "<div id='3' style='display: none;'>level 3</div>";
echo "<div id='4' style='display: none;'>level 4</div>";		
			
			
echo $form->field($assessment_report, 'integritas')->widget(\yii\redactor\widgets\Redactor::className(), [
    'clientOptions' => [
        'plugins' => ['clips', 'fontcolor','fullscreen', 'counter']
    ]
]);


          	

?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Simpan'), ['class' => 'btn btn-primary']) ?>
    </div>

            <?php ActiveForm::end(); ?>
    
    </div>
</div>


<?php
            

    

			
			$this->registerJs(
    "$(function(){
    $('#modelButton').click(function(){
		$('#kamus').text($($(#lki).value()).text());
        
    });
});",
    View::POS_READY,
    'my-button-handler'
);


?>


