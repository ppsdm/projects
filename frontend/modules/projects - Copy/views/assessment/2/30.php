<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

use yii\web\View;
use app\assets\AppAsset;
use yii\helpers\ArrayHelper;

use app\modules\projects\models\Project;
use app\modules\projects\models\ProjectMeta;
use app\modules\projects\models\ProjectActivity;
use app\modules\projects\models\ProjectAssessmentResult;
use app\modules\projects\models\ProjectAssessment;
use app\modules\projects\models\ProjectActivityMeta;
use common\modules\profile\models\ProfileMeta;
use common\modules\profile\models\Profile;
use common\modules\catalog\models\RefAssessmentDictionary;
use common\modules\core\models\RefScale;
use common\modules\catalog\models\CatalogMeta;
use common\modules\catalog\models\Catalog;
use app\modules\projects\models\AssessmentReport;
use app\modules\projects\models\Kompetensigram;

use kartik\grid\GridView;
use kartik\form\ActiveForm;

use yii\widgets\ListView;
use kartik\editable\Editable;
use yii\data\SqlDataProvider;
//use vova07\imperavi\Widget as Redactor;

use yii\redactor\widgets\Redactor as Redactor;



//use Yii;

?>



<head>
<link rel="stylesheet" type="text/css" href="/css/psikogramTable.css">
</head>


<?php




$user_profile = Profile::find()->andWhere(['user_id' => Yii::$app->user->id])->One();

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


$PArp = 0;
$PArk = 0;

$this->context->initAssessment($_GET['id'], $catalog_id);
//Yii::$app->runAction('activity/initassessment', ['id' => $_GET['id'], 'catalog_id' => $catalog_id]);

   $Pa = ProjectAssessment::find()->andWhere(['activity_id'=> $_GET['id']])->One();
   
   $PArp = ProjectAssessmentResult::find()->andWhere(['type'=>'psikogram'])->andWhere(['project_assessment_id'=>$Pa->id])->Sum('value');
   $PArk = ProjectAssessmentResult::find()->andWhere(['type'=>'kompetensigram'])->andWhere(['project_assessment_id'=>$Pa->id])->Sum('value');

   $sumC =     CatalogMeta::find()->andWhere(['catalog_id'=>$Pa->catalog_id])->andWhere(['type'=>'kompetensigram'])->andWhere(['key'=>'kompetensi'])->Sum('attribute_1');

   //echo $PArp/66*100 .'<br/>';
   //echo $PArk/$sumC*100 .'<br/>';

   $saran_komplit = '';

   $cfit_key = ['SUBTEST_1_TC', 'SUBTEST_2_TC', 'SUBTEST_3_TC', 'SUBTEST_4_TC'];






$cfit_result = ProjectAssessmentResult::find()
->andWhere(['project_assessment_id' => $Pa->id])
->andWhere(['in', 'key', $cfit_key])->All();


$cfit_raw = ProjectAssessmentResult::find()
->andWhere(['project_assessment_id' => $Pa->id])
->andWhere(['in', 'key', $cfit_key])->Sum('value');
$cfit_obj = RefScale::find()->andWhere(['type' => 'cakim'])->andWhere(['name' => 'cfit'])
->andWhere(['raw' =>$cfit_raw])->One();
$cfit = $cfit_obj->scaled;
$iq_obj = RefScale::find()->andWhere(['type' => 'cakim'])->andWhere(['name' => 'cfit2iq'])
->andWhere(['raw' =>$cfit_raw])->One();
$iq = $iq_obj->scaled;


$com_raw = ProjectAssessmentResult::find()
->andWhere(['project_assessment_id' => $Pa->id])
->andWhere(['in', 'key', ['SUBTEST_5_TC']])->Sum('value');
$com_obj = RefScale::find()->andWhere(['type' => 'cakim'])->andWhere(['name' => 'compre'])
->andWhere(['raw' =>$com_raw])->One();
$com = $com_obj->scaled;


$inf_raw = ProjectAssessmentResult::find()
->andWhere(['project_assessment_id' => $Pa->id])
->andWhere(['in', 'key', ['SUBTEST_6_TC']])->Sum('value');
$inf_obj = RefScale::find()->andWhere(['type' => 'cakim'])->andWhere(['name' => 'info'])
->andWhere(['raw' =>$inf_raw])->One();
$inf = $inf_obj->scaled;


$log_raw = ProjectAssessmentResult::find()
->andWhere(['project_assessment_id' => $Pa->id])
->andWhere(['in', 'key', ['SUBTEST_7_TC']])->Sum('value');
$log_obj = RefScale::find()->andWhere(['type' => 'cakim'])->andWhere(['name' => 'logika'])
->andWhere(['raw' =>$log_raw])->One();
$log = $log_obj->scaled;


$anv_raw = ProjectAssessmentResult::find()
->andWhere(['project_assessment_id' => $Pa->id])
->andWhere(['in', 'key', ['SUBTEST_8_TC']])->Sum('value');
$anv_obj = RefScale::find()->andWhere(['type' => 'cakim'])->andWhere(['name' => 'analogi'])
->andWhere(['raw' =>$anv_raw])->One();
$anv = $anv_obj->scaled;


$art_raw = ProjectAssessmentResult::find()
->andWhere(['project_assessment_id' => $Pa->id])
->andWhere(['in', 'key', ['SUBTEST_9_TC']])->Sum('value');
$art_obj = RefScale::find()->andWhere(['type' => 'cakim'])->andWhere(['name' => 'arith'])
->andWhere(['raw' =>$art_raw])->One();
$art = $art_obj->scaled;


$adm_raw = ProjectAssessmentResult::find()
->andWhere(['project_assessment_id' => $Pa->id])
->andWhere(['in', 'key', ['SUBTEST_10_TC']])->Sum('value');
$adm_obj = RefScale::find()->andWhere(['type' => 'cakim'])->andWhere(['name' => 'admin'])
->andWhere(['raw' =>$adm_raw])->One();
$adm = $adm_obj->scaled;

$total = $cfit + $com + $inf + $log + $anv + $art + $adm;
/*
echo 'TOTAL = ' . $total;
echo '<br>';
echo 'IQ =' . $iq;
echo '<br>';
*/
$subtest11_obj = ProjectAssessmentResult::find()
->andWhere(['project_assessment_id' => $Pa->id])
->andWhere(['key' =>'SUBTEST_11'])->One();
$subtest11 = strtolower(trim($subtest11_obj->value));

   $scores = [];
   $scores = processor_kostik($subtest11, $scores);

//echo 'subtest 11 ' . $subtest11;
//echo '<pre>';
//print_r($scores);

    $kompetensigram_models = $kompetensiDataProvider->getModels();
    foreach ($kompetensigram_models as $kompkey => $kompvalue) {
        $result_object['kompetensigram'][$kompvalue['key']]['lki'] = isset($kompvalue['value']) ? $kompvalue['value'] : 0 ;
        $x = CatalogMeta::find()->andWhere(['type' => 'kompetensigram'])->andWhere(['key' => 'kompetensi'])->andWhere(['catalog_id'=> $catalog_id])
        ->andWhere(['value' => $kompvalue['key']])->One();
    $result_object['kompetensigram'][$kompvalue['key']]['lkj'] = $x->attribute_1;
    }
     


       
