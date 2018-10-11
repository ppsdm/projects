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




$this->context->initAssessment($_GET['id'], $catalog_id);
//Yii::$app->runAction('activity/initassessment', ['id' => $_GET['id'], 'catalog_id' => $catalog_id]);

   $Pa = ProjectAssessment::find()->andWhere(['activity_id'=> $_GET['id']])->One();
   
   $PArp = ProjectAssessmentResult::find()->andWhere(['type'=>'psikogram'])->andWhere(['project_assessment_id'=>$Pa->id])->Sum('value');
   $PArk = ProjectAssessmentResult::find()->andWhere(['type'=>'kompetensigram'])->andWhere(['project_assessment_id'=>$Pa->id])->Sum('value');

   $sumC =     CatalogMeta::find()->andWhere(['catalog_id'=>$Pa->catalog_id])->andWhere(['type'=>'kompetensigram'])->andWhere(['key'=>'kompetensi'])->Sum('attribute_1');

   //echo $PArp/66*100 .'<br/>';
   //echo $PArk/$sumC*100 .'<br/>';

   $saran_komplit = '';
   
?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart'], 'language': 'id'});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Potensi', 'Kompetensi'],
          [ <?php echo round($PArp/66*100); ?>,     <?php echo round($PArk/$sumC*100); ?>], //ini harus diisi

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
    $kompetensigram_models = $kompetensiDataProvider->getModels();
    foreach ($kompetensigram_models as $kompkey => $kompvalue) {
        $result_object['kompetensigram'][$kompvalue['key']]['lki'] = isset($kompvalue['value']) ? $kompvalue['value'] : 0 ;
        $x = CatalogMeta::find()->andWhere(['type' => 'kompetensigram'])->andWhere(['key' => 'kompetensi'])->andWhere(['catalog_id'=> $catalog_id])
        ->andWhere(['value' => $kompvalue['key']])->One();
    $result_object['kompetensigram'][$kompvalue['key']]['lkj'] = $x->attribute_1;
    }
     


       
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
      //for ($i = 1; $i <= $lkj->attribute_1; $i++){
for ($i = 1; $i <= 4; $i++){
        $selections[$i] = $i;
      }
        return [
          'formOptions'=>['action' => ['/projects/activity/editkompetensigram'],
                  'id' => 'kompetensigram_' . $model->key .   '_form_name',
          ], // point to the new action
            'header'=>'LKI', 
            'size'=>'md',
            'placement' => 'left',
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
        
return 'min = 1, max = 4';
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
        'pageSummary' => function($summary, $data, $widget) use ($PArk, $sumC) {
           $p = compact('model', 'key', 'index');
           return round($PArk / $sumC * 100, 2);
            //return round($widget->col(3, $p) / $widget->col(2, $p) * 100,2);
        },
          ////'pageSummaryFunc' => GridView::F_AVG,
        'label' => 'Pct (%)',
        'value' => function ($model, $key, $index, $widget) {
            $p = compact('model', 'key', 'index');
            // Write your formula below
            return round($widget->col(3, $p) / $widget->col(2, $p) * 100,2);
  //return round((($resultmodel->value / $lkj->attribute_1)  * 100),2);
        }
    ],

/*[
  'label' => 'order',
  'attribute' => 'order',
   'value' => 'order',
],
*/
];




