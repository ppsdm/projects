<?php
/* @var $this yii\web\View */


use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Organization;
use app\models\Requirement;
use yii\data\ActiveDataProvider;
use common\modules\catalog\models\CatalogGeneral;
use common\modules\catalog\models\CatalogPrice;
use common\modules\catalog\models\CatalogGeneralQuery;
use common\modules\assessment\models\Assessment;
use common\modules\assessment\models\AssessmentSearch;
use common\modules\tao\models\TaoUriMapQuery;
use common\modules\tao\models\TaoUriMap;
use yii\grid\GridView;

use yii\data\ArrayDataProvider;

use yii\db\Expression;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;


?>

<?php



$taouser = TaoUriMap::find()->andWhere(['type' => 'user'])->andWhere(['id'=>Yii::$app->user->id])->One();
              $taouseruri = '';
              if (!is_null($taouser))
                  $taouseruri = urlencode($taouser->uri);
    $urlstring = Yii::$app->params['TAO_ROOT']."taoDelivery/PaodeliveryServer/resumablejson?user=" . $taouseruri;
        $urlstring2 = Yii::$app->params['TAO_ROOT']."taoDelivery/PaodeliveryServer/availablejson?user=" . $taouseruri;
//echo $urlstring2;            

                            $ch = curl_init($urlstring);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $resumablejson = curl_exec($ch);

                            $ch2 = curl_init($urlstring2);
                                            curl_setopt($ch2, CURLOPT_HEADER, 0);
                 curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
                                   $availablejson = curl_exec($ch2);
                curl_close($ch);
                      curl_close($ch2);

                $resumable =  json_decode($resumablejson);
                        $available =  json_decode($availablejson);

                            
                        $available_array = [];
                        if (sizeof($available) > 0) {
                foreach ($available as $key => $value) {
        
                    $available_array[$value->id] = str_replace("DeliveryServer","PaodeliveryServer",$value->launchUrl);
                }
              }

                           
                        
                $resumable_array = [];
                      if (sizeof($resumable) > 0) {
                foreach ($resumable as $key => $value) {
                  //  echo $value->id;
                    //$de = $value->delivery->uriResource;
                    $resumable_array[$value->delivery->uriResource] = str_replace("DeliveryServer","PaodeliveryServer",$value->launchUrl);
                //    echo '<br/>';
                }
              }

$takeable_array = [];

$query = Assessment::find()->where(['user_id' => Yii::$app->user->id]);


        $searchModel = new AssessmentSearch();
        $params = Yii::$app->request->queryParams;
        $params['AssessmentSearch']['user_id'] = Yii::$app->user->id;

        $dataProvider = $searchModel->search($params);

  


$dataProvider->setSort([
    'attributes' => [

        'timestamp' => [
            'asc' => ['timestamp' => SORT_ASC],
            'desc' => ['timestamp' => SORT_DESC],
            'default' => SORT_DESC,
            'label' => 'timestamp',
        ],
    ],
    'defaultOrder' => ['timestamp' => SORT_DESC],
    'params' => [
    //'datetime' => SORT_DESC,
    ],
]);

$assessments = $dataProvider->getModels();



                foreach ($assessments as $key => $value) {
              
                    $assessmentobject = TaoUriMap::find()->andWhere(['id'=>$value->catalog_id])->andWhere(['type'=>'delivery'])->asArray()->One();
                      //    echo $value->catalog_id . ' : ' . $assessmentobject['uri'];
                        //  echo ' => ';
                                 if (array_key_exists($assessmentobject['uri'], $available_array))
                                 {
                                  //  echo ' available ';
                                    $assessmentobject['initurl'] = $available_array[$assessmentobject['uri']];
                                 } else {
                                  $assessmentobject['initurl'] = '';
                                 }
                                 if (array_key_exists($assessmentobject['uri'], $resumable_array))
                                 {
                                   // echo ' resumable ';
                                    $assessmentobject['resumeurl'] = $resumable_array[$assessmentobject['uri']];
                                 } else {
                                  $assessmentobject['resumeurl'] = '';
                                 }
                                 $assessmentobject['assessment_id'] = $value->id;
                                 $assessmentobject['status'] = $value->status;
                                 $assessmentobject['timestamp'] = $value->timestamp;
                                 array_push($takeable_array, $assessmentobject);

                }

$dataProvider = new ArrayDataProvider([
    'allModels' => $takeable_array,
    'pagination' => [
        //'pageSize' => 10,
    ],
    'sort' => [
      //  'attributes' => ['id', 'type','uri','initurl','resumeurl','assessment_id'],
    ],
]);


/*
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        //['class' => 'yii\grid\SerialColumn'],
        'id',
        ['label' => 'test',
        'value' => function($data) {
            return 'saaaaa';
        }
        ]
        ]

        ]);

*/

echo '<h2>Take new assessment</h2>';

$return = Yii::$app->params['TAO_DELIVERY_FINISHURL'] . '?id='. $_GET['id'];


foreach ($available as $available_key => $available_value) {
    # code...


echo Html::a(Yii::t('app', 'Start ' . $available_value->label), ['/tao/loginredirect?redirect='.


  urlencode( str_replace("DeliveryServer","PaodeliveryServer",$available_value->launchUrl))
. '&return=' . urlencode($return)
  ],['class' => 'btn btn-success']);
      echo '<br/>';  
}

echo '<h2>Resume</h2>';
foreach ($resumable as $resumeable_key => $resumeable_value) {
    # code...


echo Html::a(Yii::t('app',$resumeable_value->id), ['/tao/loginredirect?redirect='.urlencode(
 str_replace("DeliveryServer","PaodeliveryServer",$resumeable_value->launchUrl)) 
. '&return=' . urlencode($return)
],['class' => 'btn btn-info']);
      echo ' ' . $resumeable_value->description[0];
       echo '<br/>'; 
}


/*
echo '<pre>';
echo 'RESUMABLE<br/>';
print_r($resumable);
echo '<br/>Available<br/>';
print_r($available);
echo '<br/>';
echo $urlstring;
echo '<br/>';
echo $urlstring2;
echo '<br/>';
*/


//


?>
