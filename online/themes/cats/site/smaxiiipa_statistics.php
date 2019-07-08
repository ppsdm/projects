<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use app\modules\catalog\models\CatalogGeneral;
use app\modules\tao\models\TaoUriMap;
use app\modules\catalog\models\CatalogPrice;
use app\modules\assessment\models\AssessmentResult;

use kartik\social\FacebookPlugin;

$persubjectaverage = 0;
$persubjectranking = 0;
$overallranking = 0;

use frontend\assets\AppAsset;
use frontend\assets\ChartAsset;
use frontend\assets\RatingAsset;




AppAsset::register($this);
ChartAsset::register($this);
RatingAsset::register($this);



$directory_array = [
[
    'subject' => 'Matematika',
    'imageurl' => '----',
    'tag'=>',smaxiiipa,matematika,'
],
[
    'subject' => 'Fisika',
    'imageurl' => '----',
    'tag'=>',smaxiiipa,fisika,'
],
[
    'subject' => 'Kimia',
    'imageurl' => '----',
    'tag'=>',smaxiiipa,kimia,'
],
[
    'subject' => 'Biologi',
    'imageurl' => '----',
    'tag'=>',smaxiiipa,biologi,'
],
[
    'subject' => 'Bahasa Inggris',
    'imageurl' => '----',
    'tag'=>',smaxiiipa,inggris,'
],
[
    'subject' => 'Bahasa Indonesia',
    'imageurl' => '----',
    'tag'=>',smaxiiipa,indonesia,'
]
];

$matpel_array = [];
$matpellist = "";
$myavg_list = "";
$useravg_list = "";
$myranking_list = "";

foreach ($directory_array as $key => $value) {
    # code...
            $selections = explode(",",urldecode($value['tag']));
//echo $value['subject'];
     //   echo urldecode($selection);
            array_push($matpel_array, $value['subject']);
            $matpellist = $matpellist . ',';
        $selectionarray =[];
        foreach ($selections as $key => $value1) {
            if (($value1 != null) && !empty($value1))
                array_push($selectionarray, ',' . $value1 . ',');

        }

                $catalog_ids = CatalogGeneral::find()->andWhere(['like', 'tag', $selectionarray])->asArray()->All();
                $catalog_array = ArrayHelper::getColumn($catalog_ids, 'id');

                             $catalog_uris = TaoUriMap::find()->andWhere(['like','id',$catalog_array])->andWhere(['type' => 'delivery'])->asArray()->All();
                $yourscore = 0;
$uri_array = ArrayHelper::getColumn($catalog_uris, 'id');

//$scores = AssessmentResult::find()->andWhere(['like', 'delivery_id', $uri_array])->asArray()->All();
$rows = (new \yii\db\Query())
    ->select(['MAX(id)'])
    ->from('assessment_result')
    //->where(['last_name' => 'Smith'])
    ->groupBy(['testtaker_id','delivery_id'])
    //->limit(10)
    ->all();
$rows2 = ArrayHelper::getColumn($rows, 'MAX(id)');

$query = AssessmentResult::find();
$query->andWhere(['like', 'delivery_id', $uri_array]);
$query->andWhere(['in', 'id', $rows2]);
$query->orderBy('score_double DESC');
$arr = $query->asArray()->all();
$resarr = ArrayHelper::getColumn($arr, 'testtaker_id');










           $user_uri = TaoUriMap::find()->andWhere(['id'=>Yii::$app->user->id])->andWhere(['type' => 'user'])->One();
$query2 = AssessmentResult::find();
$query2->andWhere(['like', 'delivery_id', $uri_array]);
$query2->andWhere(['testtaker_id' => $user_uri->uri]);
$query2->andWhere(['in', 'id', $rows2]);

$yourscore = $query2->sum('score_double');
$numberofyourscores = $query2->count('score_double');

$totalscore = $query->sum('score_double');
$numberofscores = $query->count('score_double');
$avg = ((int) $numberofscores > 0 )? ($totalscore/$numberofscores) : 0;
$youravg = ((int) $numberofyourscores > 0 )? ($yourscore/$numberofyourscores) : 0;
$myavg_list = $myavg_list . ',' .$youravg * 100;
$useravg_list = $useravg_list . ',' .$avg * 100;
$ranking = array_search($user_uri->uri, $resarr);
$myranking_list = $myranking_list . ',' .$ranking + 1;


echo '<pre>';
print_r($resarr);
echo 'hasil : ' . array_search('http://localhost:8090/gamantha/tao/pao.rdf#i1480592114445946', $resarr);

echo '<br/>======================<br/>';

echo $value['subject'] . '<br/>';
echo 'total score = ' . $totalscore;
echo '<br/>';
echo '# = ' . gettype($numberofscores);
echo '<br/>';
echo 'AVG = ' . $avg;
echo '<br/>Your score = ' . $youravg;
echo '<br/>Top Score = ' . $query->max('score_double');
echo '<br/>Your Ranking = ' . ($ranking + 1);
echo '<br/><br/>';
  
}

//echo '<br/>';
echo $myavgs =  substr($myavg_list, 1);
echo $useravgs = substr($useravg_list, 1);
$myrankings = substr($myranking_list, 1);
//echo '<br/>';
//echo $useravgs;



?>
<hr/>
<h1>Statistics</h1>
<div class="col-lg-6">
<canvas id="myChart" width="300" weight="300"></canvas>
</div>
<script>
var ctx = document.getElementById("myChart");
var myChart = new Chart(ctx, {
    type: 'radar',
    data: {
        labels: ["matematika", "fisika", "kimia", "biologi","bahasa inggris", "bahasa indonesia"],
        datasets: [{
            label: 'Your score',
            data: [<?=$myavgs?>],
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
        },
{
            label: 'Users Average',
         data: [<?=$useravgs?>],
            backgroundColor: [
                'rgba(200, 99, 132, 0.2)',
                'rgba(54, 122, 235, 0.2)',
                'rgba(150, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(205, 109, 164, 0.2)'
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
        },

        ]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>
