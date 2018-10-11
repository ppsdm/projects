<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\web\View;
use app\assets\AppAsset;
//use app\assets\RadarAsset;
use vendor\gamantha\pao\project\Activity;
use common\modules\profile\models\Profile;
use common\modules\profile\models\ProfileMeta;


$this->title = 'Debug';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.6/d3.min.js',['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('@web/js/radarChart.js',['position' => \yii\web\View::POS_HEAD]);
$this->registerJs(
"var margin = {top: 80, right: 75, bottom: 150, left: 80},
width = Math.min(500, window.innerWidth - 10) - margin.left - margin.right,
height = Math.min(width, window.innerHeight - margin.top - margin.bottom - 20);
    
    var data = [
      [
        {axis:'',value:4},
        {axis:'',value:3},
        {axis:'',value:4},
        {axis:'',value:4},
        {axis:'',value:3},
        {axis:'',value:4},
        {axis:'',value:4},
        {axis:'',value:4},		
        {axis:'',value:4},		
        {axis:'',value:4},			
      ],[
        {axis:'',value:3},
        {axis:'',value:4},
        {axis:'',value:4},
        {axis:'',value:4},
        {axis:'',value:5},
        {axis:'',value:2},
        {axis:'',value:4},
        {axis:'',value:3},		
        {axis:'',value:4},		
        {axis:'',value:4},		
      ]
    ];


var color = d3.scale.ordinal()
.range(['#00A0B0','#CC333F']);

var radarChartOptions = {
w: width,
h: height,
margin: margin,
maxValue: 5,
levels: 5,
roundStrokes: true,
color: color,
opacityArea: 0.35,
opacityCircles: 0,
dotRadius: 6,
strokeWidth: 1.5, 
wrapWidth: 1,
};

RadarChart('.radarChart', data, radarChartOptions);"   ,
    View::POS_READY,
'ny-button-handler'
);
?>
<div class="site-debug">
<code><?= __FILE__ ?></code>
    <h3><?= Html::encode($this->title) ?></h3>

    <p>This is the Debug page. You may modify the following file to customize its content:</p>

    
    <div class="radarChart" style="float:left; background-image: url('/images/Psikogram.png'); background-repeat: no-repeat;background-size: 500px 540px;"></div>

    <div id="chart_div" style="width: 600px; height: 600px; float:right"></div>
   
</div>


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart'], 'language': 'id'});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Potensi', 'Kompetensi'],
          [ 69,      77],

        ]);

        var options = {
          title: 'Gambaran Posisi 9-Cell (Kompetensi dan Potensi)',
          hAxis: {title: 'Potensi', minValue: 0, maxValue: 100,gridlines:{color: '#333', count: 7}},
          vAxis: {title: 'Kompetensi', minValue: 0, maxValue: 100, gridlines:{color: '#333', count: 7}},
		  crosshair: { trigger: 'both' },
          legend: 'none',
		  //vAxis.gridlines:{color: '#333', count: 4}
        };

        var chart = new google.visualization.ScatterChart(document.getElementById('chart_div'));

        chart.draw(data, options);
      }
    </script>

   

