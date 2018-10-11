<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\redactor\widgets\Redactor as Redactor;
use yii\helpers\HtmlPurifier;
/* @var $this yii\web\View */
/* @var $model frontend\models\SetkabActivity */

$this->title = Yii::t('app', 'Kelemahan {modelClass}: ', [
    'modelClass' => 'Setkab Activity',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Setkab Activities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="setkab-activity-update">
    <h1>Kelemahan</h1>
</div>

<?php
    // GET value for kompetensi and potensi

    $PArk = 0;
    $PArk += $model->integritas_lki;
    $PArk += $model->kerjasama_lki;
    $PArk += $model->komunikasi_lki;
    $PArk += $model->orientasihasil_lki;
    $PArk += $model->pelayananpublik_lki;
    $PArk += $model->pengambilankeputusan_lki;
    $PArk += $model->pengelolaanperubahan_lki;
    $PArk += $model->pengembangandiri_lki;
    $PArk += $model->perekatbangsa_lki;

    $PArp = 0;
    $PArp += $model->psikogram_berpikiranalitis;
    $PArp += $model->psikogram_empati;
    $PArp += $model->psikogram_fleksibilitasberpikir;
    $PArp += $model->psikogram_inteligensiumum;
    $PArp += $model->psikogram_kemampuanbelajar;
    $PArp += $model->psikogram_ketekunan;
    $PArp += $model->psikogram_ketelitian;
    $PArp += $model->psikogram_komunikasiefektif;
    $PArp += $model->psikogram_konsepdiri;
    $PArp += $model->psikogram_logikaberpikir;
    $PArp += $model->psikogram_motivasi;
    $PArp += $model->psikogram_pemahamansosial;
    $PArp += $model->psikogram_pengaturandiri;
    $PArp += $model->psikogram_sistematikakerja;
    $PArp += $model->psikogram_tempokerja;

    $sumC = 0;
    $sumC += $lkjmodel->kompetensigram_integritas;
    $sumC += $lkjmodel->kompetensigram_kerjasama;
    $sumC += $lkjmodel->kompetensigram_komunikasi;
    $sumC += $lkjmodel->kompetensigram_orientasihasil;
    $sumC += $lkjmodel->kompetensigram_pelayananpublik;
    $sumC += $lkjmodel->kompetensigram_pengembangandiri;
    $sumC += $lkjmodel->kompetensigram_pengelolaanperubahan;
    $sumC += $lkjmodel->kompetensigram_pengambilankeputusan;
    $sumC += $lkjmodel->kompetensigram_perekatbangsa;
?>

<div class="setkab-activity-update">
    <div class="row">
        <div class="col-md-6">
            <h4>Diagram Kompetensi</h4>
            <div class="radarChart" style="background-image: url('<?=Url::base()?>/images/setkab/LINGKARAN.png'); background-repeat: no-repeat;background-size: 490px 510px; height: 550px;"></div>


            <script src="<?=Url::to('@web/js/radarChart.js');?>"></script>
            <script src="<?=Url::to('@web/js/d3.min.js');?>"></script>

            <script>
                /* Radar chart design created by Nadieh Bremer - VisualCinnamon.com */

                //////////////////////////////////////////////////////////////
                //////////////////////// Set-Up //////////////////////////////
                //////////////////////////////////////////////////////////////

                var margin = {top: 53, right: 50, bottom: 35, left: 62},
                    width = Math.min(480, window.innerWidth - 10) - margin.left - margin.right,
                    height = Math.min(width, window.innerHeight - margin.top - margin.bottom - 20);

                //////////////////////////////////////////////////////////////
                ////////////////////////// Data //////////////////////////////
                //////////////////////////////////////////////////////////////
                var data = [
                [
                    {axis:'',value:'<?php echo $lkjmodel->kompetensigram_integritas; ?>'},
                    {axis:'',value:'<?php echo $lkjmodel->kompetensigram_kerjasama; ?>'},
                    {axis:'',value:'<?php echo $lkjmodel->kompetensigram_komunikasi; ?>'},
                    {axis:'',value:'<?php echo $lkjmodel->kompetensigram_orientasihasil; ?>'},
                    {axis:'',value:'<?php echo $lkjmodel->kompetensigram_pelayananpublik; ?>'},
                    {axis:'',value:'<?php echo $lkjmodel->kompetensigram_pengembangandiri; ?>'},
                    {axis:'',value:'<?php echo $lkjmodel->kompetensigram_pengelolaanperubahan; ?>'},
                    {axis:'',value:'<?php echo $lkjmodel->kompetensigram_pengambilankeputusan; ?>'},
                    {axis:'',value:'<?php echo $lkjmodel->kompetensigram_perekatbangsa; ?>'},
                ],[
                    {axis:'',value:'<?php echo $model->integritas_lki; ?>'},
                    {axis:'',value:'<?php echo $model->kerjasama_lki; ?>'},
                    {axis:'',value:'<?php echo $model->komunikasi_lki; ?>'},
                    {axis:'',value:'<?php echo $model->orientasihasil_lki; ?>'},
                    {axis:'',value:'<?php echo $model->pelayananpublik_lki; ?>'},
                    {axis:'',value:'<?php echo $model->pengembangandiri_lki; ?>'},
                    {axis:'',value:'<?php echo $model->pengelolaanperubahan_lki; ?>'},
                    {axis:'',value:'<?php echo $model->pengambilankeputusan_lki; ?>'},
                    {axis:'',value:'<?php echo $model->perekatbangsa_lki; ?>'},
                ]
                ];

                //////////////////////////////////////////////////////////////
                //////////////////// Draw the Chart //////////////////////////
                //////////////////////////////////////////////////////////////

                var color = d3.scale.ordinal()
                .range(['#AEDFFB','#35274E']);

                var radarChartOptions = {
                    w: width,
                    h: height,
                    margin: margin,
                    maxValue: 6,
                    levels: 5,
                    roundStrokes: false,
                    color: color,
                    opacityArea: 0.5,
                    opacityCircles: 0,
                    dotRadius: 3,
                    strokeWidth: 2,
                    wrapWidth: 10,
                    labelFactor: 10,
                };
                //Call function to draw the Radar chart
                RadarChart(".radarChart", data, radarChartOptions);
            </script>
        </div>
        <div class="col-md-6">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th colspan="3">Kompetensi</th>
                        <th>LKJ</th>
                        <th>LKI</th>
                        <th>GAP</th>
                        <th>PCT</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td rowspan="9" style="background-color: #acb9ca;">Kompetensi Managerial</td>
                        <td>Integritas</td>
                        <td>M.01</td>
                        <td><?php echo $lkjmodel->kompetensigram_integritas; ?></td>
                        <td><?php echo $model->integritas_lki; ?></td>
                        <td><?php echo $lkjmodel->kompetensigram_integritas - $model->integritas_lki < 0 ? 0 : $lkjmodel->kompetensigram_integritas - $model->integritas_lki; ?></td>
                        <td><?php echo $lkjmodel->kompetensigram_integritas == 0 ? "" : round($model->integritas_lki / $lkjmodel->kompetensigram_integritas, 2) * 100; ?>%</td>
                    </tr>
                    <tr>
                        <td>Kerjasama</td>
                        <td>M.02</td>
                        <td><?php echo $lkjmodel->kompetensigram_kerjasama; ?></td>
                        <td><?php echo $model->kerjasama_lki; ?></td>
                        <td><?php echo $lkjmodel->kompetensigram_kerjasama - $model->kerjasama_lki < 0 ? 0 : $lkjmodel->kompetensigram_kerjasama - $model->kerjasama_lki; ?></td>
                        <td><?php echo $lkjmodel->kompetensigram_kerjasama == 0 ? "" : round($model->kerjasama_lki / $lkjmodel->kompetensigram_kerjasama, 2) * 100; ?>%</td>
                    </tr>
                    <tr>
                        <td>Komunikasi</td>
                        <td>M.03</td>
                        <td><?php echo $lkjmodel->kompetensigram_komunikasi; ?></td>
                        <td><?php echo $model->komunikasi_lki; ?></td>
                        <td><?php echo $lkjmodel->kompetensigram_komunikasi - $model->komunikasi_lki < 0 ? 0 : $lkjmodel->kompetensigram_komunikasi - $model->komunikasi_lki; ?></td>
                        <td><?php echo $lkjmodel->kompetensigram_komunikasi == 0 ? "" : round($model->komunikasi_lki / $lkjmodel->kompetensigram_komunikasi, 2) * 100; ?>%</td>
                    </tr>
                    <tr>
                        <td>Orientasi pada Hasil</td>
                        <td>M.04</td>
                        <td><?php echo $lkjmodel->kompetensigram_orientasihasil; ?></td>
                        <td><?php echo $model->orientasihasil_lki; ?></td>
                        <td><?php echo $lkjmodel->kompetensigram_orientasihasil - $model->orientasihasil_lki < 0 ? 0 : $lkjmodel->kompetensigram_orientasihasil - $model->orientasihasil_lki; ?></td>
                        <td><?php echo $lkjmodel->kompetensigram_orientasihasil == 0 ? "" : round($model->orientasihasil_lki / $lkjmodel->kompetensigram_orientasihasil, 2) * 100; ?>%</td>
                    </tr>
                    <tr>
                        <td>Pelayanan Publik</td>
                        <td>M.05</td>
                        <td><?php echo $lkjmodel->kompetensigram_pelayananpublik; ?></td>
                        <td><?php echo $model->pelayananpublik_lki; ?></td>
                        <td><?php echo $lkjmodel->kompetensigram_pelayananpublik - $model->pelayananpublik_lki < 0 ? 0 : $lkjmodel->kompetensigram_pelayananpublik - $model->pelayananpublik_lki; ?></td>
                        <td><?php echo $lkjmodel->kompetensigram_pelayananpublik == 0 ? "" : round($model->pelayananpublik_lki / $lkjmodel->kompetensigram_pelayananpublik, 2) * 100; ?>%</td>
                    </tr>
                    <tr>
                        <td>Pengembangan Diri & Orang Lain</td>
                        <td>M.06</td>
                        <td><?php echo $lkjmodel->kompetensigram_pengembangandiri; ?></td>
                        <td><?php echo $model->pengembangandiri_lki; ?></td>
                        <td><?php echo $lkjmodel->kompetensigram_pengembangandiri - $model->pengembangandiri_lki < 0 ? 0 : $lkjmodel->kompetensigram_pengembangandiri - $model->pengembangandiri_lki; ?></td>
                        <td><?php echo $lkjmodel->kompetensigram_pengembangandiri == 0 ? "" : round($model->pengembangandiri_lki / $lkjmodel->kompetensigram_pengembangandiri, 2) * 100; ?>%</td>
                    </tr>
                    <tr>
                        <td>Mengelola Perubahan</td>
                        <td>M.07</td>
                        <td><?php echo $lkjmodel->kompetensigram_pengelolaanperubahan; ?></td>
                        <td><?php echo $model->pengelolaanperubahan_lki; ?></td>
                        <td><?php echo $lkjmodel->kompetensigram_pengelolaanperubahan - $model->pengelolaanperubahan_lki < 0 ? 0 : $lkjmodel->kompetensigram_pengelolaanperubahan - $model->pengelolaanperubahan_lki; ?></td>
                        <td><?php echo $lkjmodel->kompetensigram_pengelolaanperubahan == 0 ? "" : round($model->pengelolaanperubahan_lki / $lkjmodel->kompetensigram_pengelolaanperubahan, 2) * 100; ?>%</td>
                    </tr>
                    <tr>
                        <td>Pengambilan Keputusan</td>
                        <td>M.08</td>
                        <td><?php echo $lkjmodel->kompetensigram_pengambilankeputusan; ?></td>
                        <td><?php echo $model->pengambilankeputusan_lki; ?></td>
                        <td><?php echo $lkjmodel->kompetensigram_pengambilankeputusan - $model->pengambilankeputusan_lki < 0 ? 0 : $lkjmodel->kompetensigram_pengambilankeputusan - $model->pengambilankeputusan_lki; ?></td>
                        <td><?php echo $lkjmodel->kompetensigram_pengambilankeputusan == 0 ? "" : round($model->pengambilankeputusan_lki / $lkjmodel->kompetensigram_pengambilankeputusan, 2) * 100; ?>%</td>
                    </tr>
                    <tr style="background-color: #acb9ca; font-weight: bold;">
                        <td colspan="2"></td>
                        <td><?php echo ($sumC - $lkjmodel->kompetensigram_perekatbangsa); ?></td>
                        <td><?php echo ($PArk - $model->perekatbangsa_lki); ?></td>
                        <td><?php echo ($sumC - $lkjmodel->kompetensigram_perekatbangsa) - ($PArk - $model->perekatbangsa_lki) < 0 ? 0 : ($sumC - $lkjmodel->kompetensigram_perekatbangsa) - ($PArk - $model->perekatbangsa_lki); ?></td>
                        <td><?php echo ($sumC - $lkjmodel->kompetensigram_perekatbangsa) == 0 ? "" : round(($PArk - $model->perekatbangsa_lki) / ($sumC - $lkjmodel->kompetensigram_perekatbangsa), 2) * 100; ?>%</td>
                    </tr>
                    <tr>
                        <td rowspan="2" style="background-color: #ff66cc;">Sosio Kultural</td>
                        <td>Perekat Bangsa</td>
                        <td>SK.01</td>
                        <td><?php echo $lkjmodel->kompetensigram_perekatbangsa; ?></td>
                        <td><?php echo $model->perekatbangsa_lki; ?></td>
                        <td><?php echo $lkjmodel->kompetensigram_perekatbangsa - $model->perekatbangsa_lki < 0 ? 0 : $lkjmodel->kompetensigram_perekatbangsa - $model->perekatbangsa_lki; ?></td>
                        <td><?php echo $lkjmodel->kompetensigram_perekatbangsa == 0 ? "" : round($model->perekatbangsa_lki / $lkjmodel->kompetensigram_perekatbangsa, 2) * 100; ?>%</td>
                    </tr>
                    <tr style="background-color: #ff66cc; font-weight: bold;">
                        <td colspan="2"></td>
                        <td><?php echo $lkjmodel->kompetensigram_perekatbangsa; ?></td>
                        <td><?php echo $model->perekatbangsa_lki; ?></td>
                        <td><?php echo $lkjmodel->kompetensigram_perekatbangsa - $model->perekatbangsa_lki < 0 ? 0 : $lkjmodel->kompetensigram_perekatbangsa - $model->perekatbangsa_lki; ?></td>
                        <td><?php echo $lkjmodel->kompetensigram_perekatbangsa == 0 ? "" : round($model->perekatbangsa_lki / $lkjmodel->kompetensigram_perekatbangsa, 2) * 100; ?>%</td>
                    </tr>
                    <tr style="background-color: #bfbfbf;">
                        <td colspan="3" class="text-right">TOTAL</td>
                        <td><?php echo $sumC; ?></td>
                        <td><?php echo $PArk; ?></td>
                        <td><?php echo $sumC - $PArk < 0 ? 0 : $sumC - $PArk; ?></td>
                        <td><?php echo $sumC == 0 ? "" : round($PArk / $sumC, 2) * 100; ?>%</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript">
                google.charts.load('current', {'packages':['corechart'], 'language': 'id'});
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                        ['Potensi', 'Kompetensi'],
                        [ <?=round($PArp/70*100); ?>,  <?=round($PArk/$sumC*100); ?>], //ini harus diisi
                    ]);

                    var options = {
                        hAxis: {
                            //title: 'Potensi', minValue: 0, maxValue: 100,
                            gridlines:{color: '#eee', count: 7},
                            ticks: [0, 20, 40, 60, 80, 100, 120, 140, ]
                        },
                        vAxis: {
                            // title: 'Kompetensi', minValue: 0, maxValue: 100,
                            gridlines:{color: '#eee', count: 7},
                            ticks: [0, 20, 40, 60,  80,100, 120, 140, ]
                        },
                        crosshair: { trigger: 'both' },
                        legend: 'none',
                        backgroundColor: { fill:'transparent' }
                        //vAxis.gridlines:{color: '#333', count: 4}
                    };

                    var chart = new google.visualization.ScatterChart(document.getElementById('chart_div'));

                    chart.draw(data, options);
                }
            </script>
            <table class="center" style="margin: auto;">
                <tr>
                    <td align="left">
                        <?php
                        $sumbuY = round($PArk/$sumC*100);
                        $sumbuX = round($PArp/70*100);

                        if ($sumbuY >=100) {
                            echo "<img height='450' width='130' src=".Url::base()."/images/setkab-sumbuYtop.PNG>";
                        } else if ($sumbuY >= 80 && $sumbuY <= 99) {
                            echo "<img height='450' width='130' src=".Url::base()."/images/setkab-sumbuYmiddle.PNG>";
                        } else {
                            echo "<img height='450' width='130' src=".Url::base()."/images/setkab-sumbuYbot.PNG>";
                        }
                        ?>
                    </td>
                    <td>
                        <div id="chart_div" style="width: 600px; height: 600px; background-image: url('<?=Url::base()?>/images/setkab-9cell.png'); background-repeat: no-repeat; background-position: center;">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style= "margin:10px;">
                            <table style="width: 100%; margin-left: auto; margin-right: auto;" border="1" cellspacing="1" cellpadding="1">
                                <tbody>
                                    <tr>
                                        <td bgcolor="yellow">X</td>
                                        <td bgcolor="yellow"><?=$sumbuX;?>%</td>
                                        <td rowspan="2">
                                            <h2>
                                                <?php
                                                if ($sumbuX < 80 && $sumbuY < 80) {$ninecellScore = 1;}
                                                else if ($sumbuX < 80 && $sumbuY < 100 && $sumbuY > 79 && $sumbuY < 100) {$ninecellScore = 2;}
                                                else if ($sumbuX >= 80 && $sumbuX < 100 && $sumbuY < 80) {$ninecellScore = 3;}
                                                else if ($sumbuX < 80 && $sumbuY < 99) {$ninecellScore = 4;}
                                                else if ($sumbuX >= 80 && $sumbuX < 100 && $sumbuY > 79 && $sumbuY < 100) {$ninecellScore = 5;}
                                                else if ($sumbuX >= 100 && $sumbuY < 80) {$ninecellScore = 6;}
                                                else if ($sumbuX >= 80 && $sumbuX < 100 && $sumbuY >= 100) {$ninecellScore = 7;}
                                                else if ($sumbuX >= 100 && $sumbuY >= 80 && $sumbuY < 100) {$ninecellScore = 8;}
                                                else if ($sumbuX >= 100 && $sumbuY >= 100) {$ninecellScore = 9;}
                                                else {$ninecellScore = 0;}
                                                echo '<font style="color:green;">'.$ninecellScore.'</font>';
                                                ?>
                                            </h2>
                                        </td>
                                    </tr>
                                    <tr >
                                        <td bgcolor="#B8CCE4">Y</td>
                                        <td bgcolor="#B8CCE4"><?=$sumbuY;?>%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </td>
                    <td align="left">
                        <?php
                        if ($sumbuX >=100) {
                            echo "<img height='125' width='500' src=".Url::base()."/images/setkab-sumbuXtop.PNG>";
                        } else if ($sumbuX >= 80 && $sumbuX<= 99) {
                            echo "<img height='125' width='500' src=".Url::base()."/images/setkab-sumbuXmiddle.PNG>";
                        } else {
                            echo "<img height='125' width='500' src=".Url::base()."/images/setkab-sumbuXbot.PNG>";
                        }
                        ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <hr/>
