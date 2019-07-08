<?php

namespace common\modules\profile\controllers;
use common\modules\profile\models\ProfileExtended;
use common\modules\profile\models\UserCredit;
use common\modules\assessment\models\Assessment;
use common\models\Log;
use Yii;


use yii\db\Expression;
use yii\helpers\Url;


class SurveyController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCheckkuesioner()
    {

    	// 1. 1st login
    	// 2. 10 login
    	// 3. 3 tes


	$exist1 = ProfileExtended::find()->andWhere(['user_id' => Yii::$app->user->id])->andWhere(['type' => 'kuesioner'])->andWhere(['key' => '1'])->One();
		$exist2 = ProfileExtended::find()->andWhere(['user_id' => Yii::$app->user->id])->andWhere(['type' => 'kuesioner'])->andWhere(['key' => '2'])->One();
			$exist3 = ProfileExtended::find()->andWhere(['user_id' => Yii::$app->user->id])->andWhere(['type' => 'kuesioner'])->andWhere(['key' => '3'])->One();


				$logins = Log::find()->andWhere(['user_id' => Yii::$app->user->id])->andWhere(['type'=>'activity'])->andWhere(['controller' => 'Site'])->andWhere(['action' => 'Login2'])->All();
				$tests = Assessment::find()->andWhere(['user_id'=>Yii::$app->user->id])->All();
    	$case1 = is_null($exist1) ? true : false;
    	$case2 = (is_null($exist2) && (sizeof($logins) > 9))? true : false;
    	$case3 = (is_null($exist3) && (sizeof($tests) > 4))? true : false;

$retarray = [];
    	if ($case1) {
    		array_push($retarray, '1');
    	} 
    	if ($case2) {
    		array_push($retarray, '2');
    	} 
    	if ($case3) {
    		array_push($retarray, '3');
    	}

return json_encode($retarray);
    	//$kuesioners ProfileExtended::find()->andWhere(['user_id' => Yii::$app->user->id])->andWhere(['type' => 'kuesioner'])->andWhere(['key' => $id])->All();
    }

    public function actionKuesioner($id)
    {

    		$kuesioner = new ProfileExtended();
    if ($post = Yii::$app->request->post()) {


    			$exist = ProfileExtended::find()->andWhere(['user_id' => Yii::$app->user->id])->andWhere(['type' => 'kuesioner'])->andWhere(['key' => $id])->One();
    			if (is_null($exist)) {
    		$kuesioner->user_id = Yii::$app->user->id;
    		$kuesioner->type = 'kuesioner';
    		$kuesioner->key = $id;
    		//echo '<pre>';
    		$bonus = $post['bonus'];
    		unset($post['bonus']);
    //		print_r($post);
    		//echo '<br/>';
    		//echo $post['xxx1'];
    		$json = json_encode($post);
    		$kuesioner->value = $json;
    		$kuesioner->save();

    		$usercredit = UserCredit::find()->andWhere(['user_id' => Yii::$app->user->id])->andWhere(['credit_type' => 'credit'])->andWhere(['status' => 'active'])->One();
    		$usercredit->credit_point = $usercredit->credit_point + $bonus;
    		$usercredit->save();
    		                Yii::$app->session->setFlash('success', 'Thank you for filling the survey. Your bonus is added');
    	 } else {
    			   Yii::$app->session->setFlash('success', 'You have already taken this survey');
    		}
	$this->redirect(['/site/index']);
        } else {
        	            return $this->render($id, [
            'model' => $kuesioner,
        ]);

        }
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


}
