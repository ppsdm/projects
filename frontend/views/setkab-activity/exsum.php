<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\redactor\widgets\Redactor as Redactor;

/* @var $this yii\web\View */
/* @var $model frontend\models\SetkabActivity */

$this->title = Yii::t('app', 'Executive Summary {modelClass}: ', [
    'modelClass' => 'Setkab Activity',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Setkab Activities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>

<div class="setkab-activity-update">
    <h1>Executive Summary</h1>
</div>

<div class="setkab-activity-update">
    <div class="row">
        <div class="col-md-12">
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
        <div class="col-md-12">
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
            <table class="center">
                <tr>
                    <td align="left">
                        <?php
                        $sumbuY = round($PArk/$sumC*100);
                        $sumbuX = round($PArp/70*100);

                        if ($sumbuY >=100) {
                            echo "<img height='450' width='130' src=".Url::base()."/images/kompetensiSumbuY-top.png>";
                        } else if ($sumbuY >= 75 && $sumbuY <= 99) {
                            echo "<img height='450' width='130' src=".Url::base()."/images/kompetensiSumbuY-middle.png>";
                        } else {
                            echo "<img height='450' width='130' src=".Url::base()."/images/kompetensiSumbuY-bottom.png>";
                        }
                        ?>
                    </td>
                    <td>
                        <div id="chart_div" style="width: 600px; height: 600px; background-image: url('<?=Url::base()?>/images/ninecell.png'); background-repeat: no-repeat; background-position: center;">
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
                                                if ($sumbuX < 75 && $sumbuY < 75) {$ninecellScore = 1;}
                                                else if ($sumbuX < 75 && $sumbuY < 100 && $sumbuY > 74 && $sumbuY < 100) {$ninecellScore = 2;}
                                                else if ($sumbuX >= 75 && $sumbuX < 100 && $sumbuY < 75) {$ninecellScore = 3;}
                                                else if ($sumbuX < 75 && $sumbuY < 99) {$ninecellScore = 4;}
                                                else if ($sumbuX >= 75 && $sumbuX < 100 && $sumbuY > 74 && $sumbuY < 100) {$ninecellScore = 5;}
                                                else if ($sumbuX >= 100 && $sumbuY < 75) {$ninecellScore = 6;}
                                                else if ($sumbuX >= 75 && $sumbuX < 100 && $sumbuY >= 100) {$ninecellScore = 7;}
                                                else if ($sumbuX >= 100 && $sumbuY >= 75 && $sumbuY < 100) {$ninecellScore = 8;}
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
                            echo "<img height='125' width='500' src=".Url::base()."/images/potensiSumbuX.png>";
                        } else if ($sumbuX >= 75 && $sumbuX<= 99) {
                            echo "<img height='125' width='500' src=".Url::base()."/images/potensiSumbuX-middle.png>";
                        } else {
                            echo "<img height='125' width='500' src=".Url::base()."/images/potensiSumbuX-bottom.png>";
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

	echo $form->field($model, 'executive_summary')->widget(\yii\redactor\widgets\Redactor::className(), [
    'clientOptions' => [
        'plugins' => ['clips', 'fontcolor','fullscreen', 'counter']
    ]
]);
echo $hint_text = 'words : ' . str_word_count(strip_tags($model->executive_summary)) . ' , characters : ' . strlen(str_replace(' ','',strip_tags($model->executive_summary)));
?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
