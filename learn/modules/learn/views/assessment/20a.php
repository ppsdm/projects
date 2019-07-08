<?php
use yii\helpers\Html;
use yii\helpers\Url;

$final_correct = 0;
$final_incorrect = 0;
$final_unanswered = 0;





echo '<h1>Result</h1>';

echo '<hr/>';

                echo Html::a(Yii::t('app','Back'), ['/edulab/edulab/index'
],['class' => 'btn btn-info']);


echo '<hr/>';


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
                         $final_correct = $final_correct + $correct;
                         $final_unanswered = $final_unanswered + $unanswered;
                         $final_incorrect = $final_incorrect + $incorrect;
            }
            
        }
            echo '<br/><br/>';
            # code...
            $t = $value;
        }

        echo '<br/>correct = ' . $final_correct;
        echo '<br/>incorrect = ' . $final_incorrect;
echo '<br/>unanswered = ' . $final_unanswered;


?>