?>

<?php

$colorPluginOptions =  [
    'showPalette' => true,
    'showPaletteOnly' => true,
    'showSelectionPalette' => true,
    'showAlpha' => false,
    'allowEmpty' => false,
    'preferredFormat' => 'name',
    'palette' => [
        [
            "white", "black", "grey", "silver", "gold", "brown", 
        ],
        [
            "red", "orange", "yellow", "indigo", "maroon", "pink"
        ],
        [
            "blue", "green", "violet", "cyan", "magenta", "purple", 
        ],
    ]
];


$psikogramGridColumns = [
/*[
  'label' => 'order',
  'attribute' => 'order',
   'value' => 'order',
],
*/
[
        'class'=>'kartik\grid\EditableColumn',
            'contentOptions' => ['style' => 'max-width:0px;'],
      'attribute' => 'id',
      'header' => '&nbsp;',
        'width'=>'0px',
      'hidden' => true,
      'content' => function($data){
        return '&nbsp;';
      },
      'editableOptions'=>['header'=>'Name', 'size'=>'sm' ,'class' => 'hidden']
    ],
    [
    'label' => 'Kategori',
    'value' => function($data) use ($catalog_id){
      $lkj = CatalogMeta::find()
      ->andWhere(['catalog_id' => $catalog_id])
        ->andWhere(['type' => 'psikogram'])
        ->andWhere(['key' => 'aspek'])
        ->andWhere(['value' => $data->key])->One();
      return $lkj->attribute_2;
    },
    'contentOptions' => ['style'=>' white-space: normal;'],
  ],
  [
    'label' => 'Aspek psikologis',
    'value' => function($data){
        $deskripsi = RefAssessmentDictionary::find()
        ->andWhere(['type' => 'psikogram'])
        ->andWhere(['key' => 'aspek'])
        ->andWhere(['value' => $data->key])->One();
        return $deskripsi->attribute_1;
    },
    'contentOptions' => ['style'=>'white-space: normal;'],
  ],
  [
    'label' => 'Keterangan',
    'value' => function($data){
        $deskripsi = RefAssessmentDictionary::find()
        ->andWhere(['type' => 'psikogram'])
        ->andWhere(['key' => 'aspek'])
        ->andWhere(['value' => $data->key])->One();
        return $deskripsi->attribute_2;
    },
    'contentOptions' => ['style'=>'width:350px; white-space: normal;'],

  ],

      [
        'label' => 'Skor',
           'pageSummary' => true,
           'attribute' => 'value',
    ],
    'type',

  [
    'class'=>'kartik\grid\EditableColumn',
    'label' => 'Penilaian',
    'attribute'=>'value',
    'format' => 'raw',
    'value' => function($data) use ($catalog_id, $readonly){

$radiolistoptions = [1 => '1',2 => '2',3=>'3',4=>'4',5=>'5',6=>'6',7 =>'7'];
      $assessmentmodel = ProjectAssessment::find()
      ->andWhere(['activity_id' => $_GET['id']])
        ->andWhere(['status' => 'active'])->One();
        $resultmodel = ProjectAssessmentResult::find()
                ->andWhere(['project_assessment_id' => $assessmentmodel->id])
                ->andWhere(['type' => 'psikogram'])
                ->andWhere(['key' => $data->key])->One();
return Html::RadioList($data->key, $resultmodel->value, $radiolistoptions, [
    'item' => function($index, $label, $name, $checked, $value) use ($readonly)
              {
                $aspek = CatalogMeta::find()->andWhere(['type' => 'psikogram'])->andWhere(['key' => 'aspek'])->andWhere(['value' => $name])->One();
                $islkj = '';
                if ($index == ($aspek->attribute_1-1)) {
                 // $islkj = 'RadioBox2';
                  return "<div class='RadioBox2'>".Html::Label(Html::Radio($name,$checked,['class' => 'RadioBox2', 'disabled' => $readonly]) .' '. $label)."</div>";
                }
            else {
                            return "<div class='RadioBox'>".Html::Label(Html::Radio($name,$checked,['class' => 'RadioBox', 'disabled' => $readonly]) .' '. $label)."</div>";
                            
                        }   
              },
              
    
    ]);
    },
  
    'vAlign'=>'middle',
    'width'=>'100px',
    /*'readonly'=>function($model, $key, $index, $widget) {
      //  return (!$mail(to, subject, message)odel->status); // do not allow editing of inactive records
        return;
    },
    */
    'readonly'=> $readonly,
    'editableOptions'=> function ($model, $key, $index) use ($colorPluginOptions) {
        return [
          'formOptions'=>['action' => ['/projects/activity/editpsikogram']], // point to the new action
          'id' => 'psikogram_' . $model->key . '_form_name',
            'header'=>'Result', 
            'size'=>'md',
          'placement' => 'left',
            'inputType'=>\kartik\editable\Editable::INPUT_RANGE,
             //'data' => [0 => 'pass', 1 => 'fail', 2 => 'waived', 3 => 'todo'],
            'options'=>[
                    'html5Options' => ['min' => 1, 'max' => 7],
                    'id' => 'psikogram_' . $model->key . '_form_name',
            ],

        'beforeInput' => function ($form, $widget) use ($model, $index) {
          /*  echo $form->field($model, "publish_date")->widget(\kartik\widgets\DatePicker::classname(), [
                'options' => ['id' => "publish_date_{$index}"]
            ]);
            */
                echo 'Masukkan rating';
        },


            'afterInput'=>function ($form, $widget) use ($model, $index, $colorPluginOptions) {
                /*return $form->field($model, "color")->widget(\kartik\widgets\ColorInput::classname(), [
                    'showDefaultPalette'=>false,
                    'options'=>['id'=>"color-{$index}"],
                    'pluginOptions'=>$colorPluginOptions,
                ]);
                */

return '';
            }
            
        ];
    }
],

];






?>



<hr/>



    



<?php


 //echo $this->context->view->viewFile;
// $path_parts = pathinfo($viewFile);
//  echo $path_parts['filename'];
//echo $this->render('_'.$path_parts['filename'], ['result_object' => $result_object]);

