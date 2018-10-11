<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use yii\web\View;
use app\assets\AppAsset;

use app\modules\projects\models\Project;
use app\modules\projects\models\ProjectMeta;
use app\modules\projects\models\ProjectActivity;
use app\modules\projects\models\ProjectAssessmentResult;
use app\modules\projects\models\ProjectAssessment;
use app\modules\projects\models\ProjectActivityMeta;
use common\modules\profile\models\ProfileMeta;
use common\modules\profile\models\Profile;
use common\modules\catalog\models\RefAssessmentDictionary;
use common\modules\catalog\models\CatalogMeta;
use common\modules\catalog\models\Catalog;
use app\modules\projects\models\AssessmentReport;
use app\modules\projects\models\Kompetensigram;

use kartik\grid\GridView;
use kartik\form\ActiveForm;

use yii\widgets\ListView;
use kartik\editable\Editable;

//use Yii;

?>



<head>
<link rel="stylesheet" type="text/css" href="/css/psikogramTable.css">
</head>


<?php
$this->context->initAssessment($_GET['id'], $catalog_id);
//Yii::$app->runAction('activity/initassessment', ['id' => $_GET['id'], 'catalog_id' => $catalog_id]);

   $Pa = ProjectAssessment::find()->andWhere(['activity_id'=> $_GET['id']])->One();
   
   $PArp = ProjectAssessmentResult::find()->andWhere(['type'=>'psikogram'])->andWhere(['project_assessment_id'=>$Pa->id])->Sum('value');
   $PArk = ProjectAssessmentResult::find()->andWhere(['type'=>'kompetensigram'])->andWhere(['project_assessment_id'=>$Pa->id])->Sum('value');

   $sumC =     CatalogMeta::find()->andWhere(['catalog_id'=>$Pa->catalog_id])->andWhere(['type'=>'kompetensigram'])->andWhere(['key'=>'kompetensi'])->Sum('attribute_1');
<<<<<<< HEAD

   //echo $PArp/66*100 .'<br/>';
   ////echo $PArk/$sumC*100 .'<br/>';
=======
   //echo $PArp/66*100 .'<br/>';
   //echo $PArk/$sumC*100 .'<br/>';
>>>>>>> 7e962cacf0e46ac84e04bc4696aab320f3d83f23
   
?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart'], 'language': 'id'});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Potensi', 'Kompetensi'],
          [ <?php echo $PArp/66*100; ?>,     <?php echo $PArk/$sumC*100; ?>], //ini harus diisi

        ]);

        var options = {
          title: 'Gambaran Posisi 9-Cell (Kompetensi dan Potensi)',
          hAxis: {
              //title: 'Potensi', minValue: 0, maxValue: 100,
              gridlines:{color: '#eee', count: 7},
              ticks: [0, 20, 40, 60, 80, 100, 120, 140, ]
              },
          vAxis: {
             // title: 'Kompetensi', minValue: 0, maxValue: 100, 
             gridlines:{color: '#eee', count: 7},
             ticks: [0, 20, 40, 60, 80, 100, 120, 140, ]
             },
          crosshair: { trigger: 'both' },
          legend: 'none',
          backgroundColor: { fill:'transparent' }
          //vAxis.gridlines:{color: '#333', count: 4}
        };

        var chart = new google.visualization.ScatterChart(document.getElementById('chart_div'));

        chart.draw(data, options);
      }
    </script>	 
<?php

