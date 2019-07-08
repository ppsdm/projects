<?php

namespace cats\controllers;

use common\modules\assessment\models\AssessmentResult;


class TaoController extends \common\modules\tao\controllers\TaoController {
    // empty class


    public function actionResult($id)
    {

    	echo 'result ' . $id;
    	$result = AssessmentResult::findOne($id);
    	echo '<pre>';
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
    	
    //	print_r($t->sortedVars->taoResultServer_models_classes_OutcomeVariable->SCORE[0]);
    

    }
}

?>