function processor_kostik($scan, $scores)
{

  
//g =[A1]+[A11]+[A21]+[A31]+[A41]+[A51]+[A61]+[A71]+[A81]
  $scores['kostik']['g'] = substr_count(strtolower($scan[0].$scan[10].$scan[20].$scan[30].$scan[40].$scan[50].$scan[60].$scan[70].$scan[80]), 'a');
  //[B80]+[B69]+[B58]+[B47]+[B36]+[B25]+[B14]+[B3]+[A2]
  $scores['kostik']['a'] = substr_count(strtolower($scan[79].$scan[68].$scan[57].$scan[46].$scan[35].$scan[24].$scan[13].$scan[2]), 'b') + 
               substr_count(strtolower($scan[1]), 'a');
// l =[B81]+[A82]+[A72]+[A62]+[A52]+[A42]+[A32]+[A22]+[A12]
  $scores['kostik']['l'] = substr_count(strtolower($scan[81].$scan[71].$scan[61].$scan[51].$scan[41].$scan[31].$scan[21].$scan[11]), 'a') + 
               substr_count(strtolower($scan[80]), 'b');
//p =[B70]+[B59]+[B48]+[B37]+[B26]+[B15]+[B4]+[A3]+[A13]
  $scores['kostik']['p'] = substr_count(strtolower($scan[69].$scan[58].$scan[47].$scan[36].$scan[25].$scan[14].$scan[3]), 'b') + 
               substr_count(strtolower($scan[2].$scan[12]), 'a');
//i =[B71]+[B82]+[A83]+[A73]+[A63]+[A53]+[A43]+[A33]+[A23]
  $scores['kostik']['i'] = substr_count(strtolower($scan[82].$scan[72].$scan[62].$scan[52].$scan[42].$scan[32].$scan[22]), 'a') + 
               substr_count(strtolower($scan[70] . $scan[81]), 'b');
//t =[B61]+[B72]+[B83]+[A84]+[A74]+[A64]+[A54]+[A44]+[A34]
  $scores['kostik']['t'] = substr_count(strtolower($scan[83].$scan[73].$scan[63].$scan[53].$scan[43].$scan[33]), 'a') + 
               substr_count(strtolower($scan[60] . $scan[71] . $scan[82]), 'b');
//v =[B51]+[B62]+[B73]+[B84]+[A85]+[A75]+[A65]+[A55]+[A45]
  $scores['kostik']['v'] = substr_count(strtolower($scan[84].$scan[74].$scan[64].$scan[54].$scan[44]), 'a') + 
               substr_count(strtolower($scan[50] . $scan[61] . $scan[72] . $scan[83]), 'b');
//x =[B60]+[B49]+[B38]+[B27]+[B16]+[B5]+[A4]+[A14]+[A24]
  $scores['kostik']['x'] = substr_count(strtolower($scan[3].$scan[13].$scan[23]), 'a') + 
               substr_count(strtolower($scan[59] . $scan[48] . $scan[37] . $scan[26] . $scan[15] . $scan[4]), 'b');
//s =[B41]+[B52]+[B63]+[B74]+[B85]+[A86]+[A76]+[A66]+[A56]
  $scores['kostik']['s'] = substr_count(strtolower($scan[85].$scan[75].$scan[65].$scan[55]), 'a') + 
               substr_count(strtolower($scan[40] . $scan[51] . $scan[62] . $scan[73].$scan[84]), 'b');
//b=[B50]+[B39]+[B28]+[B17]+[B6]+[A5]+[A15]+[A25]+[A35]
  $scores['kostik']['b'] = substr_count(strtolower($scan[4].$scan[14].$scan[24].$scan[34]), 'a') + 
               substr_count(strtolower($scan[49] . $scan[38] . $scan[27] . $scan[16].$scan[5]), 'b');
//o=[B40]+[B29]+[B18]+[B7]+[A6]+[A16]+[A26]+[A36]+[A46]
  $scores['kostik']['o'] = substr_count(strtolower($scan[5].$scan[15].$scan[25].$scan[35].$scan[45]), 'a') + 
               substr_count(strtolower($scan[39] . $scan[28] . $scan[17] . $scan[6]), 'b');
//r=[B31]+[B42]+[B53]+[B64]+[B75]+[B86]+[A87]+[A77]+[A67]
  $scores['kostik']['r'] = substr_count(strtolower($scan[86].$scan[76].$scan[66]), 'a') + 
               substr_count(strtolower($scan[30] . $scan[41] . $scan[52] . $scan[63].$scan[74].$scan[85]), 'b');
//d=[B21]+[B32]+[B43]+[B54]+[B65]+[B76]+[B87]+[A88]+[A78]
  $scores['kostik']['d'] = substr_count(strtolower($scan[87].$scan[77]), 'a') + 
               substr_count(strtolower($scan[20] . $scan[31] . $scan[42] . $scan[53].$scan[64].$scan[75].$scan[86]), 'b');
//c=[B11]+[B22]+[B33]+[B44]+[B55]+[B66]+[B77]+[B88]+[A89]
  $scores['kostik']['c'] = substr_count(strtolower($scan[88]), 'a') + 
               substr_count(strtolower($scan[10] . $scan[21] . $scan[32] . $scan[43].$scan[54].$scan[65].$scan[76] . $scan[87]), 'b');
//z=([B30]+[B19]+[B8]+[A7]+[A17]+[A27]+[A37]+[A47]+[A57])
  $scores['kostik']['z'] = substr_count(strtolower($scan[6].$scan[16].$scan[26].$scan[36].$scan[46].$scan[56]), 'a') + 
               substr_count(strtolower($scan[29] . $scan[18] . $scan[7]), 'b');
//e=[B1]+[B12]+[B23]+[B34]+[B45]+[B56]+[B67]+[B78]+[B89]
  $scores['kostik']['e'] = substr_count(strtolower($scan[0] . $scan[11] . $scan[22] . $scan[33].$scan[44].$scan[55].$scan[66].$scan[77].$scan[88]), 'b');
//k=([B20]+[B9]+[A8]+[A18]+[A28]+[A38]+[A48]+[A58]+[A68])
  $scores['kostik']['k'] = substr_count(strtolower($scan[19].$scan[8]), 'b') + 
               substr_count(strtolower($scan[7] . $scan[17] . $scan[27] . $scan[37].$scan[47].$scan[57].$scan[67]), 'a');
//f=[B10]+[A9]+[A19]+[A29]+[A39]+[A49]+[A59]+[A69]+[A79]
  $scores['kostik']['f'] = substr_count(strtolower($scan[9]), 'b') + 
               substr_count(strtolower($scan[8] . $scan[18] . $scan[28] . $scan[38].$scan[48].$scan[58].$scan[68].$scan[78]), 'a');
//w=[A10]+[A20]+[A30]+[A40]+[A50]+[A60]+[A70]+[A80]+[A90]
  $scores['kostik']['w'] = substr_count(strtolower($scan[9] . $scan[19] . $scan[29] . $scan[39].$scan[49].$scan[59].$scan[69].$scan[79].$scan[89]), 'a');
//n=[B90]+[B79]+[B68]+[B57]+[B46]+[B35]+[B24]+[B13]+[B2]
  $scores['kostik']['n'] = substr_count(strtolower($scan[89] . $scan[78] . $scan[67].$scan[56].$scan[45].$scan[34].$scan[23].$scan[12].$scan[1]), 'b');

  return $scores;
}




  ?>


  
<script src="<?=Url::base();?>/js/d3.min.js" charset="utf-8"></script>

	
	<div class="radarChart" style=" background-image: url('<?=Url::base();?>/images/2/kostik_cakim.png'); 