</div>

<div class="setkab-activity-update">


    <?php $form = ActiveForm::begin(); ?>
<?php
//echo    $form->field($model, 'saran')->textArea(['maxlength' => true]);

	echo $form->field($model, 'kelemahan')->widget(\yii\redactor\widgets\Redactor::className(), [
    'clientOptions' => [
        'plugins' => ['clips', 'fontcolor','fullscreen', 'counter']
    ]
])->label('<h3><strong>(Kelemahan) Hal-hal negatif yang menghambat tampilnya kinerja yang optimal:</strong></h3>');

$dom = new DOMDocument;
$li_count = 0;
$word_count = 0;

if (!empty($model->kelemahan)) {
$dom->loadHTML(HtmlPurifier::process($model->kelemahan));

$new_element = $dom->createElement('test', ' ');
    foreach($dom->getElementsByTagName('li') as $li) {
        $li_count = $li_count + str_word_count(strip_tags($li->textContent));
    }

        foreach($dom->getElementsByTagName('ul') as $ul) {
            $ul->parentNode->replaceChild($new_element,$ul);
            $dom->saveHTML();
    
        }
        foreach($dom->getElementsByTagName('ol') as $ol) {
            $ol->parentNode->replaceChild($new_element,$ol);
            $dom->saveHTML();
    
        }


       $replaced_dom = preg_replace('#\<(.+?)\>#', ' ', $dom->saveHTML());
        $word_count = str_word_count(strip_tags($replaced_dom));
	}
	
		$total_count = $word_count + $li_count;
		
echo $hint_text = 'words : ' . $total_count . ' , characters : ' . strlen(str_replace(' ','',strip_tags($model->kelemahan)));
?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