$kompetensiGridColumns2 = [
  [
    'label' => 'Kategori',
    'value' => function($data) use ($catalog_id){
      $lkj = CatalogMeta::find()
      ->andWhere(['catalog_id' => $catalog_id])
        ->andWhere(['type' => 'kompetensigram'])
        ->andWhere(['key' => 'kompetensi'])
        ->andWhere(['value' => $data['key']])->One();
      return $lkj->attribute_2;
    },

  ],
  [
    'label' => 'Kompetensi',
    'value' => function($data){
        $deskripsi = RefAssessmentDictionary::find()
        ->andWhere(['type' => 'kompetensigram'])
        ->andWhere(['key' => 'kompetensi'])
        ->andWhere(['value' => $data['key']])->One();
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
        ->andWhere(['value' => $data['key']])->One();
      return $lkj->attribute_1;
    },
    'pageSummary' => true,
  ],
  /*
  [
    'class'=>'kartik\grid\EditableColumn',
    'label' => 'LKI',
    //'model' => $model,
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
                ->andWhere(['key' => $data['key']])->One();

                  return $resultmodel->value;
    },
  
    'vAlign'=>'middle',
    'width'=>'100px',

    'editableOptions'=> function ($model, $key, $index) use ($colorPluginOptions ,$catalog_id) {

            $lkj = CatalogMeta::find()
      ->andWhere(['catalog_id' => $catalog_id])
        ->andWhere(['type' => 'kompetensigram'])
        ->andWhere(['key' => 'kompetensi'])
        ->andWhere(['value' => $model['key']])->One();
        

        $selections = [];
      //for ($i = 1; $i <= $lkj->attribute_1; $i++){
for ($i = 1; $i <= 4; $i++){
        $selections[$i] = $i;
      }
        return [
          'formOptions'=>['action' => ['/projects/activity/editkompetensigram'],
                  'id' => 'kompetensigram_' . $model['key'] .   '_form_name',
          ], // point to the new action
            'header'=>'LKI', 
            'size'=>'md',
            'placement' => 'left',
            'contentOptions' => [
                  'id' => $model['key'] . '_' . $index,   ],
            'inputType'=>\kartik\editable\Editable::INPUT_DROPDOWN_LIST,
             'data' => $selections,


            'options'=>[
                    'id' => 'kompetensigram_' . $model['key'] . '_form_name',
                    //'html5Options' => ['min' => 1, 'max' => 4],
            ],

        'beforeInput' => function ($form, $widget) use ($model, $index) {

                echo 'Masukkan rating';
        },


            'afterInput'=>function ($form, $widget) use ($model, $index, $colorPluginOptions, $catalog_id) {

            $lkj = CatalogMeta::find()
      ->andWhere(['catalog_id' => $catalog_id])
        ->andWhere(['type' => 'kompetensigram'])
        ->andWhere(['key' => 'kompetensi'])
        ->andWhere(['value' => $model['key']])->One();
        
return 'min = 1, max = 4';
            }
            
        ];
    }
],
*/
/*
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
*/

]; 