background-repeat: no-repeat;background-size: 600px 600px;"></div>

 <script src="<?=Url::to('@web/js/radarChart.js');?>"></script>
		<script>
      
      /* Radar chart design created by Nadieh Bremer - VisualCinnamon.com */
      
			////////////////////////////////////////////////////////////// 
			//////////////////////// Set-Up ////////////////////////////// 
			////////////////////////////////////////////////////////////// 

			var margin = {top: 100, right: 100, bottom: 100, left: 100},
				width = Math.min(600, window.innerWidth - 10) - margin.left - margin.right,
				height = Math.min(width, window.innerHeight - margin.top - margin.bottom - 20);
					
			////////////////////////////////////////////////////////////// 
			////////////////////////// Data ////////////////////////////// 
			////////////////////////////////////////////////////////////// 

			var data = [
					  [
						{axis:"G",value:<?=$scores['kostik']['g'];?>},
						{axis:"A",value:<?=$scores['kostik']['a'];?>},
						{axis:"L",value:<?=$scores['kostik']['l'];?>},
						{axis:"P",value:<?=$scores['kostik']['p'];?>},
						{axis:"I",value:<?=$scores['kostik']['i'];?>},
						{axis:"T",value:<?=$scores['kostik']['t'];?>},
						{axis:"V",value:<?=$scores['kostik']['v'];?>},
						{axis:"X",value:<?=$scores['kostik']['x'];?>},
						{axis:"S",value:<?=$scores['kostik']['s'];?>},		
						{axis:"B",value:<?=$scores['kostik']['b'];?>},		
						{axis:"O",value:<?=$scores['kostik']['o'];?>},		
						{axis:"R",value:<?=$scores['kostik']['r'];?>},		
						{axis:"D",value:<?=$scores['kostik']['d'];?>},		
						{axis:"C",value:<?=$scores['kostik']['c'];?>},		
						{axis:"Z",value:<?=$scores['kostik']['z'];?>},		
						{axis:"E",value:<?=$scores['kostik']['e'];?>},		
						{axis:"K",value:<?=$scores['kostik']['k'];?>},		
						{axis:"F",value:<?=$scores['kostik']['f'];?>},		
						{axis:"W",value:<?=$scores['kostik']['w'];?>},		
						{axis:"N",value:<?=$scores['kostik']['n'];?>},
					  ],[

					  ]
					];
			////////////////////////////////////////////////////////////// 
			//////////////////// Draw the Chart ////////////////////////// 
			////////////////////////////////////////////////////////////// 

			var color = d3.scale.ordinal()
				.range(["#00A0B0","#CC333F"]);
				
			var radarChartOptions = {
					w: width,
					h: height,
					margin: margin,
					maxValue: 9,
					levels: 9,
					roundStrokes: false,
					color: color,
					opacityArea: 0.5,
					opacityCircles: 0,
					dotRadius: 3,
					strokeWidth: 2, 
					wrapWidth: 10,
					labelFactor: 10,
				};
			//Call function to draw the Radar chart
			RadarChart(".radarChart", data, radarChartOptions);
		</script>



<table class="none" style="padding:10px;border-collapse: collapse;text-align:center;" border = "1" cellpadding="10">
	<tbody>
  <tr style="padding:10px;"><td>G</td><td><?=$scores['kostik']['g'];?></td></tr>
  <tr><td>A</td><td><?=$scores['kostik']['a'];?></td></tr>
  <tr><td>L</td><td><?=$scores['kostik']['l'];?></td></tr>
  <tr><td>P</td><td><?=$scores['kostik']['p'];?></td></tr>
  <tr><td>I</td><td><?=$scores['kostik']['i'];?></td></tr>
  <tr><td>T</td><td><?=$scores['kostik']['t'];?></td></tr>
  <tr><td>V</td><td><?=$scores['kostik']['v'];?></td></tr>
  <tr><td>X</td><td><?=$scores['kostik']['x'];?></td></tr>
  <tr><td>S</td><td><?=$scores['kostik']['s'];?></td></tr>		
  <tr><td>B</td><td><?=$scores['kostik']['b'];?></td></tr>		
  <tr><td>O</td><td><?=$scores['kostik']['o'];?></td></tr>		
  <tr><td>R</td><td><?=$scores['kostik']['r'];?></td></tr>		
  <tr><td>D</td><td><?=$scores['kostik']['d'];?></td></tr>		
  <tr><td>C</td><td><?=$scores['kostik']['c'];?></td></tr>		
  <tr><td>Z</td><td><?=$scores['kostik']['z'];?></td></tr>		
  <tr><td>E</td><td><?=$scores['kostik']['e'];?></td></tr>		
  <tr><td>K</td><td><?=$scores['kostik']['k'];?></td></tr>		
  <tr><td>F</td><td><?=$scores['kostik']['f'];?></td></tr>		
  <tr><td>W</td><td><?=$scores['kostik']['w'];?></td></tr>		
  <tr><td>N</td><td><?=$scores['kostik']['n'];?></td></tr>
	</tbody>
</table>




<br/>


