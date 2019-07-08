<?php
use common\modules\assessment\models\Assessment;
use common\modules\assessment\models\AssessmentResult;
use common\modules\tao\models\TaoUriMap;
use common\modules\tao\models\ResultsStorage;
use common\modules\tao\models\Statements;

use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this yii\web\View */
?>
<h1>Start assessment</h1>

<p>
Disini bisa melihat kalau mau continue assessment atau mulai lagi yg baru. Default semua assessment adalah resumeable
</p>

<?php


$assessment = Assessment::find()->andWhere(['catalog_id' => $id])->andWhere(['user_id' => Yii::$app->user->id])->andWhere(['status' => 'active'])->One();
    	if (null !== $assessment) {

    		$user = TaoUriMap::find()->andWhere(['id' => Yii::$app->user->id])->andWhere(['type' => 'user'])->One();
    		$group = TaoUriMap::find()->andWhere(['id' => $id])->andWhere(['type' => 'group'])->One();
    		$delivery = TaoUriMap::find()->andWhere(['id' => $id])->andWhere(['type' => 'delivery'])->One();
/*
    	echo 'user uri : ';
    	echo (isset($user->uri) ? $user->uri : ' no uri' );
    	    	echo '<br/>group uri : ';
    	    	echo  (isset($group->uri) ? $group->uri : ' no uri' );
    	echo '<br/>delivery uri : ';
    	echo (isset($delivery->uri) ? $delivery->uri : ' no uri');
    	echo '<br/>';
      */
//$launchUrl = 'http://localhost:8090/gamantha/oat/taoDelivery/DeliveryServer/initDeliveryExecution?uri=' . urlencode($delivery->uri);
$returnUrl = Url::to(['result', 'id' => $id],true);
//http://localhost:8090/gamantha/pao/edulab/web/index.php/edulab/assessment/getresult?id=20


  //http://localhost:8090/gamantha/oat/taoDelivery/DeliveryServer/initDeliveryExecution?uri=http%3A%2F%2Flocalhost%3A8090%2Fgamantha%2Foat%2Foat.rdf%23i14862157247742169




    $urlstring = Yii::$app->params['TAO_ROOT']."taoDelivery/PaodeliveryServer/resumablejson?user=" . urlencode($user->uri);
        $urlstring2 = Yii::$app->params['TAO_ROOT']."taoDelivery/PaodeliveryServer/availablejson?user=" . urlencode($user->uri);
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
//echo '<br/>============AVAILABLE==================<br/><br/>';


                        $available_array = [];
                        if (sizeof($available) > 0) {
                foreach ($available as $key => $value) {

                    $available_array[$value->id] = str_replace("DeliveryServer","PaodeliveryServer",$value->launchUrl);
               //           echo '<br/>'. $value->label . ' (' . $value->id . ') => ' ;
                          if($delivery->uri == $value->id) {
                /*echo Html::a(Yii::t('app','Start'), ['/tao/loginredirect?redirect='.urlencode(

$available_array[$value->id]
 ) 
. '&return=' . urlencode($returnUrl)
],['class' => 'btn btn-info']);
                */
                          }
                }
              }

                           
                    //echo '<br/>============RESUMEABLE==================<br/><br/>';    
                $resumable_array = [];
                      if (sizeof($resumable) > 0) {
                foreach ($resumable as $key => $value) {

                    $resumable_array[$value->delivery->uriResource] = str_replace("DeliveryServer","PaodeliveryServer",$value->launchUrl);
                    $last_resumeable = $resumable_array[$value->delivery->uriResource];

        //echo '<br/>'. $value->label . ' (' . $value->id . ') => ' ;
                }

             /*   echo Html::a(Yii::t('app','resume'), ['/tao/loginredirect?redirect='.urlencode(

                	$last_resumeable
 ) 
. '&return=' . urlencode($returnUrl)
],['class' => 'btn btn-info']);
*/

              }


//echo '<br/><br/><br/> Button yang paling penting : (resume yg terakhir kalau ada, atau start)';
          if (sizeof($resumable) > 0) {
                echo Html::a(Yii::t('app','resume'), ['/tao/loginredirect?redirect='.urlencode(
 //str_replace("DeliveryServer","PaodeliveryServer",$last_resumeable)
                  $last_resumeable
 ) 
. '&return=' . urlencode($returnUrl)
],['class' => 'btn btn-info']);
          } else {
                            echo Html::a(Yii::t('app','Start'), ['/tao/loginredirect?redirect='.urlencode(
 //str_replace("DeliveryServer","PaodeliveryServer",$value->launchUrl)
$available_array[$value->id]
 ) 
. '&return=' . urlencode($returnUrl)
],['class' => 'btn btn-info']);
          }




    } else {
    	echo 'register first';
    }


    ?>