$psikogramGridColumns2 = [

//'id','type','key','value','ordering',
    [
    'label' => 'Kategori',
    'value' => function($data) use ($catalog_id){
      $lkj = CatalogMeta::find()
      ->andWhere(['catalog_id' => $catalog_id])
        ->andWhere(['type' => 'psikogram'])
        ->andWhere(['key' => 'aspek'])
        ->andWhere(['value' => $data['key']])->One();
        //return $data['key'];
      return isset($lkj->attribute_2) ? $lkj->attribute_2 : 'ga ada';
    },
    'contentOptions' => ['style'=>' white-space: normal;'],
  ],
  [
    'label' => 'Aspek psikologis',
    'value' => function($data){
        $deskripsi = RefAssessmentDictionary::find()
        ->andWhere(['type' => 'psikogram'])
        ->andWhere(['key' => 'aspek'])
        ->andWhere(['value' => $data['key']])->One();

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
        ->andWhere(['value' => $data['key']])->One();
        return $deskripsi->attribute_2;
    },
    'contentOptions' => ['style'=>'width:350px; white-space: normal;'],

  ],
      [
        'label' => 'Skor',
           'pageSummary' => true,
           'attribute' => 'value',
    ],

  [
    'class'=>'kartik\grid\EditableColumn',
    'label' => 'Penilaian',
    //'name' => 'value',
    'attribute'=>'value',
    //'model' => $model,
    'format' => 'raw',
    'value' => function($data) use ($catalog_id, $readonly){

$radiolistoptions = [1 => '1',2 => '2',3=>'3',4=>'4',5=>'5',6=>'6',7 =>'7'];
      $assessmentmodel = ProjectAssessment::find()
      ->andWhere(['activity_id' => $_GET['id']])
        ->andWhere(['status' => 'active'])->One();
        $resultmodel = ProjectAssessmentResult::find()
                ->andWhere(['project_assessment_result.project_assessment_id' => $assessmentmodel->id])
                ->andWhere(['project_assessment_result.type' => 'psikogram'])
                ->andWhere(['project_assessment_result.key' => $data['key']])->One();
return Html::RadioList($data['key'], $resultmodel->value, $radiolistoptions, [
    'item' => function($index, $label, $name, $checked, $value) use ($readonly)
              {
                $aspek = CatalogMeta::find()->andWhere(['catalog_meta.type' => 'psikogram'])->andWhere(['catalog_meta.key' => 'aspek'])->andWhere(['value' => $name])->One();
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

    'readonly'=> $readonly,
    'editableOptions'=> function ($model, $key, $index) use ($colorPluginOptions) {
        return [
        'name' => 'editable_value',
          'formOptions'=>['action' => ['/projects/activity/editpsikogram']], // point to the new action
          'id' => 'psikogram_' . $model['key'] . '_form_name',
            'header'=>'Result', 
            'size'=>'md',
          'placement' => 'left',
            'inputType'=>\kartik\editable\Editable::INPUT_RANGE,
             //'data' => [0 => 'pass', 1 => 'fail', 2 => 'waived', 3 => 'todo'],
            'options'=>[
                    'html5Options' => ['min' => 1, 'max' => 7],
                    'id' => 'psikogram_' . $model['key'] . '_form_name',
            ],

        'beforeInput' => function ($form, $widget) use ($model, $index) {

                echo 'Masukkan rating';
        },


            'afterInput'=>function ($form, $widget) use ($model, $index, $colorPluginOptions) {
return '';
            }
            
        ];
    }
],

];



       
      //  $kekuatan = new AssessmentReport();
      //  $kelemahan = new AssessmentReport();
      //  $saran_pengembangan = new AssessmentReport();



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

                    // isi dengan saran
                    $hasil_kompetensi = ProjectAssessmentResult::find()
                    ->andWhere(['project_assessment_id' => $Pa->id])
                    ->andWhere(['type' => 'kompetensigram'])->All();

                  $gaps = [];
                  foreach ($hasil_kompetensi as $key_kompetensi2 => $value_kompetensi2) {
                      $gh = CatalogMeta::find()
                      ->andWhere(['catalog_id' => $catalog_id])
                      ->andWhere(['type' => 'kompetensigram'])
                      ->andWhere(['key' => 'kompetensi'])->andWhere(['value' => $value_kompetensi2->key])->One();
                      $gap = $gh->attribute_1 - $value_kompetensi2->value;
                      if ($gap > 0) {
                     //   $gaps[$value_kompetensi2->key][$gh->attribute_2][$gh->attribute_3] = $gap;
                        $add['aspek'] = $value_kompetensi2->key;
                        $add['aspek_panjang'] = $gh->value;
                        $add['kategori'] = $gh->attribute_2;
                        $add['gap'] = $gap;
                        $add['lki'] = $value_kompetensi2->value;
                        $add['lkj'] = $gh->attribute_1;
                        $add['order'] = $gh->attribute_3;
                        array_push($gaps, $add);


                      }
                  }

                    $saran = '';
ArrayHelper::multisort($gaps, ['kategori', 'gap' ,'order'], [SORT_ASC, SORT_ASC, SORT_ASC]);
                       //$assessment_report->saran_pengembangan = json_encode($gaps);

                    foreach ($gaps as $gap_key => $gap_value) {
                      # code...
                    $randomizer = 1;

                    
                        $maxmodel = RefAssessmentDictionary::find()
                        ->andWhere(['type' => 'saran_kompetensigram'])
                        ->andWhere(['key' =>$gap_value['aspek']])
                        ->All();
                        $size = sizeof($maxmodel);
                        
                        if ($size > 0) {
                        $random =  rand();
                        $randomizer = $random % $size;
                        $randomizer++;
                      }

                      $lki = RefAssessmentDictionary::find()
                      ->andWhere(['type' => 'saran_kompetensigram'])
                      ->andWhere(['key' =>$gap_value['aspek']])
                      ->andWhere(['value' => $randomizer])
                      ->One();
                      if (null!== $lki) {
 //Yii::$app->session->addFlash('warning', 'ada lki ');
                          $saran =  '<br/>' . $gap_value['aspek_panjang'] . 
                          //$randomizer . 
                          ' (GAP = ' . $gap_value['gap'].') : ' .  $lki->textvalue;
                          } else {
                          $saran =  '<br/>' . $gap_value['aspek'] . $randomizer . 
                          //$randomizer . 
                          ' : Tidak ada Saran' ;
                          };
                       $saran_komplit = $saran_komplit  . $saran;


                    }



                  $assessment_report->saran_pengembangan = $saran_pengembangan_model->textvalue;
                
                } else {
                  //isi dengan saran
                  $assessment_report->saran_pengembangan = '';
                }





  //echo '<h3>Executive Summary</h3><div>' . $assessment_report->executive_summary . '</div>';



echo $form->field($assessment_report, 'executive_summary')->widget(\yii\redactor\widgets\Redactor::className(), [
    'clientOptions' => [
    //    'imageManagerJson' => ['/redactor/upload/image-json'],
      //  'imageUpload' => ['/redactor/upload/image'],
      //  'fileUpload' => ['/redactor/upload/file'],
       // 'lang' => 'zh_cn',
        'plugins' => ['clips', 'fontcolor','fullscreen', 'counter'],
    ]
]);
        if ($is_assessor) {
        if ($readonly) {

        } else {
           // echo Html::a(Yii::t('app', 'Save data'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);

            echo Html::a(Yii::t('app', 'Save'), ['save', 'id' => $_GET['id']], [
            'class' => 'btn btn-warning',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to save this report?'),
                'method' => 'post',
            ],
        ]);
   
        }
        }

                    if(null !== $is_so){
        if ($readonly) {

        } else {
            echo Html::a(Yii::t('app', 'Temporary Save'), ['sosaved', 'id' => $_GET['id']], [
            'class' => 'btn btn-info',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to finish review this item?'),
                'method' => 'post',
            ],
        ]);
            }
          }
            


?>
<h3 align="center">PSIKOGRAM POTENSI</h3>
<hr/> 

<?php
/*echo GridView::widget([
    'dataProvider'=> $psikogramSQLDataProvider,
    'filterModel' => $psikogramSearchModel,
    'columns' => $psikogramGridColumns2,
    'responsive'=>true,
        'pjax'=>true, // pjax is set to always true for this demo
    'hover'=>true,
    'showPageSummary' => true,
    'summary'=>'', 
]);
*/

echo GridView::widget([
    'dataProvider'=> $psikogramDataProvider,
    'filterModel' => $psikogramSearchModel,
    'columns' => $psikogramGridColumns,
    'responsive'=>true,
        'pjax'=>true, // pjax is set to always true for this demo
    'hover'=>true,
    'showPageSummary' => true,
    'summary'=>'', 
]);

?>
<hr/>

<h3 align="center">DIAGRAM KOMPETENSI</h3>

    <div class="radarChart" style="float:left; background-image: url('<?=Url::base()?>/images/1/<?php echo $catalog_id;?>.png'); 
    background-repeat: no-repeat;background-size: 480px 518px;"></div>
                                                         

    <hr/>
<hr/> 


<?php

echo GridView::widget([
    'dataProvider'=> $kompetensiDataProvider,
    'filterModel' => $psikogramSearchModel,
    'columns' => $kompetensiGridColumns,
    'responsive'=>true,
        'pjax'=>true, // pjax is set to always true for this demo
    'hover'=>true,
    'showPageSummary' => true,
    'summary'=>'', 
]);


?>

<hr/>

<?php

echo ListView::widget([
    'dataProvider' => $kompetensiDataProvider,
    'itemView' => '_uraian',
    'summary'=>'', 
        //'itemView' => function($model, $key, $index, $widget){}

    'viewParams' => [
      'catalog_id' => $catalog_id,
      'form' => $form,
      'readonly' => $readonly,
    ],
]);




  echo '<hr/><hr/>';
  echo '<h2>KESIMPULAN</h2>';

if ($readonly) {
//echo $form->field($assessment_report, 'kekuatan')->textArea(['rows' => 6, 'readonly'=> $readonly])->hint('');
//echo $form->field($assessment_report, 'kelemahan')->textArea(['rows' => 6, 'readonly'=> $readonly])->hint('');

//echo $form->field($assessment_report, 'saran_pengembangan')->textArea(['rows' => 6, 'readonly'=> $readonly])->hint('');

    echo '<h3>Kekuatan</h3><div>' . $assessment_report->kekuatan . '</div>';
        echo '<h3>Kelemahan</h3><div>' . $assessment_report->kelemahan . '</div>';
            echo '<h3>Saran Pengembangan</h3><div>' . $assessment_report->saran_pengembangan . '</div>';


} else {


echo $form->field($assessment_report, 'kekuatan')->widget(\yii\redactor\widgets\Redactor::className(), [
    'clientOptions' => [
        'plugins' => ['clips', 'fontcolor','fullscreen', 'counter']
    ]
]);
        if ($is_assessor) {
        if ($readonly) {

        } else {
           // echo Html::a(Yii::t('app', 'Save data'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);

            echo Html::a(Yii::t('app', 'Save'), ['save', 'id' => $_GET['id']], [
            'class' => 'btn btn-warning',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to save this report?'),
                'method' => 'post',
            ],
        ]);


            
        }


        }

          if(null !== $is_so){
            echo Html::a(Yii::t('app', 'Temporary Save'), ['sosaved', 'id' => $_GET['id']], [
            'class' => 'btn btn-info',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to finish review this item?'),
                'method' => 'post',
            ],
        ]);
            }

   