<style type="text/css">
.auto-style9 {
	color: white;
	font-size: 12.0pt;
	font-weight: 700;
	font-style: normal;
	text-decoration: none;
	font-family: Calibri, sans-serif;
	text-align: general;
	vertical-align: middle;
	white-space: nowrap;
	border-left: .5pt solid windowtext;
	border-right-style: none;
	border-right-color: inherit;
	border-right-width: medium;
	border-top-style: none;
	border-top-color: inherit;
	border-top-width: medium;
	border-bottom-style: none;
	border-bottom-color: inherit;
	border-bottom-width: medium;
	padding-left: 1px;
	padding-right: 1px;
	padding-top: 1px;
	background: #F2F2F2;
}
.auto-style10 {
	color: white;
	font-size: 12.0pt;
	font-weight: 700;
	font-style: normal;
	text-decoration: none;
	font-family: Calibri, sans-serif;
	text-align: general;
	vertical-align: middle;
	white-space: nowrap;
	border-left-style: none;
	border-left-color: inherit;
	border-left-width: medium;
	border-right: .5pt solid windowtext;
	border-top-style: none;
	border-top-color: inherit;
	border-top-width: medium;
	border-bottom-style: none;
	border-bottom-color: inherit;
	border-bottom-width: medium;
	padding-left: 1px;
	padding-right: 1px;
	padding-top: 1px;
	background: #F2F2F2;
}
.auto-style13 {
	color: windowtext;
	font-size: 12.0pt;
	font-weight: 700;
	font-style: normal;
	text-decoration: none;
	font-family: Calibri, sans-serif;
	text-align: center;
	vertical-align: middle;
	white-space: nowrap;
	border: .5pt solid windowtext;
	padding-left: 1px;
	padding-right: 1px;
	padding-top: 1px;
	background: #F2F2F2;
}
.auto-style24 {
	color: windowtext;
	font-size: 12.0pt;
	font-weight: 700;
	font-style: normal;
	text-decoration: none;
	font-family: Calibri, sans-serif;
	text-align: center;
	vertical-align: middle;
	white-space: nowrap;
	border-left: .5pt solid windowtext;
	border-right-style: none;
	border-right-color: inherit;
	border-right-width: medium;
	border-top-style: none;
	border-top-color: inherit;
	border-top-width: medium;
	border-bottom-style: none;
	border-bottom-color: inherit;
	border-bottom-width: medium;
	padding-left: 1px;
	padding-right: 1px;
	padding-top: 1px;
}
.auto-style26 {
	color: windowtext;
	font-size: 12.0pt;
	font-weight: 700;
	font-style: normal;
	text-decoration: none;
	font-family: Calibri, sans-serif;
	text-align: center;
	vertical-align: middle;
	white-space: nowrap;
	border: .5pt solid windowtext;
	padding-left: 1px;
	padding-right: 1px;
	padding-top: 1px;
}
.auto-style28 {
	color: windowtext;
	font-size: 12.0pt;
	font-weight: 700;
	font-style: normal;
	text-decoration: none;
	font-family: Calibri, sans-serif;
	text-align: center;
	vertical-align: middle;
	white-space: nowrap;
	border-left: .5pt solid windowtext;
	border-right: .5pt solid windowtext;
	border-top: .5pt solid windowtext;
	border-bottom: 1.0pt solid windowtext;
	padding-left: 1px;
	padding-right: 1px;
	padding-top: 1px;
}
.auto-style29 {
	color: windowtext;
	font-size: 12.0pt;
	font-weight: 700;
	font-style: normal;
	text-decoration: none;
	font-family: Calibri, sans-serif;
	text-align: center;
	vertical-align: middle;
	white-space: nowrap;
	border-left: .5pt solid windowtext;
	border-right-style: none;
	border-right-color: inherit;
	border-right-width: medium;
	border-top-style: none;
	border-top-color: inherit;
	border-top-width: medium;
	border-bottom: 1.0pt solid windowtext;
	padding-left: 1px;
	padding-right: 1px;
	padding-top: 1px;
}
.auto-style48 {
	color: windowtext;
	font-size: 11.0pt;
	font-weight: 700;
	font-style: normal;
	text-decoration: none;
	font-family: Calibri, sans-serif;
	text-align: general;
	vertical-align: middle;
	white-space: nowrap;
	border-left: 1.0pt solid windowtext;
	border-right-style: solid;
	border-right-color: inherit;
	border-right-width: 1px;
	border-top: 1.0pt solid windowtext;
	border-bottom: 1.0pt solid windowtext;
	padding-left: 1px;
	padding-right: 1px;
	padding-top: 1px;
}
.auto-style49 {
	color: windowtext;
	font-size: 11.0pt;
	font-weight: 700;
	font-style: normal;
	text-decoration: none;
	font-family: Calibri, sans-serif;
	text-align: center;
	vertical-align: middle;
	white-space: nowrap;
	border-left: 1px solid windowtext;
	border-right-style: none;
	border-right-color: inherit;
	border-right-width: medium;
	border-top: 1.0pt solid windowtext;
	border-bottom: 1.0pt solid windowtext;
	padding-left: 1px;
	padding-right: 1px;
	padding-top: 1px;
}
.auto-style52 {
	color: windowtext;
	font-size: 11.0pt;
	font-weight: 700;
	font-style: normal;
	text-decoration: none;
	font-family: Calibri, sans-serif;
	text-align: center;
	vertical-align: middle;
	white-space: nowrap;
	border-left-style: none;
	border-left-color: inherit;
	border-left-width: medium;
	border-right: 1px solid windowtext;
	border-top: 1.0pt solid windowtext;
	border-bottom: 1.0pt solid windowtext;
	padding-left: 1px;
	padding-right: 1px;
	padding-top: 1px;
}
.auto-style53 {
	color: windowtext;
	font-size: 11.0pt;
	font-weight: 700;
	font-style: normal;
	text-decoration: none;
	font-family: Calibri, sans-serif;
	text-align: general;
	vertical-align: middle;
	white-space: nowrap;
	border-left: 1.0pt solid windowtext;
	border-right: .5pt solid windowtext;
	border-top-style: none;
	border-top-color: inherit;
	border-top-width: medium;
	border-bottom: .5pt solid windowtext;
	padding-left: 1px;
	padding-right: 1px;
	padding-top: 1px;
	background: #F2F2F2;
}
.auto-style55 {
	color: windowtext;
	font-size: 12.0pt;
	font-weight: 700;
	font-style: normal;
	text-decoration: none;
	font-family: Calibri, sans-serif;
	text-align: center;
	vertical-align: middle;
	white-space: nowrap;
	border-left: .5pt solid windowtext;
	border-right-style: none;
	border-right-color: inherit;
	border-right-width: medium;
	border-top-style: solid;
	border-top-color: inherit;
	border-top-width: 1px;
	border-bottom-style: solid;
	border-bottom-color: inherit;
	border-bottom-width: 1px;
	padding-left: 1px;
	padding-right: 1px;
	padding-top: 1px;
	background: #F2F2F2;
}
.auto-style56 {
	color: windowtext;
	font-size: 12.0pt;
	font-weight: 700;
	font-style: normal;
	text-decoration: none;
	font-family: Calibri, sans-serif;
	text-align: center;
	vertical-align: middle;
	white-space: nowrap;
	border-left-style: none;
	border-left-color: inherit;
	border-left-width: medium;
	border-right: .5pt solid windowtext;
	border-top-style: solid;
	border-top-color: inherit;
	border-top-width: 1px;
	border-bottom: .5pt solid windowtext;
	padding-left: 1px;
	padding-right: 1px;
	padding-top: 1px;
	background: #F2F2F2;
}
.auto-style57 {
	color: windowtext;
	font-size: 11.0pt;
	font-weight: 700;
	font-style: normal;
	text-decoration: none;
	font-family: Calibri, sans-serif;
	text-align: general;
	vertical-align: middle;
	white-space: nowrap;
	border-left: 1.0pt solid windowtext;
	border-right: .5pt solid windowtext;
	border-top: .5pt solid windowtext;
	border-bottom: .5pt solid windowtext;
	padding-left: 1px;
	padding-right: 1px;
	padding-top: 1px;
	background: #F2F2F2;
}
.auto-style58 {
	color: windowtext;
	font-size: 12.0pt;
	font-weight: 700;
	font-style: normal;
	text-decoration: none;
	font-family: Calibri, sans-serif;
	text-align: center;
	vertical-align: middle;
	white-space: nowrap;
	border-left-style: none;
	border-left-color: inherit;
	border-left-width: medium;
	border-right: .5pt solid windowtext;
	border-top: .5pt solid windowtext;
	border-bottom: .5pt solid windowtext;
	padding-left: 1px;
	padding-right: 1px;
	padding-top: 1px;
	background: #F2F2F2;
}
.auto-style59 {
	color: windowtext;
	font-size: 11.0pt;
	font-weight: 700;
	font-style: normal;
	text-decoration: none;
	font-family: Calibri, sans-serif;
	text-align: general;
	vertical-align: middle;
	white-space: nowrap;
	border-left: 1.0pt solid windowtext;
	border-right: .5pt solid windowtext;
	border-top: .5pt solid windowtext;
	border-bottom-style: none;
	border-bottom-color: inherit;
	border-bottom-width: medium;
	padding-left: 1px;
	padding-right: 1px;
	padding-top: 1px;
	background: #F2F2F2;
}
.auto-style60 {
	color: windowtext;
	font-size: 12.0pt;
	font-weight: 700;
	font-style: normal;
	text-decoration: none;
	font-family: Calibri, sans-serif;
	text-align: center;
	vertical-align: middle;
	white-space: nowrap;
	border-left: .5pt solid windowtext;
	border-right: .5pt solid windowtext;
	border-top: .5pt solid windowtext;
	border-bottom-style: none;
	border-bottom-color: inherit;
	border-bottom-width: medium;
	padding-left: 1px;
	padding-right: 1px;
	padding-top: 1px;
	background: #F2F2F2;
}
.auto-style61 {
	color: windowtext;
	font-size: 12.0pt;
	font-weight: 700;
	font-style: normal;
	text-decoration: none;
	font-family: Calibri, sans-serif;
	text-align: center;
	vertical-align: middle;
	white-space: nowrap;
	border-left-style: none;
	border-left-color: inherit;
	border-left-width: medium;
	border-right: .5pt solid windowtext;
	border-top: .5pt solid windowtext;
	border-bottom-style: solid;
	border-bottom-color: inherit;
	border-bottom-width: 1px;
	padding-left: 1px;
	padding-right: 1px;
	padding-top: 1px;
	background: #F2F2F2;
}
.auto-style62 {
	color: windowtext;
	font-size: 11.0pt;
	font-weight: 700;
	font-style: normal;
	text-decoration: none;
	font-family: Calibri, sans-serif;
	text-align: general;
	vertical-align: middle;
	white-space: nowrap;
	border-left: 1.0pt solid windowtext;
	border-right: .5pt solid windowtext;
	border-top: 1.0pt solid windowtext;
	border-bottom: 1.0pt solid windowtext;
	padding-left: 1px;
	padding-right: 1px;
	padding-top: 1px;
	background: #F2F2F2;
}
.auto-style63 {
	color: windowtext;
	font-size: 12.0pt;
	font-weight: 700;
	font-style: normal;
	text-decoration: none;
	font-family: Calibri, sans-serif;
	text-align: center;
	vertical-align: middle;
	white-space: nowrap;
	border-left: .5pt solid windowtext;
	border-right: 1px solid windowtext;
	border-top: 1.0pt solid windowtext;
	border-bottom: 1.0pt solid windowtext;
	padding-left: 1px;
	padding-right: 1px;
	padding-top: 1px;
	background: #F2F2F2;
}
.auto-style64 {
	color: windowtext;
	font-size: 12.0pt;
	font-weight: 700;
	font-style: normal;
	text-decoration: none;
	font-family: Calibri, sans-serif;
	text-align: center;
	vertical-align: middle;
	white-space: nowrap;
	border-left: 1px solid windowtext;
	border-right-style: solid;
	border-right-color: inherit;
	border-right-width: 1px;
	border-top: 1px solid windowtext;
	border-bottom: 1px solid windowtext;
	padding-left: 1px;
	padding-right: 1px;
	padding-top: 1px;
	background: #F2F2F2;
}
.auto-style65 {
	color: windowtext;
	font-size: 12.0pt;
	font-weight: 700;
	font-style: normal;
	text-decoration: none;
	font-family: Calibri, sans-serif;
	text-align: center;
	vertical-align: middle;
	white-space: nowrap;
	border-left-style: solid;
	border-left-color: inherit;
	border-left-width: 1px;
	border-right: 1px solid windowtext;
	border-top: 1px solid windowtext;
	border-bottom: 1px solid windowtext;
	padding-left: 1px;
	padding-right: 1px;
	padding-top: 1px;
	background: #F2F2F2;
}
.auto-style66 {
	color: windowtext;
	font-size: 11.0pt;
	font-weight: 700;
	font-style: normal;
	text-decoration: none;
	font-family: Calibri, sans-serif;
	text-align: general;
	vertical-align: middle;
	white-space: nowrap;
	border-left: 1.0pt solid windowtext;
	border-right: .5pt solid windowtext;
	border-top-style: none;
	border-top-color: inherit;
	border-top-width: medium;
	border-bottom: .5pt solid windowtext;
	padding-left: 1px;
	padding-right: 1px;
	padding-top: 1px;
}
.auto-style67 {
	color: windowtext;
	font-size: 12.0pt;
	font-weight: 700;
	font-style: normal;
	text-decoration: none;
	font-family: Calibri, sans-serif;
	text-align: center;
	vertical-align: middle;
	white-space: nowrap;
	border-left: .5pt solid windowtext;
	border-right: .5pt solid windowtext;
	border-top-style: none;
	border-top-color: inherit;
	border-top-width: medium;
	border-bottom: .5pt solid windowtext;
	padding-left: 1px;
	padding-right: 1px;
	padding-top: 1px;
}
.auto-style68 {
	color: windowtext;
	font-size: 11.0pt;
	font-weight: 700;
	font-style: normal;
	text-decoration: none;
	font-family: Calibri, sans-serif;
	text-align: general;
	vertical-align: middle;
	white-space: nowrap;
	border-left: 1.0pt solid windowtext;
	border-right: .5pt solid windowtext;
	border-top: .5pt solid windowtext;
	border-bottom: .5pt solid windowtext;
	padding-left: 1px;
	padding-right: 1px;
	padding-top: 1px;
}
.auto-style69 {
	color: windowtext;
	font-size: 11.0pt;
	font-weight: 700;
	font-style: normal;
	text-decoration: none;
	font-family: Calibri, sans-serif;
	text-align: general;
	vertical-align: middle;
	white-space: nowrap;
	border-left: 1.0pt solid windowtext;
	border-right: .5pt solid windowtext;
	border-top: .5pt solid windowtext;
	border-bottom: 1.0pt solid windowtext;
	padding-left: 1px;
	padding-right: 1px;
	padding-top: 1px;
}
.auto-style70 {
	color: windowtext;
	font-size: 12.0pt;
	font-weight: 700;
	font-style: normal;
	text-decoration: none;
	font-family: Calibri, sans-serif;
	text-align: center;
	vertical-align: middle;
	white-space: nowrap;
	border-left: .5pt solid windowtext;
	border-right: .5pt solid windowtext;
	border-top-style: none;
	border-top-color: inherit;
	border-top-width: medium;
	border-bottom: 1.0pt solid windowtext;
	padding-left: 1px;
	padding-right: 1px;
	padding-top: 1px;
}
.auto-style72 {
	border-collapse: collapse;
}
.auto-style73 {
	color: windowtext;
	font-size: 12.0pt;
	font-weight: 700;
	font-style: normal;
	text-decoration: none;
	font-family: Calibri, sans-serif;
	text-align: center;
	vertical-align: middle;
	white-space: nowrap;
	border-left: 1px solid windowtext;
	border-right: .5pt solid windowtext;
	border-top: 1.0pt solid windowtext;
	border-bottom: 1.0pt solid windowtext;
	padding-left: 1px;
	padding-right: 1px;
	padding-top: 1px;
	background: #F2F2F2;
}
.auto-style78 {
	color: windowtext;
	font-size: 11.0pt;
	font-weight: 700;
	font-style: normal;
	text-decoration: none;
	font-family: Calibri, sans-serif;
	text-align: center;
	vertical-align: middle;
	white-space: nowrap;
	border-left-style: solid;
	border-left-color: inherit;
	border-left-width: 1px;
	border-right-style: solid;
	border-right-color: inherit;
	border-right-width: 1px;
	border-top: 1px solid windowtext;
	border-bottom: 1px solid windowtext;
	padding-left: 1px;
	padding-right: 1px;
	padding-top: 1px;
}
.auto-style79 {
	color: windowtext;
	font-size: 11.0pt;
	font-weight: 700;
	font-style: normal;
	text-decoration: none;
	font-family: Calibri, sans-serif;
	text-align: center;
	vertical-align: middle;
	white-space: nowrap;
	border-left: 1px solid windowtext;
	border-right-style: solid;
	border-right-color: inherit;
	border-right-width: 1px;
	border-top: 1px solid windowtext;
	border-bottom: 1px solid windowtext;
	padding-left: 1px;
	padding-right: 1px;
	padding-top: 1px;
}
.auto-style80 {
	color: windowtext;
	font-size: 12.0pt;
	font-weight: 700;
	font-style: normal;
	text-decoration: none;
	font-family: Calibri, sans-serif;
	text-align: center;
	vertical-align: middle;
	white-space: nowrap;
	border-left: .5pt solid windowtext;
	border-right: .5pt solid windowtext;
	border-top-style: solid;
	border-top-color: inherit;
	border-top-width: 1px;
	border-bottom: .5pt solid windowtext;
	padding-left: 1px;
	padding-right: 1px;
	padding-top: 1px;
	background: #F2F2F2;
}
.auto-style81 {
	color: windowtext;
	font-size: 12.0pt;
	font-weight: 700;
	font-style: normal;
	text-decoration: none;
	font-family: Calibri, sans-serif;
	text-align: center;
	vertical-align: middle;
	white-space: nowrap;
	border-left: .5pt solid windowtext;
	border-right: .5pt solid windowtext;
	border-top-style: solid;
	border-top-color: inherit;
	border-top-width: 1px;
	border-bottom: .5pt solid windowtext;
	padding-left: 1px;
	padding-right: 1px;
	padding-top: 1px;
}
.auto-style82 {
	color: windowtext;
	font-size: 12.0pt;
	font-weight: 700;
	font-style: normal;
	text-decoration: none;
	font-family: Calibri, sans-serif;
	text-align: center;
	vertical-align: middle;
	white-space: nowrap;
	border-left: .5pt solid windowtext;
	border-right-style: none;
	border-right-color: inherit;
	border-right-width: medium;
	border-top-style: solid;
	border-top-color: inherit;
	border-top-width: 1px;
	border-bottom-style: none;
	border-bottom-color: inherit;
	border-bottom-width: medium;
	padding-left: 1px;
	padding-right: 1px;
	padding-top: 1px;
}
.auto-style83 {
	color: white;
	font-size: 12.0pt;
	font-weight: 700;
	font-style: normal;
	text-decoration: none;
	font-family: Calibri, sans-serif;
	text-align: general;
	vertical-align: middle;
	white-space: nowrap;
	border-left: .5pt solid windowtext;
	border-right-style: none;
	border-right-color: inherit;
	border-right-width: medium;
	border-top-style: none;
	border-top-color: inherit;
	border-top-width: medium;
	border-bottom-style: solid;
	border-bottom-color: inherit;
	border-bottom-width: 1px;
	padding-left: 1px;
	padding-right: 1px;
	padding-top: 1px;
	background: #F2F2F2;
}
.auto-style84 {
	color: white;
	font-size: 12.0pt;
	font-weight: 700;
	font-style: normal;
	text-decoration: none;
	font-family: Calibri, sans-serif;
	text-align: general;
	vertical-align: middle;
	white-space: nowrap;
	border-left-style: none;
	border-left-color: inherit;
	border-left-width: medium;
	border-right: .5pt solid windowtext;
	border-top-style: none;
	border-top-color: inherit;
	border-top-width: medium;
	border-bottom-style: solid;
	border-bottom-color: inherit;
	border-bottom-width: 1px;
	padding-left: 1px;
	padding-right: 1px;
	padding-top: 1px;
	background: #F2F2F2;
}
</style>

