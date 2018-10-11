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
use vova07\imperavi\Widget as Redactor;


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
        {axis:'',value:".$result_object['kompetensigram']['atp']['lkj']."},
        {axis:'',value:".$result_object['kompetensigram']['ban']['lkj']."},     
        {axis:'',value:".$result_object['kompetensigram']['bku']['lkj']."},      
        {axis:'',value:".$result_object['kompetensigram']['ppo']['lkj']."},  
        {axis:'',value:".$result_object['kompetensigram']['kpt']['lkj']."},  
        {axis:'',value:".$result_object['kompetensigram']['ngo']['lkj']."},          
      ],[
        {axis:'',value:".$result_object['kompetensigram']['int']['lki']."},
        {axis:'',value:".$result_object['kompetensigram']['bpl']['lki']."},
        {axis:'',value:".$result_object['kompetensigram']['ksn']['lki']."},
        {axis:'',value:".$result_object['kompetensigram']['pfs']['lki']."},
        {axis:'',value:".$result_object['kompetensigram']['atp']['lki']."},
        {axis:'',value:".$result_object['kompetensigram']['ban']['lki']."},     
        {axis:'',value:".$result_object['kompetensigram']['bku']['lki']."},      
        {axis:'',value:".$result_object['kompetensigram']['ppo']['lki']."},  
        {axis:'',value:".$result_object['kompetensigram']['kpt']['lki']."},  
        {axis:'',value:".$result_object['kompetensigram']['ngo']['lki']."},  
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
roundStrokes: false,
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