$this->registerCss("

 .lkj input[type='radio']:after {
        width: 15px;
        height: 15px;
        border-radius: 15px;
        top: -2px;
        left: -1px;
        position: relative;
        background-color: #d1d3d1;
        content: '';
        display: inline-block;
        visibility: visible;
        border: 1px solid #ccc;
    }

    .lkj     input[type='radio']:checked:after {
        width: 15px;
        height: 15px;
        border-radius: 15px;
        top: -2px;
        left: -1px;
        position: relative;
        background-color: #ffa500;
        content: '';
        display: inline-block;
        visibility: visible;
        border: 1px solid #ccc;     
    }
    
    .RadioBox {
        border: 1px solid #ccc;
        padding: 10px;    
        display: inline-block;
    }

    .RadioBox2 {
        border: 1px solid #ccc;
        padding: 10px;    
        display: inline-block;
        background-color: #ccc;
    }
    
    
    ");
    $kompetensigram_models = $dataProvider->getModels();
    foreach ($kompetensigram_models as $kompkey => $kompvalue) {
        $result_object['kompetensigram'][$kompvalue->key]['lki'] = $kompvalue->value;
        $x = CatalogMeta::find()->andWhere(['type' => 'kompetensigram'])->andWhere(['key' => 'kompetensi'])
        ->andWhere(['value' => $kompvalue->key])->One();
    $result_object['kompetensigram'][$kompvalue->key]['lkj'] = $x->attribute_1;
    }
     

$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.6/d3.min.js',['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('@web/js/radarChart.js',['position' => \yii\web\View::POS_HEAD]);
$this->registerJs(
"var margin = {top: 65, right: 70, bottom: 130, left: 70},
width = Math.min(480, window.innerWidth - 0) - margin.left - margin.right,
height = Math.min(width, window.innerHeight - margin.top - margin.bottom - 20);
    
    var data = [
      [
 
        
        {axis:'',value:".$result_object['kompetensigram']['int']['lkj']."},
        {axis:'',value:".$result_object['kompetensigram']['bpl']['lkj']."},
        {axis:'',value:".$result_object['kompetensigram']['ksn']['lkj']."},
        {axis:'',value:".$result_object['kompetensigram']['pfs']['lkj']."},
<<<<<<< HEAD
        {axis:'',value:".$result_object['kompetensigram']['bku']['lkj']."},      
        {axis:'',value:".$result_object['kompetensigram']['ppo']['lkj']."},      
        {axis:'',value:".$result_object['kompetensigram']['kpt']['lkj']."},  
=======

>>>>>>> 7e962cacf0e46ac84e04bc4696aab320f3d83f23
      ],[
        {axis:'',value:".$result_object['kompetensigram']['int']['lki']."},
        {axis:'',value:".$result_object['kompetensigram']['bpl']['lki']."},
        {axis:'',value:".$result_object['kompetensigram']['ksn']['lki']."},
        {axis:'',value:".$result_object['kompetensigram']['pfs']['lki']."},
<<<<<<< HEAD
        {axis:'',value:".$result_object['kompetensigram']['bku']['lki']."},    
        {axis:'',value:".$result_object['kompetensigram']['ppo']['lki']."},      
        {axis:'',value:".$result_object['kompetensigram']['kpt']['lki']."},  
=======


>>>>>>> 7e962cacf0e46ac84e04bc4696aab320f3d83f23
      ]
    ];


var color = d3.scale.ordinal()
.range(['#AEDFFB','#35274E']);

var radarChartOptions = {
w: width,
h: height,
margin: margin,
maxValue: 5,
levels: 5,
roundStrokes: true,
color: color,
opacityArea: 0.5,
opacityCircles: 0,
dotRadius: 3,
strokeWidth: 2, 
wrapWidth: 10,
labelFactor: 10,
};

RadarChart('.radarChart', data, radarChartOptions);"   ,
    View::POS_READY,
'ny-button-handler'
);  

		   
?>

<head>
<style type="text/css">

</style>
</head>

<br/>
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



$kompetensiGridColumns = [

  //'project_assessment_id',
  [
    'label' => 'Kategori',
    'value' => function($data) use ($catalog_id){
  		$lkj = CatalogMeta::find()
  		->andWhere(['catalog_id' => $catalog_id])
        ->andWhere(['type' => 'kompetensigram'])
        ->andWhere(['key' => 'kompetensi'])
        ->andWhere(['value' => $data->key])->One();
  		return $lkj->attribute_2;
    },

  ],
  [
    'label' => 'Kompetensi',
    'value' => function($data){
        $deskripsi = RefAssessmentDictionary::find()
        ->andWhere(['type' => 'kompetensigram'])
        ->andWhere(['key' => 'kompetensi'])
        ->andWhere(['value' => $data->key])->One();
        return $deskripsi->attribute_1;
    },

  ],
  [
  	'label' => 'LKJ',
  	'value' => function($data) use ($catalog_id) {
  		$lkj = CatalogMeta::find()
  		->andWhere(['catalog_id' => $catalog_id])
        ->andWhere(['type' => 'kompetensigram'])
        ->andWhere(['key' => 'kompetensi'])
        ->andWhere(['value' => $data->key])->One();
  		return $lkj->attribute_1;
  	},
  	'pageSummary' => true,
  ],


  [
    'class'=>'kartik\grid\EditableColumn',
    'label' => 'LKI',
    'attribute'=>'value',
    'format' => 'raw',
  	'pageSummary' => true,
    'readonly'=> $readonly,
    'value' => function($data) use ($catalog_id){

  		$assessmentmodel = ProjectAssessment::find()
  		->andWhere(['activity_id' => $_GET['id']])
        ->andWhere(['status' => 'active'])->One();
        $resultmodel = Kompetensigram::find()
        				->andWhere(['project_assessment_id' => $assessmentmodel->id])
        				->andWhere(['type' => 'kompetensigram'])
        				->andWhere(['key' => $data->key])->One();

        					return $resultmodel->value;
/*return Html::RadioList($data->key, $resultmodel->value, $radiolistoptions, [
		'item' => function($index, $label, $name, $checked, $value)
							{
								return Html::Label(Html::Radio($name,$checked,['class' => 'lkj']) .' '. $label);
							},
		]);
*/
    },
  
    'vAlign'=>'middle',
    'width'=>'100px',

    'editableOptions'=> function ($model, $key, $index) use ($colorPluginOptions ,$catalog_id) {

    	  		$lkj = CatalogMeta::find()
  		->andWhere(['catalog_id' => $catalog_id])
        ->andWhere(['type' => 'kompetensigram'])
        ->andWhere(['key' => 'kompetensi'])
        ->andWhere(['value' => $model->key])->One();
        

        $selections = [];
    	for ($i = 1; $i <= $lkj->attribute_1; $i++){
    		$selections[$i] = $i;
    	}
        return [
          'formOptions'=>['action' => ['/projects/activity/editkompetensigram'],
                  'id' => 'kompetensigram_' . $model->key .   '_form_name',
          ], // point to the new action
            'header'=>'LKI', 
            'size'=>'md',
            'placement' => 'top',
            'contentOptions' => [
                  'id' => $model->key . '_' . $index,   ],
            'inputType'=>\kartik\editable\Editable::INPUT_DROPDOWN_LIST,
             'data' => $selections,
             /*'itemOptions' => [
              'id' => $model->key . '_' . $index,
             ],
             */

            'options'=>[
                    'id' => 'kompetensigram_' . $model->key . '_form_name',
                    //'html5Options' => ['min' => 1, 'max' => 4],
            ],

        'beforeInput' => function ($form, $widget) use ($model, $index) {
          /*  echo $form->field($model, "publish_date")->widget(\kartik\widgets\DatePicker::classname(), [
                'options' => ['id' => "publish_date_{$index}"]
            ]);
            */
                echo 'Masukkan rating';
        },


            'afterInput'=>function ($form, $widget) use ($model, $index, $colorPluginOptions, $catalog_id) {
                /*return $form->field($model, "color")->widget(\kartik\widgets\ColorInput::classname(), [
                    'showDefaultPalette'=>false,
                    'options'=>['id'=>"color-{$index}"],
                    'pluginOptions'=>$colorPluginOptions,
                ]);
                */
    	  		$lkj = CatalogMeta::find()
  		->andWhere(['catalog_id' => $catalog_id])
        ->andWhere(['type' => 'kompetensigram'])
        ->andWhere(['key' => 'kompetensi'])
        ->andWhere(['value' => $model->key])->One();
        
return 'min = 1, max = ' . $lkj->attribute_1;
            }
            
        ];
    }
],

    [
        'class' => '\kartik\grid\FormulaColumn',
        'label' => 'Gap',
           'pageSummary' => true,
        'value' => function ($model, $key, $index, $widget) {
            $p = compact('model', 'key', 'index');
            // Write your formula below
            return -1 * ($widget->col(2, $p) - $widget->col(3, $p));
        }
    ],

    [
        'class' => '\kartik\grid\FormulaColumn',
        'pageSummary' => true,
          'pageSummaryFunc' => GridView::F_AVG,
        'label' => 'Pct (%)',
        'value' => function ($model, $key, $index, $widget) {
            $p = compact('model', 'key', 'index');
            // Write your formula below
            return round($widget->col(3, $p) / $widget->col(2, $p) * 100,2);
  //return round((($resultmodel->value / $lkj->attribute_1)  * 100),2);
        }
    ],



];



$psikogramGridColumns = [

//'order',
  //'project_assessment_id',
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
 /* [
  	'label' => 'Keterangan',
  	'value' => function($data) use ($catalog_id) {
  		$lkj = CatalogMeta::find()
  		->andWhere(['catalog_id' => $catalog_id])
        ->andWhere(['type' => 'kompetensigram'])
        ->andWhere(['key' => 'kompetensi'])
        ->andWhere(['value' => $data->key])->One();
  		return $lkj->attribute_1;
  	},
  	'pageSummary' => true,
  ],
*/
      [
        'label' => 'Skor',
           'pageSummary' => true,
           'attribute' => 'value',
    ],
    /*
      [
        'class' => '\kartik\grid\FormulaColumn',
        'label' => 'Skor',
           'pageSummary' => true,
        'value' => function ($model, $key, $index, $widget) {
            $p = compact('model', 'key', 'index');
            // Write your formula below
            return $widget->col(4, $p);
        }
    ],
    */

  [
    'class'=>'kartik\grid\EditableColumn',
    /*'pageSummary' => function($summary, $data, $widget) {
      $val = 0;
      foreach ($data as $key => $value) {
        # code...
        $val = sizeof($widget);
      }
      return $val;
    },
    */
      //'pageSummary' => 'asaere',
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
          'placement' => 'top',
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



        $assessment_report = new AssessmentReport();
        $kekuatan = new AssessmentReport();
        $kelemahan = new AssessmentReport();
        $saran_pengembangan = new AssessmentReport();

        $exec_summary_model = ProjectAssessmentResult::find()->andWhere(['type' => 'executive_summary'])
        ->andWhere(['project_assessment_id' =>$Pa->id])->One();
        $kekuatan_model = ProjectAssessmentResult::find()->andWhere(['type' => 'kekuatan'])
        ->andWhere(['project_assessment_id' =>$Pa->id])->One();
        $kelemahan_model = ProjectAssessmentResult::find()->andWhere(['type' => 'kelemahan'])
        ->andWhere(['project_assessment_id' =>$Pa->id])->One();
        $saran_pengembangan_model = ProjectAssessmentResult::find()->andWhere(['type' => 'saran_pengembangan'])
        ->andWhere(['project_assessment_id' =>$Pa->id])->One();
        if (null !== $exec_summary_model) {
                  $assessment_report->executive_summary = $exec_summary_model->textvalue;
                } else {
                  $assessment_report->executive_summary = '';
                }
        if (null !== $kekuatan_model) {
                  $assessment_report->kekuatan = $kekuatan_model->textvalue;
                } else {
                  $assessment_report->kekuatan = '';
                }
        if (null !== $kelemahan_model) {
                  $assessment_report->kelemahan = $kelemahan_model->textvalue;
                } else {
                  $assessment_report->kelemahan = '';
                }


        if (null !== $saran_pengembangan_model) {

              if (strlen($saran_pengembangan_model->textvalue) < 1 ) {         
                    // isi dengan saran
              } else {
                  $assessment_report->saran_pengembangan = $saran_pengembangan_model->textvalue;
                }
                } else {
                  //isi dengan saran
                  $assessment_report->saran_pengembangan = '';
                }



?>

  <?= $form->field($assessment_report, 'executive_summary')->textArea(['rows' => 6, 'readonly'=> $readonly])->hint('min 500 chars, max 1100 chars') ?>

<h3 align="center">PSIKOGRAM POTENSI</h3>
<hr/> 

<?php

echo GridView::widget([
    'dataProvider'=> $psikogramDataProvider,
    //'filterModel' => $searchModel,
    'columns' => $psikogramGridColumns,
    'responsive'=>true,
        'pjax'=>true, // pjax is set to always true for this demo
    'hover'=>true,
    'showPageSummary' => true
]);
?>
<hr/>
<h3 align="center">DIAGRAM KOMPETENSI</h3>
<hr/> 

<?php

echo GridView::widget([
    'dataProvider'=> $dataProvider,
    //'filterModel' => $searchModel,
    'columns' => $kompetensiGridColumns,
    'responsive'=>true,
        'pjax'=>true, // pjax is set to always true for this demo
    'hover'=>true,
    'showPageSummary' => true
]);



echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_uraian',
        //'itemView' => function($model, $key, $index, $widget){}

    'viewParams' => [
    	'catalog_id' => $catalog_id,
      'form' => $form,
      'readonly' => $readonly,
    ],
]);


/*

                $kekuatan = new AssessmentReport();
        $exec2_summary_model = ProjectAssessmentResult::find()->andWhere(['type' => 'kekuatan'])
        ->andWhere(['project_assessment_id' =>$Pa->id])->One();
        $kekuatan->executive_summary = $exec2_summary_model->textvalue;
  echo $form->field($kekuatan, 'textvalue')->textArea(['rows' => 10, 'readonly'=> $readonly])
  ->hint('min 500 chars, max 1100 chars')->label('Hal-hal positif yang menunjang kerja (kekuatan)');
  */


  echo '<hr/><hr/>';
  echo '<h2>KESIMPULAN</h2>';
?>


  
<?= $form->field($assessment_report, 'kekuatan')->textArea(['rows' => 6, 'readonly'=> $readonly])->hint('') ?>
<?= $form->field($assessment_report, 'kelemahan')->textArea(['rows' => 6, 'readonly'=> $readonly])->hint('') ?>

<?= $form->field($assessment_report, 'saran_pengembangan')->textArea(['rows' => 6, 'readonly'=> $readonly])->hint('') ?>
    <div class="radarChart" style="float:left; background-image: url('/images/Psikogram.png'); 
    background-repeat: no-repeat;background-size: 480px 518px;"></div>
																											   

    <hr/>
<table class="center">
<tr>
<td><img src="/images/kompetensiSumbuY.png"></td>
<td>
    <div id="chart_div" 
    style="width: 600px; height: 600px; 
    background-image: url('/images/ninecell.png'); 
    background-repeat: no-repeat;
    background-position: center; 
    ">
    </div>
 </td></tr>
 <tr>
 <td></td>
<td align="center"><img src="/images/potensiSumbuX.png"></td>

	

 </table>  											 

    