<?php

//echo '<pre>';
//print_r($result_object);

$cfit_total = $result_object['cakim']['subtest_1_tc'] + $result_object['cakim']['subtest_2_tc'] + $result_object['cakim']['subtest_3_tc'] + $result_object['cakim']['subtest_4_tc'];
$cfit_total_scaled = RefScale::find()->andWhere(['type' => 'cakim'])->andWhere(['name' => 'cfit'])->andWhere(['raw' => $cfit_total])->One();
$iq_scaled = RefScale::find()->andWhere(['type' => 'cakim'])->andWhere(['name' => 'cfit2iq'])->andWhere(['raw' => $cfit_total])->One();

$cfit1 = $result_object['cakim']['subtest_1_tc'];
$cfit1_scaled = RefScale::find()->andWhere(['type' => 'cakim'])->andWhere(['name' => 'cfit'])->andWhere(['raw' => $cfit1])->One();

$cfit2 = $result_object['cakim']['subtest_2_tc'];
$cfit2_scaled = RefScale::find()->andWhere(['type' => 'cakim'])->andWhere(['name' => 'cfit'])->andWhere(['raw' => $cfit2])->One();

$cfit3 = $result_object['cakim']['subtest_3_tc'];
$cfit3_scaled = RefScale::find()->andWhere(['type' => 'cakim'])->andWhere(['name' => 'cfit'])->andWhere(['raw' => $cfit3])->One();

