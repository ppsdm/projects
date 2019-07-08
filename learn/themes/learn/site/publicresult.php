<?php



use app\modules\tao\models\TaoUriMap;
use app\modules\catalog\models\CatalogGeneral;
use app\modules\assessment\models\Assessment;
use app\modules\assessment\models\AssessmentResult;
use app\modules\tao\models\Statements;
use app\modules\tao\models\VariablesStorage;
use app\modules\tao\models\ResultsStorage;

use frontend\assets\AppAsset;
use frontend\assets\ChartAsset;
use frontend\assets\RatingAsset;
use frontend\assets\ProgressbarAsset;
use yii\helpers\Url;
use app\modules\profile\models\ProfileGeneral;
AppAsset::register($this);
ChartAsset::register($this);
RatingAsset::register($this);
ProgressbarAsset::register($this);

//echo 'thos is 39';
$assessment = Assessment::findOne($id);









$delivery= TaoUriMap::find()->andWhere(['id' =>$assessment->catalog_id])->andWhere(['type' => 'delivery'])->One();
$user= TaoUriMap::find()->andWhere(['id' =>$uid])->andWhere(['type' => 'user'])->One();
$results = ResultsStorage::find()->andWhere(['delivery' => trim($delivery->uri)])->andWhere(['test_taker' =>trim($user->uri)])->All();
$latest_result = '';


foreach ($results as $key => $value) {
  //echo $value->id . ' : ' . $value->result_id . ' : ' . $value->timestamp;
  $latest_result = $value->result_id;
  //echo '--+<br/>';
}


if (sizeof($results) > 0) {


$totalscore = 0;
$totalresponse = 0;

echo '<hr/>';
$result_items = VariablesStorage::find()->andWhere(['results_result_id' => $latest_result])->andWhere(['not', ['item' => null]])->All();


foreach ($result_items as $key => $value) {

      if($value->identifier == 'numAttempts'){
   // echo str_replace($latest_result . '.', "", $value->call_id_item) . ' : ' . $value->identifier . ' = ' . VariablesStorage::getNumattempts($value) . '<br/>';

    } else if($value->identifier == 'completionStatus'){
  //  echo str_replace($latest_result . '.', "", $value->call_id_item) . ' : ' . $value->identifier . ' = ' . VariablesStorage::getValue($value) . '<br/>';

    } else if($value->identifier == 'SCORE'){
      $totalscore = $totalscore + VariablesStorage::getValue($value);
//    echo str_replace($latest_result . '.', "", $value->call_id_item) . ' : ' . $value->identifier . ' = ' . VariablesStorage::getValue($value). '<br/>';


    } else if (strpos($value->identifier, 'RESPONSE') !== false) {
      $totalresponse++;
    } else {

    //echo str_replace($latest_result . '.', "", $value->call_id_item) . ' : ' . $value->identifier . ' = ' . getCorrectresponse($value);
//  echo str_replace($latest_result . '.', "", $value->call_id_item) . ' : ' . $value->identifier. '<br/>';

    }
}
?>

<div class="row text-center">

<img src="<?= Yii::$app->request->baseUrl ?>/images/hasil_tes.png">

     <div class="row">

       <div class="col-md-6 text-right">
         Benar <BR>
           <?=$totalscore;?>
       </div>
       <div class="col-md-6 text-left">
         Salah <BR>
           <?=$totalresponse;?>
       </div>

       <?php
       $finalscore = 0;
       if ($totalresponse > 0)
       $finalscore = round($totalscore/$totalresponse,2) * 100;
            echo '<h2><br/>SCORE : ' . $finalscore;
       echo '</h2>';

       $user_profile = ProfileGeneral::findOne($uid);
       $this->registerMetaTag(['property' => 'og:url', 'content' => Url::current()]);
$this->registerMetaTag(['property' => 'og:type', 'content' => 'article']);
$this->registerMetaTag(['property' => 'og:title', 'content' =>  $user_profile->first_name . ' baru saja mengerjakan Latihan Soal di SiapNgampus dan mendapatkan skor ' . $finalscore]);
$this->registerMetaTag(['property' => 'og:description', 'content' => 'Di SiapNgampus ada semua yang kamu butuhkan untuk belajar kamu. Uji dirimu dan lihat rankingmu.']);
$this->registerMetaTag(['property' => 'og:image', 'content' => 'http://www.siapngampus.com/images/logo_edulab_200px.png']);


        ?>
     </div>

 </div>
  <div class="col-lg-5">
  </div>
 <div class="col-lg-2">
<!--canvas id="myChart" width="30" height="30"></canvas-->
<link href="https://fonts.googleapis.com/css?family=Raleway:400,300,600,800,900" rel="stylesheet" type="text/css">
<div id="container"   style="margin: 0px;
  width: 100%;
  height: 100%;
  position: relative;"></div>
</div>
<script>
var ctx = document.getElementById("myChart");

var myChart = new Chart(ctx, {
    //type: 'bar',
        type: 'doughnut',
    data: {
        labels: ["Salah", "Benar",],
        datasets: [{
            label: '# of Votes',
            data: [<?=$totalresponse - $totalscore?> , <?=$totalscore?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        title: {
            display: false,
            text: 'Benar/Salah'
        }
    }
});
</script>

<!--select id="example">
  <option value="1">1</option>
  <option value="2">2</option>
  <option value="3">3</option>
  <option value="4">4</option>
  <option value="5">5</option>
</select-->



<script type="text/javascript">


// progressbar.js@1.0.0 version is used
// Docs: http://progressbarjs.readthedocs.org/en/1.0.0/

var bar = new ProgressBar.Circle(container, {
  color: '#aaa',
  // This has to be the same size as the maximum width to
  // prevent clipping
  strokeWidth: 4,
  trailWidth: 1,
  easing: 'easeInOut',
  duration: 1400,
  text: {
    autoStyleContainer: false
  },
  from: { color: '#aaa', width: 1 },
  to: { color: '#333', width: 4 },
  // Set default step function for all animate calls
  step: function(state, circle) {
    circle.path.setAttribute('stroke', state.color);
    circle.path.setAttribute('stroke-width', state.width);

    var value = Math.round(circle.value() * 100);
    //var value = <?= $finalscore?>;
    if (value === 0) {
      circle.setText('');
    } else {
      circle.setText(value);
    }

  }
});
bar.text.style.fontFamily = '"Raleway", Helvetica, sans-serif';
bar.text.style.fontSize = '2rem';

bar.animate(<?= $finalscore/100?>);  // Number from 0.0 to 1.0



</script>

        <?php

} else {

echo '<h1>No Result Yet</h1>';

}




?>