echo $form->field($assessment_report, 'kelemahan')->widget(\yii\redactor\widgets\Redactor::className(), [
    'clientOptions' => [
        'plugins' => ['clips', 'fontcolor','fullscreen', 'counter']
    ]
]);

        if ($is_assessor) {
        if ($readonly) {

        } else {
           // echo Html::a(Yii::t('app', 'Save data'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);

            echo Html::a(Yii::t('app', 'Save'), ['save', 'id' => $_GET['id']], [
            'class' => 'btn btn-warning',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to save this report?'),
                'method' => 'post',
            ],
        ]);


            
        }


        }

                    if(null !== $is_so){
            echo Html::a(Yii::t('app', 'Temporary Save'), ['sosaved', 'id' => $_GET['id']], [
            'class' => 'btn btn-info',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to finish review this item?'),
                'method' => 'post',
            ],
        ]);
            }

   



echo $form->field($assessment_report, 'saran_pengembangan')->widget(\yii\redactor\widgets\Redactor::className(), [
    'options' => [
      'id' =>'saranpengembangan', 
    'name' =>'saranpengembangan',
  ],
    'clientOptions' => [
    'minHeight' => 300,
        'plugins' => ['clips', 'fontcolor','fullscreen', 'counter'],
            'counterCallback' => new \yii\web\JsExpression("
                function(data) {
                    console.log('Words: ' + data.words);
                    console.log('Characters: ' + data.characters);
                    console.log('Characters w/o spaces: ' + (data.characters - data.spaces));
                    console.log(this);
                    console.log(this.core.getElement().context.id);
                    $('#hint_' + this.core.getElement().context.id).html('<i>words : ' + data.words + ', characters : ' + (data.characters - data.spaces) + '</i>');

                }
            "),
    ]
]);

$hint_text = 'words : ' . str_word_count(strip_tags($assessment_report->saran_pengembangan)) . ' , characters : ' . strlen(str_replace(' ','',strip_tags($assessment_report->saran_pengembangan)));

   echo '<div id="hint_saranpengembangan"><i>'.$hint_text.'</i></div>';
        if ($is_assessor) {
        if ($readonly) {

        } else {
           // echo Html::a(Yii::t('app', 'Save data'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);

            echo Html::a(Yii::t('app', 'Save'), ['save', 'id' => $_GET['id']], [
            'class' => 'btn btn-warning',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to save this report?'),
                'method' => 'post',
            ],
        ]);


            
        }


        }

                    if(null !== $is_so){
            echo Html::a(Yii::t('app', 'Temporary Save'), ['sosaved', 'id' => $_GET['id']], [
            'class' => 'btn btn-info',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to finish review this item?'),
                'method' => 'post',
            ],
        ]);
            }

   

}