$cfit4 = $result_object['cakim']['subtest_4_tc'];
$cfit4_scaled = RefScale::find()->andWhere(['type' => 'cakim'])->andWhere(['name' => 'cfit'])->andWhere(['raw' => $cfit4])->One();

$compre = $result_object['cakim']['subtest_5_tc'];
$compre_scaled = RefScale::find()->andWhere(['type' => 'cakim'])->andWhere(['name' => 'compre'])->andWhere(['raw' => $compre])->One();

$info = $result_object['cakim']['subtest_6_tc'];
$info_scaled = RefScale::find()->andWhere(['type' => 'cakim'])->andWhere(['name' => 'info'])->andWhere(['raw' => $info])->One();

$logi = $result_object['cakim']['subtest_7_tc'];
$logi_scaled = RefScale::find()->andWhere(['type' => 'cakim'])->andWhere(['name' => 'logika'])->andWhere(['raw' => $logi])->One();

$analog = $result_object['cakim']['subtest_8_tc'];
$analog_scaled = RefScale::find()->andWhere(['type' => 'cakim'])->andWhere(['name' => 'analogi'])->andWhere(['raw' => $analog])->One();
$arit = $result_object['cakim']['subtest_9_tc'];
$arit_scaled = RefScale::find()->andWhere(['type' => 'cakim'])->andWhere(['name' => 'arith'])->andWhere(['raw' => $arit])->One();

