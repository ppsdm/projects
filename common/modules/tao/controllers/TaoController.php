<?php

namespace common\modules\tao\controllers;

use common\modules\tao\models\TaoUriMap;
use common\modules\tao\models\Statements;
use frontend\modules\catalog\models\CatalogGeneral;
use common\models\User;
use Yii;
use common\models\Log;
use yii\db\Expression;

use common\models\RefConfig;
use common\modules\assessment\models\Assessment;
use common\modules\assessment\models\AssessmentResult;


class TaoController extends \yii\web\Controller
{
    public function actionIndex()
    {
        //return $this->render('index');
        echo 'sasa';
    }


    public function actionTestadd()
    {
    	$process = curl_init("http://foo/taoSubjects/RestSubjects");
curl_setopt($process, CURLOPT_HTTPGET, 1);
curl_setopt($process,CURLOPT_HTTPHEADER, array(
"Accept: application/json",
"uri: http://tao-dev/taodev.rdf#i1372425843494221" 
));
curl_setopt($process, CURLOPT_USERPWD, "myLogin:myPassword");
curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);

$returnedData = curl_exec($process);
$httpCode = curl_getinfo($process, CURLINFO_HTTP_CODE);
$data = json_decode($returnedData, true);
curl_close($process);

    }
    public function actionInfo()
    {

    	  echo Yii::$app->params['TAO_ROOT'];
    	  return 'info return';
    }

public function actionTest()
{
	return Yii::$app->params['TAO_ROOT'] . Yii::$app->params['TESTTAKER_ROOT'];
}

public function actionGetresult($result)
{
$urlstring = Yii::$app->params['TAO_ROOT']."taoDelivery/PaodeliveryServer/viewResult?deliveryExecution=".urlencode($result);;
//echo $urlstring;//
			$ch = curl_init($urlstring);
curl_setopt($ch, CURLOPT_HEADER, 0);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);

return $result;
//return $urlstring;

	    //  'http://localhost:8090/gamantha/oat/
}
    public function actionAdduser($userid, $password, $type)
    {
	
$user = User::findOne($userid);
$type = Yii::$app->params['TAO_ROOT'] . Yii::$app->params['TESTTAKER_ROOT'];
//$urlstring = Yii::$app->params['TAO_ROOT']."tao/Users/paoadduser?login=".$user->username."&email=".$user->email."&password=" . $password . "&type=" . urlencode($type);
$urlstring = Yii::$app->params['TAO_ROOT']."tao/Pao/paoadduser?login=".urlencode($user->username)."&email=".urlencode($user->email)."&password=" . urlencode($password) . "&type=" . urlencode($type);
echo $urlstring;
			$ch = curl_init($urlstring);
curl_setopt($ch, CURLOPT_HEADER, 0);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$useruri = curl_exec($ch);
curl_close($ch);

$newuser = new TaoUriMap();
$newuser->id = $userid;
$newuser->type='user';
$newuser->uri = $useruri;
if ($newuser->save())
{
	return $useruri;
} else {
	return false;
}





    }

public function actionTaologout(){
//Yii::$app->params['TAO_ROOT'] . "taoDelivery/DeliveryServer/initDeliveryExecution?uri=
				$urlstring = Yii::$app->params['TAO_ROOT']."taoDelivery/PaodeliveryServer/paologout";
			
							$ch = curl_init($urlstring);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$useruri = curl_exec($ch);
				curl_close($ch);


}

public function actionPaotest($uri){

    $urlstring = Yii::$app->params['TAO_ROOT']."tao/Pao/paotest?uri=" . urlencode($uri);
			
							$ch = curl_init($urlstring);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				//$result = curl_exec($ch);
				curl_close($ch);

				$this->redirect($urlstring);


}



public function actionLoginredirect($redirect,$return)
{

	    $urlstring = Yii::$app->params['TAO_ROOT']."tao/Pao/paologinredirect?redirect=" . urlencode($redirect) . '&return='.urlencode($return);
			$this->redirect($urlstring);

				

}