?>
  
<h3>Saran Pengembangan Sistem</h3>
   <br/><?php echo $saran_komplit ;?>


<table class="center">
<tr>
<td>
<?php
$sumbuY = round($PArk/$sumC*100);
$sumbuX = round($PArp/66*100);
if (round($PArk/$sumC*100) >=100) {
    echo "<img src=".Url::base()."/images/kompetensiSumbuY-top.png>";
}

else if ((round($PArk/$sumC*100) >= 75) && (round($PArk/$sumC*100) <= 99)) {
    echo "<img src=".Url::base()."/images/kompetensiSumbuY-middle.png>";

}

else {
    //echo round($PArp/66*100);
   echo "<img src=".Url::base()."/images/kompetensiSumbuY-bottom.png>";
}
?>
<td>
    <div id="chart_div" 
    style="width: 600px; height: 600px; 
    background-image: url('<?=Url::base()?>/images/ninecell.png'); 
    background-repeat: no-repeat;
    background-position: center; 
    ">
    </div>
 </td></tr>
 <tr>
 <td>
 <div style= "margin:10px;">
<table style="width: 100%; margin-left: auto; margin-right: auto;" border="1" cellspacing="1" cellpadding="1">
<tbody>
<tr>
<td bgcolor="yellow">X</td>
<td bgcolor="yellow"><?=$sumbuX;?>%</td>
<td rowspan="2"><h2>
<?php 