$admin = $result_object['cakim']['subtest_10_tc'];
$admin_scaled = RefScale::find()->andWhere(['type' => 'cakim'])->andWhere(['name' => 'admin'])->andWhere(['raw' => $admin])->One();


?>

<div style="position:absolute; left: 300px; top:1500px;">

<table border="0" cellpadding="0" cellspacing="0" class="auto-style72" style="width: 537pt" width="715">
	<colgroup>
		<col width="176"><col span="2" width="89"><col span="2" width="47">
		<col span="3" width="89">
	</colgroup>
	<tr height="22">
		<td class="auto-style48" height="22" style="height: 16.5pt; width: 132pt" width="176">
		SUBTEST</td>
		<td class="auto-style79" style="width: 67pt" width="89">RS</td>
		<td class="auto-style78" style="width: 67pt" width="89">SS</td>
		<td class="auto-style49" style="width: 35pt" width="47">&nbsp;</td>
		<td class="auto-style52" style="width: 35pt" width="47">&nbsp;</td>
		<td class="auto-style78" style="width: 67pt" width="89">SELESAI</td>
		<td class="auto-style79" colspan="2" style="width: 134pt" width="178">
		BENAR</td>
	</tr>
	<tr height="21">
		<td class="auto-style53" height="21" style="height: 15.75pt">CFIT1</td>
		<td class="auto-style80"><?=$cfit1?></td>
		<td class="auto-style55" rowspan="4">&nbsp;</td>
		<td class="auto-style9"><?=$cfit1_scaled->scaled?></td>
		<td class="auto-style10">&nbsp;</td>
		<td class="auto-style56">100%</td>
		<td class="auto-style80" colspan="2"><?=round(($cfit1) / 13, 2) * 100?>%</td>
	</tr>
	<tr height="25">
		<td class="auto-style57" height="25" style="height: 18.75pt;">CFIT2</td>
		<td class="auto-style13"><?=$cfit2?></td>
		<td class="auto-style9">14</td>
		<td class="auto-style10">&nbsp;</td>
		<td class="auto-style58">100%</td>
		<td class="auto-style13" colspan="2"><?=round(($cfit2) / 14, 2) * 100?>%</td>
	</tr>
	<tr height="25">
		<td class="auto-style57" height="25" style="height: 18.75pt;">CFIT3</td>
		<td class="auto-style13"><?=$cfit3?></td>
		<td class="auto-style9">11</td>
		<td class="auto-style10">&nbsp;</td>
		<td class="auto-style58">100%</td>
		<td class="auto-style13" colspan="2"><?=round(($cfit3) / 13, 2) * 100?>%</td>
	</tr>
	<tr height="26">
		<td class="auto-style59" height="26" style="height: 19.5pt;">CFIT4</td>
		<td class="auto-style60"><?=$cfit4?></td>
		<td class="auto-style83">8</td>
		<td class="auto-style84">&nbsp;</td>
		<td class="auto-style61">90%</td>
		<td class="auto-style60" colspan="2"><?=round(($cfit4) / 10, 2) * 100?>%</td>
	</tr>
	<tr height="26">
		<td class="auto-style62" height="26" style="height: 19.5pt">CFIT TOTAL</td>
		<td class="auto-style63"><?=$cfit_total?></td>
		<td class="auto-style64"><?=$cfit_total_scaled->scaled?></td>
		<td class="auto-style64" colspan="2">IQ: <?= $iq_scaled->scaled ?></td>
		<td class="auto-style65">300%</td>
		<td class="auto-style73" colspan="2">6%</td>
	</tr>
	<tr height="25">
		<td class="auto-style66" height="25" style="height: 18.75pt">
		COMPREHENSION</td>
		<td class="auto-style67"><?=$compre?></td>
		<td class="auto-style81"><?=$compre_scaled->scaled?></td>
		<td class="auto-style82" colspan="2">&nbsp;</td>
		<td class="auto-style81">100%</td>
		<td class="auto-style67" colspan="2"><?=round(($compre) / 30, 2) * 100?>%</td>
	</tr>
	<tr height="25">
		<td class="auto-style68" height="25" style="height: 18.75pt;">
		INFORMATION</td>
		<td class="auto-style26"><?=$info?></td>
		<td class="auto-style26"><?=$info_scaled->scaled?></td>
		<td class="auto-style24" colspan="2">&nbsp;</td>
		<td class="auto-style26">100%</td>
		<td class="auto-style67" colspan="2"><?=round(($info) / 40, 2) * 100?>%</td>
	</tr>
	<tr height="48">
		<td class="auto-style68" height="48" style="height: 36.0pt;">LOGIKA 
		VERBAL</td>
		<td class="auto-style26"><?=$logi?></td>
		<td class="auto-style26"><?=$logi_scaled->scaled?></td>
		<td class="auto-style24" colspan="2">&nbsp;</td>
		<td class="auto-style26">100%</td>
		<td class="auto-style67" colspan="2"><?=round(($logi) / 15, 2) * 100?>%</td>
	</tr>
	<tr height="48">
		<td class="auto-style68" height="48" style="height: 36.0pt;">ANALOGY 
		VERBAL</td>
		<td class="auto-style26"><?=$analog?></td>
		<td class="auto-style26"><?=$analog_scaled->scaled?></td>
		<td class="auto-style24" colspan="2">&nbsp;</td>
		<td class="auto-style26">100%</td>
		<td class="auto-style67" colspan="2"><?=round(($analog) / 40, 2) * 100?>%</td>
	</tr>
	<tr height="48">
		<td class="auto-style68" height="48" style="height: 36.0pt;">ARITMATIKA</td>
		<td class="auto-style26"><?=$arit?></td>
		<td class="auto-style26"><?=$arit_scaled->scaled?></td>
		<td class="auto-style24" colspan="2">&nbsp;</td>
		<td class="auto-style26">100%</td>
		<td class="auto-style67" colspan="2"><?=round(($arit) / 25, 2) * 100?>%</td>
	</tr>
	<tr height="22">
		<td class="auto-style69" height="22" style="height: 16.5pt;">
		ADMINISTRASI ADKUDAG-4</td>
		<td class="auto-style28"><?=$admin?></td>
		<td class="auto-style28"><?=$admin_scaled->scaled?></td>
		<td class="auto-style29" colspan="2">&nbsp;</td>
		<td class="auto-style28">100%</td>
		<td class="auto-style70" colspan="2"><?=round(($admin) / 40, 2) * 100?>%</td>
	</tr>
</table>
</div>


<hr/>