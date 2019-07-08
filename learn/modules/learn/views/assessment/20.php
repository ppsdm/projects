<?php
use yii\helpers\Html;
use yii\helpers\Url;

$final_correct = 0;
$final_incorrect = 0;
$final_unanswered = 0;


$score_array = [];

echo '<h1>Result</h1>';

echo '<hr/>';

                echo Html::a(Yii::t('app','Back'), ['/edulab/edulab/index'
],['class' => 'btn btn-info']);


echo '<hr/>';
$index = 0;

        foreach ($data as $key => $value) {
         //   echo $key; 
           // echo ' : ' . $value->label;
                //echo '<br/>';
                if(isset($value->sortedVars->taoResultServer_models_classes_OutcomeVariable->SCORE[0]->var->value)) {
              //  echo(base64_decode($value->sortedVars->taoResultServer_models_classes_OutcomeVariable->SCORE[0]->var->value));
            } else {
                //echo ' -------    no ScCORE';
            }
if(isset($value->sortedVars->taoResultServer_models_classes_ResponseVariable)) {
            $responses = $value->sortedVars->taoResultServer_models_classes_ResponseVariable;
            

            if(sizeof($responses) > 0) {
                $correct = 0;
                $incorrect = 0;
                $unanswered = 0;
                    foreach ($responses as $responses_key => $responses_value) {
                        # code...
                      //  echo '<br/>';
                      //  echo $responses_value[0]->isCorrect;
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
                    	$score_array[$index]['correct'] = $correct;
                    	$score_array[$index]['incorrect'] = $incorrect;
						$score_array[$index]['unanswered'] = $unanswered;
						$index++;


                    //     echo '<br/>' . $correct . ' : ' .  $incorrect . ' : ' . $unanswered;
                         $final_correct = $final_correct + $correct;
                         $final_unanswered = $final_unanswered + $unanswered;
                         $final_incorrect = $final_incorrect + $incorrect;
            }
            
        }
      //      echo '<br/><br/>';
            # code...
            $t = $value;
        }

  //      echo '<br/>correct = ' . $final_correct;
    //    echo '<br/>incorrect = ' . $final_incorrect;
//echo '<br/>unanswered = ' . $final_unanswered;



//print_r($score_array);
$this->title = 'Hasil Try Out';
$this->params['breadcrumbs'][] = $this->title;

$ranking = "87/636";


$tpa_betul = $score_array[10]['correct'] + $score_array[11]['correct'] + $score_array[12]['correct'];
$tpa_salah = $score_array[10]['incorrect'] + $score_array[11]['incorrect'] + $score_array[12]['incorrect'];
$tpa_kosong = $score_array[10]['unanswered'] + $score_array[11]['unanswered'] + $score_array[12]['unanswered'];

$bind_betul = $score_array[8]['correct'];
$bind_salah = $score_array[8]['incorrect'];
$bind_kosong = $score_array[8]['unanswered'];


$bing_betul = $score_array[9]['correct'];
//$bing_betul = 2;
$bing_salah = $score_array[9]['incorrect'];
$bing_kosong = $score_array[9]['unanswered'];


$biologi_betul = $score_array[5]['correct'] + $score_array[6]['correct'];
$biologi_salah = $score_array[5]['incorrect'] + $score_array[6]['incorrect'];
$biologi_kosong = $score_array[5]['unanswered'] + $score_array[6]['unanswered'];


$kimia_betul = $score_array[3]['correct'] + $score_array[4]['correct'];
$kimia_salah = $score_array[3]['incorrect'] + $score_array[4]['incorrect'];
$kimia_kosong = $score_array[3]['unanswered'] + $score_array[4]['unanswered'];

$fisika_betul = $score_array[1]['correct'] + $score_array[2]['correct'];
$fisika_salah = $score_array[1]['incorrect'] + $score_array[2]['incorrect'];
$fisika_kosong = $score_array[1]['unanswered'] + $score_array[2]['unanswered'];




$mtk_betul = $score_array[7]['correct'];
$mtk_salah = $score_array[7]['incorrect'];
$mtk_kosong = $score_array[7]['unanswered'];




$ekonomi_betul = $score_array[0]['correct'];
$ekonomi_salah = $score_array[0]['incorrect'];
$ekonomi_kosong = $score_array[0]['unanswered'];

$ratarata = 0;

?>
<div class="row table-responsive text-center" style="max-width:520px;">				
      <div class="col-md-12">
      	  <div class="content-panel">
      	  	  <h4 class="bg-primary"><i class="fa fa-angle-right"></i> TO 1 (<?=Yii::$app->formatter->asDatetime(date('Y-d-m')); ?>)</h4>
      	  	  <hr>
            
					<table  class="table text-center">
					  <tr>
					    <th colspan="5">HASIL TRY OUT I (10 SEPTEMBER 2016)</th>
					  </tr>
					  <tr>
					    <td rowspan="2">MATA PELAJARAN</td>
					    <td colspan="3">JUMLAH</td>
					    <td>TOTAL</td>
					  </tr>
					  <tr>
					    <td>BETUL</td>
					    <td>SALAH</td>
					    <td>KOSONG</td>
					    <td>PROSENTASE</td>
					  </tr>
					  <tr>
					    <td>RANKING</td>
					    <td colspan="4"></td>
					  </tr>
					  <tr>
					    <td>TPA</td>
					    <td><?=$tpa_betul;?></td>
					    <td><?=$tpa_salah;?></td>
					    <td><?=$tpa_kosong;?></td>
					    <td><?= round($tpa_betul / ($tpa_betul + $tpa_salah + $tpa_kosong) * 100)  . '%';?></td>
					  </tr>
					  <tr>
					    <td>MATEMATIKA</td>
					    <td><?=$mtk_betul;?></td>
					    <td><?=$mtk_salah;?></td>
					    <td><?=$mtk_kosong;?></td>
					    <td><?= round($mtk_betul / ($mtk_betul + $mtk_salah + $mtk_kosong) * 100)  . '%';?></td>
					  </tr>
					  <tr>
					    <td>B INDONESIA</td>
					    <td><?=$bind_betul;?></td>
					    <td><?=$bind_salah;?></td>
					    <td><?=$bind_kosong;?></td>
					    <td><?= round($bind_betul / ($bind_betul + $bind_salah + $bind_kosong) * 100)  . '%';?></td>
					  </tr>
					  <tr>
					    <td>B INGGRIS</td>
					    <td><?=$bing_betul;?></td>
					    <td><?=$bing_salah;?></td>
					    <td><?=$bing_kosong;?></td>
					    <td><?= round($bing_betul / ($bing_betul + $bing_salah + $bing_kosong) * 100)  . '%';?></td>
					  </tr>
					  <tr>
					    <td>FISIKA</td>
					    <td><?=$fisika_betul;?></td>
					    <td><?=$fisika_salah;?></td>
					    <td><?=$fisika_kosong;?></td>
					    <td><?= round($fisika_betul / ($fisika_betul + $fisika_salah + $fisika_kosong) * 100)  . '%';?></td>
					  </tr>
					  <tr>
					    <td>KIMIA</td>
					    <td><?=$kimia_betul;?></td>
					    <td><?=$kimia_salah;?></td>
					    <td><?=$kimia_kosong;?></td>
					    <td><?= round($kimia_betul / ($kimia_betul + $kimia_salah + $kimia_kosong) * 100)  . '%';?></td>
					  </tr>
					  <tr>
					    <td>BIOLOGI</td>
					    <td><?=$biologi_betul;?></td>
					    <td><?=$biologi_salah;?></td>
					    <td><?=$biologi_kosong;?></td>
					    <td><?= round($biologi_betul / ($biologi_betul + $biologi_salah + $biologi_kosong) * 100)  . '%';?></td>
					  </tr>
					  <tr>
					    <td>MATEMATIKA IPA</td>
					    <td><?=$ekonomi_betul;?></td>
					    <td><?=$ekonomi_salah;?></td>
					    <td><?=$ekonomi_kosong;?></td>
					    <td><?= round($ekonomi_betul / ($ekonomi_betul + $ekonomi_salah + $ekonomi_kosong) * 100)  . '%';?></td>
					  </tr>
					  <tr>
					    <td colspan="4">RATA-RATA,SISWA EDULAB INDONESIA</td>
					    <td><?=$ratarata;?></td>
					  </tr>
					</table>

<hr>

					<table class="table text-center">
					  <tr>
					    <th></th>
					    <th>PTN</th>
					    <th>PG</th>
					    <th>Jurusan</th>
					  </tr>
					  <tr>
					    <td>Pilihan 1</td>
					    <td>-</td>
					    <td>-</td>
					    <td>-</td>
					  </tr>
					  <tr>
					    <td>Pilihan 2</td>
					    <td>-</td>
					    <td>-</td>
					    <td>-</td>
					  </tr>
					  <tr>
					    <td>Pilihan 3</td>
					    <td>-</td>
					    <td>-</td>
					    <td>-</td>
					  </tr>
					  <tr>
					    <td>Keterangan</td>
					    <td colspan="3"></td>
					  </tr>
					</table>
      	  </div><! --/content-panel -->
      </div><!-- /col-md-12 -->
  
</div><!-- /row -->

