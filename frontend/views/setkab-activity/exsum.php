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
        <div class="col-md-6">
            <h4>Diagram Kompetensi</h4>
            <div class="radarChart" style="background-image: url('<?=Url::base()?>/images/setkab/LINGKARAN.png'); background-repeat: no-repeat;background-size: 490px 510px; height: 550px;"></div>
        </div>
    </div>

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
                {axis:'',value:'3'},
                {axis:'',value:'3'},
                {axis:'',value:'3'},
                {axis:'',value:'3'},
                {axis:'',value:'3'},
                {axis:'',value:'3'},
                {axis:'',value:'3'},
                {axis:'',value:'3'},
                {axis:'',value:'3'},
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
