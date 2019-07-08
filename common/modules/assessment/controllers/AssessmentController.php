<?php

namespace common\modules\assessment\controllers;


use common\modules\assessment\models\Assessment;
use common\modules\assessment\models\AssessmentResult;
use common\modules\tao\models\TaoUriMap;
use common\modules\tao\models\ResultsStorage;
use common\modules\tao\models\Statements;

use yii\base\ErrorException;
use yii\web\NotFoundHttpException;


use yii\helpers\Html;
use yii\helpers\Url;
use yii\db\Expression;
use common\modules\catalog\models\CatalogGeneral;
use common\modules\catalog\models\CatalogPrice;
use common\modules\profile\models\UserCredit;
use common\modules\profile\models\UserTransaction;

use yii;

class AssessmentController extends \yii\web\Controller
{

    // FLOW : register -> start -> finish -> result
    //
    //
    //
    //
    public function actionIndex()
    {
        return $this->render('index');
    }

    //id = catalog
    public function actionStart($catalog_id)
    {	


    return $this->render('start', ['catalog_id' => $catalog_id]);
    }


    public function actionFinish($id)
    {
        //1. change assessment status to 'finished'
        //2. remove from group
        //3. fill result url with name of catalog + id



        $pao_assessment = Assessment::find()->andWhere(['user_id' => Yii::$app->user->id])->andWhere(['catalog_id' => $id])
        ->andWhere(['status' => 'active'])
        ->One();

        $pao_assessment->status = 'finished';
        $pao_assessment->result_url = $id . '.php';
        $pao_assessment->save();
        $get_result = Yii::$app->runAction('tao/removefromgroup', ['userid' => Yii::$app->user->id, 'groupid' => $id]);


    


    }
    public function getTaoresult($id)
    {
        //$id catalog
        $delivery = TaoUriMap::find()->andWhere(['id' => $id])->andWhere(['type' =>'delivery'])->One();
        $user = TaoUriMap::find()->andWhere(['id' => Yii::$app->user->id])->andWhere(['type' =>'user'])->One();
        $results = ResultsStorage::find()->andWhere(['test_taker' => $user->uri])->andWhere(['delivery' => $delivery->uri])->All();

return $results;

  
    }


    public function actionResult($catalog_id)
    {
        if($catalog_id !== '') {
            $current_assessment = Assessment::find()->
                                andWhere(['status' => 'finished'])->
                                andWhere(['catalog_id' => $catalog_id])->andWhere(['user_id' => Yii::$app->user->id])->One();
        $results = $this->getTaoresult($catalog_id);


                        echo $this->render('result', ['catalog_id' => $catalog_id, 
                            'current_assessment' => $current_assessment,
                            'results' => $results]);

    } else {
throw new NotFoundHttpException();
    }

    }

    public function actionResulthistory($catalog_id)
    {
        if($catalog_id !== '') {
            $current_assessment = Assessment::find()->
                                andWhere(['status' => 'finished'])->
                                andWhere(['catalog_id' => $catalog_id])->andWhere(['user_id' => Yii::$app->user->id])->One();
        $results = $this->getTaoresult($catalog_id);


                        echo $this->render('resulthistory', ['catalog_id' => $catalog_id, 
                            'current_assessment' => $current_assessment,
                            'results' => $results]);

    } else {
throw new NotFoundHttpException();
    }

    }

    public function actionViewresult($catalog_id, $result_id)
    {

                        $get_result = Yii::$app->runAction('tao/getresult', ['result' => $result_id]);
                        $json_data = json_decode($get_result);
                        $data = $json_data->data;

$im1=Yii::getAlias('@app').'/modules/edulab/views/assessment/'.$catalog_id.'.php';
//$im1 = Yii::getAlias('@app').'/index.php';
//                        $im1 = realpath(__FILE__);
if (file_exists($im1)) {
      echo $this->render($catalog_id, ['catalog_id' => $catalog_id,'result_id' => $result_id, 'data' => $data]);
      echo Html::a(Yii::t('app','Rankings'), ['takers', 'catalog_id'=>$catalog_id],['class' => '']);      
      echo '<br/>';
      echo Html::a(Yii::t('app','Result History'), ['resulthistory', 'catalog_id'=>$catalog_id],['class' => '']);
} else {
    echo $catalog_id. ' doesnt exists';
}




    }

    public function actionViewrawresult($catalog_id, $result_id)
    {

                        $get_result = Yii::$app->runAction('tao/getresult', ['result' => $result_id]);
                        $json_data = json_decode($get_result);
                        $data = $json_data->data;

      echo $this->render('rawresult', ['catalog_id' => $catalog_id,'result_id' => $result_id, 'data' => $data]);
                        //echo '<pre>';
                        //print_r($data);


    }


    //if = catalog
    public function actiongetResult($id)
    {

$assessment = Assessment::find()->andWhere(['catalog_id' => $id])->andWhere(['user_id' => Yii::$app->user->id])->andWhere(['status' => 'active'])->One();
    	if (null !== $assessment) {
    		$user = TaoUriMap::find()->andWhere(['id' => Yii::$app->user->id])->andWhere(['type' => 'user'])->One();
    		$group = TaoUriMap::find()->andWhere(['id' => $id])->andWhere(['type' => 'group'])->One();
    		$delivery = TaoUriMap::find()->andWhere(['id' => $id])->andWhere(['type' => 'delivery'])->One();

$results = AssessmentResult::find()->andWhere(['testtaker_id' => $user->uri])
->andWhere(['delivery_id' => $delivery->uri])->All();

if (sizeof($results) > 0) {
foreach ($results as $key => $value) {
	# code...
	$result = $value;
}

    echo 'size of  : ' .  sizeof($results);
    echo '<br/> result : ' . $result->result_id;

    $json_result = json_decode($result->result_json);
        $data = $json_result->data;
        foreach ($data as $key => $value) {
            echo $key; 
            echo ' : ' . $value->label;
                echo '<br/>';
                if(isset($value->sortedVars->taoResultServer_models_classes_OutcomeVariable->SCORE[0]->var->value)) {
                echo(base64_decode($value->sortedVars->taoResultServer_models_classes_OutcomeVariable->SCORE[0]->var->value));
            } else {
                echo 'no ScCORE';
            }
if(isset($value->sortedVars->taoResultServer_models_classes_ResponseVariable)) {
            $responses = $value->sortedVars->taoResultServer_models_classes_ResponseVariable;
            

            if(sizeof($responses) > 0) {
                $correct = 0;
                $incorrect = 0;
                $unanswered = 0;
                    foreach ($responses as $responses_key => $responses_value) {
                        # code...
                        echo '<br/>';
                        echo $responses_value[0]->isCorrect;
                        if ($responses_value[0]->isCorrect == 'incorrect') {
                            if($responses_value[0]->var->candidateResponse =='')
                            {
                                    $unanswered++;
                            } else {
                                    $incorrect++;
                            }
                        } else if ($responses_value[0]->isCorrect == 'correct') {
                            $correct++;
                        }


                    }
                         echo '<br/>' . $correct . ' : ' .  $incorrect . ' : ' . $unanswered;
            }
            
        }
            echo '<br/><br/>';
            # code...
            $t = $value;
        }


} else {
echo 'test not finished';

}



    	

    } else {
    	echo 'register first';
    }
    }

    //$id = catalog


    public function actionInfo($catalog_id)
    {
        $model = CatalogGeneral::findOne($catalog_id);
    	return $this->render('info',['model' => $model]);
    }


}