if ($sumbuX < 75 && $sumbuY < 75) {$ninecellScore = 1;}
else if ($sumbuX < 75 && $sumbuY < 100 && $sumbuY > 74 && $sumbuY < 100) {$ninecellScore = 2;}
else if ($sumbuX >= 75 && $sumbuX < 100 && $sumbuY < 75) {$ninecellScore = 3;}
else if ($sumbuX < 75 && $sumbuY < 99) {$ninecellScore = 4;}
else if ($sumbuX >= 75 && $sumbuX < 100 && $sumbuY > 74 && $sumbuY < 100) {$ninecellScore = 5;}
else if ($sumbuX >= 100 && $sumbuY < 75) {$ninecellScore = 6;}
else if ($sumbuX >= 75 && $sumbuX < 100 && $sumbuY >= 100) {$ninecellScore = 7;}
else if ($sumbuX >= 100 && $sumbuY >= 75 && $sumbuY < 100) {$ninecellScore = 8;}
else if ($sumbuX >= 100 && $sumbuY >= 100) {$ninecellScore = 9;}
else {$ninecellScore = 0;}
echo '<font style="color:green;">'.$ninecellScore.'</font>';
?>
</h2></td>
</tr>
<tr >
<td bgcolor="#B8CCE4">Y</td>
<td bgcolor="#B8CCE4"><?=$sumbuY;?>%</td>
</tr>
</tbody>
</table>
</div>
 </td>
<td align="center">
<?php


if (round($PArp/66*100) >=100) {
    echo "<img src=".Url::base()."/images/potensiSumbuX.png>";
}

else if ((round($PArp/66*100) >= 75) && (round($PArp/66*100) <= 99)) {
    echo "<img src=".Url::base()."/images/potensiSumbuX-middle.png>";

}

else {
 //   echo round($PArp/66*100);
    echo "<img src=".Url::base()."/images/potensiSumbuX-bottom.png>";
}
?>


</td>

  

 </table>                        

    



<?php

if (isset($result_object)) {
 //echo $this->context->view->viewFile;
 $path_parts = pathinfo($viewFile);
//  echo $path_parts['filename'];
echo $this->render('_'.$path_parts['filename'], ['result_object' => $result_object]);

 //echo '<pre>';
 //print_r($result_object);
} else {
  echo 'NO DATA';
}
  ?>