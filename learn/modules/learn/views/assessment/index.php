<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */
use yii\helpers\Html;

$this->title = 'Hasil Try Out';
$this->params['breadcrumbs'][] = $this->title;

$ranking = "87/636";
$tpa_betul = "10";
$tpa_salah = "5";
$tpa_kosong = "0";
$mtk_betul = "10";
$mtk_salah = "5";
$mtk_kosong = "0";
$bind_betul = "10";
$bind_salah = "5";
$bind_kosong = "0";
$bing_betul = "10";
$bing_salah = "5";
$bing_kosong = "0";
$fisika_betul = "10";
$fisika_salah = "5";
$fisika_kosong = "0";
$kimia_betul = "10";
$kimia_salah = "5";
$kimia_kosong = "0";
$biologi_betul = "10";
$biologi_salah = "5";
$biologi_kosong = "0";
$ekonomi_betul = "10";
$ekonomi_salah = "5";
$ekonomi_kosong = "0";

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
					    <td></td>
					  </tr>
					  <tr>
					    <td>MATEMATIKA</td>
					    <td><?=$mtk_betul;?></td>
					    <td><?=$mtk_salah;?></td>
					    <td><?=$mtk_kosong;?></td>
					    <td></td>
					  </tr>
					  <tr>
					    <td>B INDONESIA</td>
					    <td><?=$bind_betul;?></td>
					    <td><?=$bind_salah;?></td>
					    <td><?=$bind_kosong;?></td>
					    <td></td>
					  </tr>
					  <tr>
					    <td>B INGGRIS</td>
					    <td><?=$bing_betul;?></td>
					    <td><?=$bing_salah;?></td>
					    <td><?=$bing_kosong;?></td>
					    <td></td>
					  </tr>
					  <tr>
					    <td>FISIKA/SOSIOLOGI</td>
					    <td><?=$fisika_betul;?></td>
					    <td><?=$fisika_salah;?></td>
					    <td><?=$fisika_kosong;?></td>
					    <td></td>
					  </tr>
					  <tr>
					    <td>KIMIA/GEOGRAFI</td>
					    <td><?=$kimia_betul;?></td>
					    <td><?=$kimia_salah;?></td>
					    <td><?=$kimia_kosong;?></td>
					    <td></td>
					  </tr>
					  <tr>
					    <td>BIOLOGI/SEJARAH</td>
					    <td><?=$biologi_betul;?></td>
					    <td><?=$biologi_salah;?></td>
					    <td><?=$biologi_kosong;?></td>
					    <td></td>
					  </tr>
					  <tr>
					    <td>EKONOMI</td>
					    <td><?=$ekonomi_betul;?></td>
					    <td><?=$ekonomi_salah;?></td>
					    <td><?=$ekonomi_kosong;?></td>
					    <td></td>
					  </tr>
					  <tr>
					    <td colspan="4">RATA-RATA,SISWA EDULAB INDONESIA</td>
					    <td></td>
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