public function actionLogintao()
{

	    $urlstring = Yii::$app->params['TAO_ROOT']."tao/Pao/paologin";
		//echo $urlstring;
		echo Yii::$app->request->referrer;
			


}


    public function actionLogininitdeliveryredirect($redirect,$return ,$catalog_id){


				$user = TaoUriMap::find()->andWhere(['type' => 'user'])
				->andWhere(['id' => Yii::$app->user->id])
				->One();

				$delivery = TaoUriMap::find()->andWhere(['type' => 'delivery'])
				->andWhere(['id' => $catalog_id])
				->One();



    	$assessment = Assessment::find()->andWhere(['user_id' => Yii::$app->user->id])->andWhere(['catalog_id' => $catalog_id])->andWhere(['status' => 'active'])->One();
    		$assessment_result = new AssessmentResult();
    		$assessment_result->assessment_id = $assessment->id;
    		$assessment_result->testtaker_id = $user->uri;
    		$assessment_result->delivery_id = $delivery->uri;
    		$assessment_result->timestamp = new Expression('NOW()');
    		$assessment_result->save();
	    $urlstring = Yii::$app->params['TAO_ROOT']."tao/Pao/paologinredirect?redirect=" . urlencode($redirect) . '&return='.urlencode($return);
			$this->redirect($urlstring);


   
    }



    public function actionTaoredirect(){

				$user = TaoUriMap::find()->andWhere(['type' => 'user'])
				->andWhere(['id' => Yii::$app->user->id])
				->One();
			
			/*	if ($_REQUEST['redirect']){
					$redirect = $_REQUEST['redirect'];
				} else{
					$redirect ='';
				}
				*/
$useruri = urlencode($user->uri);
    $urlstring = Yii::$app->params['TAO_ROOT']."tao/Pao/loginfrompao?user=" . $useruri;
			
							$ch = curl_init($urlstring);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				//$result = curl_exec($ch);
				curl_close($ch);

				echo $urlstring;

   
    }

    public function actionAddtogroup($userid, $groupid)
    {

    	//$catitem = CatalogGeneral::find()->andWhere(['name' => $groupname])->One();


				$user = TaoUriMap::find()->andWhere(['type' => 'user'])
				->andWhere(['id' => $userid])
				->One();


				$group = TaoUriMap::find()->andWhere(['type' => 'group'])
				->andWhere(['id' => $groupid])
				->One();

				if(isset($user->uri) && isset($group->uri)) {
								$useruri = urlencode($user->uri);
								$groupuri = urlencode($group->uri);
				$urlstring = Yii::$app->params['TAO_ROOT']."tao/Pao/paoaddtogroup?useruri=".$useruri."&groupuri=" . $groupuri;
			
							$ch = curl_init($urlstring);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$useruri = curl_exec($ch);
				curl_close($ch);

return $urlstring;
				//return $groupid;
			} else {
					return false;
			}
    }

    public function actionScantest()
    {
    	echo '1 level only<br/><br/><br/>';
    	$top_groups = Statements::find()->andWhere(['object' => 'http://www.tao.lu/Ontologies/TAOGroup.rdf#Group'])
    	->andWhere(['predicate' => 'http://www.w3.org/2000/01/rdf-schema#subClassOf'])->All();
    	echo 'GROUPS <br/>';
    	foreach ($top_groups as $top_group_key => $top_group_value) {
    		$group_object = Statements::find()->andWhere(['subject' => $top_group_value->subject])
    	->andWhere(['predicate' => 'http://www.w3.org/2000/01/rdf-schema#label'])->One();
    		echo $group_object->object . ' => ' . $top_group_value->subject;
    		echo '<br/>';
    		    	$groups = Statements::find()->andWhere(['object' => $top_group_value->subject])
    	->andWhere(['predicate' => 'http://www.w3.org/1999/02/22-rdf-syntax-ns#type'])->All();
    			foreach ($groups as $group_key => $group_value) {
    				    		$subgroup_object = Statements::find()->andWhere(['subject' => $group_value->subject])
    								->andWhere(['predicate' => 'http://www.w3.org/2000/01/rdf-schema#label'])->One();
    		echo '  --- ' . $subgroup_object->object . ' => ' . $group_value->subject;
    		echo '<br/>';

    			}
    	}


    	echo '<br/><br/><br/>DELIVERIES<br/>'	;

    	$deliveries = Statements::find()->andWhere(['object' => 'http://www.tao.lu/Ontologies/TAODelivery.rdf#AssembledDelivery'])
    	->andWhere(['predicate' => 'http://www.w3.org/2000/01/rdf-schema#subClassOf'])->All();;
    	foreach ($deliveries as $deliveries_key => $deliveries_value) {
    		$delivery_object = Statements::find()->andWhere(['subject' => $deliveries_value->subject])
    	->andWhere(['predicate' => 'http://www.w3.org/2000/01/rdf-schema#label'])->One();
    		echo $delivery_object->object . ' => ' . $deliveries_value->subject;
    		echo '<br/>';
    		    	$deliveries2 = Statements::find()->andWhere(['object' => $deliveries_value->subject])
    	->andWhere(['predicate' => 'http://www.w3.org/1999/02/22-rdf-syntax-ns#type'])->All();
    			foreach ($deliveries2 as $deliveries2_key => $deliveries2_value) {
    				    		$subdelivery_object = Statements::find()->andWhere(['subject' => $deliveries2_value->subject])
    								->andWhere(['predicate' => 'http://www.w3.org/2000/01/rdf-schema#label'])->One();
    		echo '  --- ' . $subdelivery_object->object . ' => ' . $deliveries2_value->subject;
    		echo '<br/>';

    			}
    	}

    }

    public function actionRemovefromgroup($userid, $groupid)
    {

    	//$catitem = CatalogGeneral::find()->andWhere(['name' => $groupname])->One();


				$user = TaoUriMap::find()->andWhere(['type' => 'user'])
				->andWhere(['id' => $userid])
				->One();


				$group = TaoUriMap::find()->andWhere(['type' => 'group'])
				->andWhere(['id' => $groupid])
				->One();


								$useruri = urlencode($user->uri);
								$groupuri = urlencode($group->uri);
				$urlstring = Yii::$app->params['TAO_ROOT'] ."tao/Pao/paoremovefromgroup?useruri=".$useruri."&groupuri=" . $groupuri;
							$ch = curl_init($urlstring);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$useruri = curl_exec($ch);
				curl_close($ch);




    }

    public function actionChangepassword($userid, $password)
    {
				//$user = User::findOne($userid);
				$user = TaoUriMap::find()->andWhere(['type' => 'user'])
				->andWhere(['id' => $userid])
				->One();

				echo 'user uri : ' . $user->uri;
				echo '<br/>password : ' . $password;
				$useruri = urlencode($user->uri);
				$urlstring = Yii::$app->params['TAO_ROOT']."tao/Pao/paochangepassword?useruri=".$useruri."&password=" . $password;
							$ch = curl_init($urlstring);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$useruri = curl_exec($ch);
				curl_close($ch);
    }

                public function beforeAction($action) {

  Log::add(Yii::$app->controller->id, $action->id,'activity');
    if (Yii::$app->session->has('lang')) {
        Yii::$app->language = Yii::$app->session->get('lang');
    } else {
        //or you may want to set lang session, this is just a sample
        //Yii::$app->language = 'us';
    }
    return parent::beforeAction($action);
}

public function log($controller, $action)
{
  $log = new Log();
$log->user_id = Yii::$app->user->id;
$log->type = 'activity';
$log->controller = $controller;
$log->action = $action;
  $log->timestamp = new Expression('NOW()');
  $log->save();

}

}
