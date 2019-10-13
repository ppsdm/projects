<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
//use kartik\detail\DetailView;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\widgets\DatePicker;


use yii\web\View;
use app\assets\AppAsset;
use common\modules\core\models\RefValue;
use app\modules\projects\models\Project;
use app\modules\projects\models\ProjectMeta;
use app\modules\projects\models\ProjectActivity;
use app\modules\projects\models\AssessmentReport;
use app\modules\projects\models\ProjectActivityMeta;
use app\modules\projects\models\ProjectAssessment;
use app\modules\projects\models\ProjectAssessmentResult;
use common\modules\profile\models\ProfileMeta;
use common\modules\profile\models\Profile;
use common\modules\catalog\models\RefAssessmentDictionary;
use common\modules\catalog\models\Catalog;
use common\modules\catalog\models\CatalogMeta;

use kartik\grid\GridView;
use machour\yii2\notifications\widgets\NotificationsWidget;
use common\modules\core\models\Notification;
use kartik\editable\Editable;
use yii2tech\html2pdf\Manager;


$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Kemenkes Activity',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Kemenkes Activities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');

$this->registerCss("
    .RadioBox {
        border: 1px solid #ccc;
        padding: 10px;
        display: inline-block;
    }

    .RadioBox2 {
        border: 1px solid #ccc;
        padding: 10px;
        display: inline-block;
        background-color: #ccc;
    }

");

?>
<div class="setkab-activity-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin(); ?>



<h3>Aspek Intelektual</h3>
<table class="table table-bordered table-responsive table-hover">
    <thead>
        <tr class="bg-info">
            <th width="15%">Aspek Intelektual</th>
            <th>Keterangan</th>
            <th width="30%">Penilaian</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Kemampuan umum</td>
            <td>Gabungan keseluruhan potensi kecerdasan sebagai perpaduan dari aspek-aspek pembentukan intelektualitas</td>
            <td><?= $form->field($model, 'psikogram_kemampuanumum')->radioList(
                    [1=>'1',2=>'2',3=>'3',4=>'4',5=>'5'],
                    [
                        'item' => function($index, $label, $name, $checked, $value) {
                            if ($index == 3 - 1) {
                                return "<div class='RadioBox2'><label><input type='radio' name='$name' value='$value' " . ($checked == $value ? 'checked' : '') . " class='RadioBox'>$label</label></div>";
                            } else {
                                return "<div class='RadioBox'><label><input type='radio' name='$name' value='$value' " . ($checked == $value ? 'checked' : '') . " class='RadioBox'>$label</label></div>";
                            }
                        },
                    ]
                )->label(false); ?></td>
        </tr>
        <tr>
            <td>Kemampuan Analisa / Berpikir Analitis</td>
            <td>Kemampuan menguraikan masalah & melihat kaitan antara satu hal dg hal lainnya hingga menemukan kesimpulan</td>
            <td><?= $form->field($model, 'psikogram_kemampuananalisa')->radioList(
                    [1=>'1',2=>'2',3=>'3',4=>'4',5=>'5'],
                    [
                        'item' => function($index, $label, $name, $checked, $value) {
                            if ($index == 4 - 1) {
                                return "<div class='RadioBox2'><label><input type='radio' name='$name' value='$value' " . ($checked == $value ? 'checked' : '') . " class='RadioBox'>$label</label></div>";
                            } else {
                                return "<div class='RadioBox'><label><input type='radio' name='$name' value='$value' " . ($checked == $value ? 'checked' : '') . " class='RadioBox'>$label</label></div>";
                            }
                        },
                    ]
                )->label(false); ?></td>
        </tr>
        <tr>
            <td>Logika berpikir</td>
            <td>Kemampuan untuk mengorganisir proses berpikir yang menunjukkan adanya alur berpikir yang sistematis dan logis   </td>
            <td><?= $form->field($model, 'psikogram_logikaberpikir')->radioList(
                    [1=>'1',2=>'2',3=>'3',4=>'4',5=>'5'],
                    [
                        'item' => function($index, $label, $name, $checked, $value) {
                            if ($index == 4 - 1) {
                                return "<div class='RadioBox2'><label><input type='radio' name='$name' value='$value' " . ($checked == $value ? 'checked' : '') . " class='RadioBox'>$label</label></div>";
                            } else {
                                return "<div class='RadioBox'><label><input type='radio' name='$name' value='$value' " . ($checked == $value ? 'checked' : '') . " class='RadioBox'>$label</label></div>";
                            }
                        },
                    ]
                )->label(false); ?></td>
        </tr>

        <tr>
            <td>Kemampuan belajar</td>
            <td>Kemampuan menguasai dan meningkatkan pengetahuan dan ketrampilan kerja yang baru maupun yang telah dimiliki </td>
            <td><?= $form->field($model, 'psikogram_kemampuanbelajar')->radioList(
                    [1=>'1',2=>'2',3=>'3',4=>'4',5=>'5'],
                    [
                        'item' => function($index, $label, $name, $checked, $value) {
                            if ($index == 3 - 1) {
                                return "<div class='RadioBox2'><label><input type='radio' name='$name' value='$value' " . ($checked == $value ? 'checked' : '') . " class='RadioBox'>$label</label></div>";
                            } else {
                                return "<div class='RadioBox'><label><input type='radio' name='$name' value='$value' " . ($checked == $value ? 'checked' : '') . " class='RadioBox'>$label</label></div>";
                            }
                        },
                    ]
                )->label(false); ?></td>
        </tr>
    </tbody>
</table>

<hr/>

<h3>Aspek Sikap Kerja</h3>
<table class="table table-bordered table-responsive table-hover">
    <thead>
        <tr class="bg-info">
            <th width="15%">Aspek Sikap Kerja</th>
            <th>Keterangan</th>
            <th width="30%">Penilaian</th>
        </tr>
    </thead>
    <tbody>
    <tr>
            <td>Ketelitian</td>
            <td>Kemampuan bekerja dengan sesedikit mungkin melakukan kesalahan atau kekeliruan  </td>
            <td><?= $form->field($model, 'psikogram_ketelitian')->radioList(
                    [1=>'1',2=>'2',3=>'3',4=>'4',5=>'5'],
                    [
                        'item' => function($index, $label, $name, $checked, $value) {
                            if ($index == 4 - 1) {
                                return "<div class='RadioBox2'><label><input type='radio' name='$name' value='$value' " . ($checked == $value ? 'checked' : '') . " class='RadioBox'>$label</label></div>";
                            } else {
                                return "<div class='RadioBox'><label><input type='radio' name='$name' value='$value' " . ($checked == $value ? 'checked' : '') . " class='RadioBox'>$label</label></div>";
                            }
                        },
                    ]
                )->label(false); ?></td>
        </tr>
        <tr>
            <td>Ketekunan</td>
            <td>Daya tahan menghadapi dan menyelesaikan tugas sampai tuntas dalam waktu relatif lama dengan mencapai hasil yang optimal</td>
            <td><?= $form->field($model, 'psikogram_ketekunan')->radioList(
                    [1=>'1',2=>'2',3=>'3',4=>'4',5=>'5'],
                    [
                        'item' => function($index, $label, $name, $checked, $value) {
                            if ($index == 3 - 1) {
                                return "<div class='RadioBox2'><label><input type='radio' name='$name' value='$value' " . ($checked == $value ? 'checked' : '') . " class='RadioBox'>$label</label></div>";
                            } else {
                                return "<div class='RadioBox'><label><input type='radio' name='$name' value='$value' " . ($checked == $value ? 'checked' : '') . " class='RadioBox'>$label</label></div>";
                            }
                        },
                    ]
                )->label(false); ?></td>
        </tr>
        <tr>
            <td>Tempo Kerja</td>
            <td>Kecepatan dan kecekatan kerja, yang menunjukkan kemampuan menyelesaikan sejumlah tugas dalam batas waktu tertentu</td>
            <td><?= $form->field($model, 'psikogram_tempokerja')->radioList(
                    [1=>'1',2=>'2',3=>'3',4=>'4',5=>'5'],
                    [
                        'item' => function($index, $label, $name, $checked, $value) {
                            if ($index == 3 - 1) {
                                return "<div class='RadioBox2'><label><input type='radio' name='$name' value='$value' " . ($checked == $value ? 'checked' : '') . " class='RadioBox'>$label</label></div>";
                            } else {
                                return "<div class='RadioBox'><label><input type='radio' name='$name' value='$value' " . ($checked == $value ? 'checked' : '') . " class='RadioBox'>$label</label></div>";
                            }
                        },
                    ]
                )->label(false); ?></td>
        </tr>
        <tr>
            <td>Inisiatif</td>
            <td>Keinginan individu untuk mau melaksanakan tugasnya sesuai dengan kewenangannya tanpa diminta oleh orang lain.</td>
            <td><?= $form->field($model, 'psikogram_inisiatif')->radioList(
                    [1=>'1',2=>'2',3=>'3',4=>'4',5=>'5'],
                    [
                        'item' => function($index, $label, $name, $checked, $value) {
                            if ($index == 3 - 1) {
                                return "<div class='RadioBox2'><label><input type='radio' name='$name' value='$value' " . ($checked == $value ? 'checked' : '') . " class='RadioBox'>$label</label></div>";
                            } else {
                                return "<div class='RadioBox'><label><input type='radio' name='$name' value='$value' " . ($checked == $value ? 'checked' : '') . " class='RadioBox'>$label</label></div>";
                            }
                        },
                    ]
                )->label(false); ?></td>
        </tr>
        <tr>
            <td>Sistematika Kerja</td>
            <td>Kemampuan dan ketrampilan menyelesaikan suatu tugas secara runut, proporsional, sesuai dengan skala prioritas tertentu  </td>
            <td><?= $form->field($model, 'psikogram_sistematikakerja')->radioList(
                    [1=>'1',2=>'2',3=>'3',4=>'4',5=>'5'],
                    [
                        'item' => function($index, $label, $name, $checked, $value) {
                            if ($index == 3 - 1) {
                                return "<div class='RadioBox2'><label><input type='radio' name='$name' value='$value' " . ($checked == $value ? 'checked' : '') . " class='RadioBox'>$label</label></div>";
                            } else {
                                return "<div class='RadioBox'><label><input type='radio' name='$name' value='$value' " . ($checked == $value ? 'checked' : '') . " class='RadioBox'>$label</label></div>";
                            }
                        },
                    ]
                )->label(false); ?></td>
        </tr>

        <tr>
            <td>Komunikasi Efektif</td>
            <td>Kemampuan menyampaikan pendapat secara lancar, sehingga pendengar paham dan bersedia mengikuti pendapatnya</td>
            <td><?= $form->field($model, 'psikogram_komunikasiefektif')->radioList(
                    [1=>'1',2=>'2',3=>'3',4=>'4',5=>'5'],
                    [
                        'item' => function($index, $label, $name, $checked, $value) {
                            if ($index == 4 - 1) {
                                return "<div class='RadioBox2'><label><input type='radio' name='$name' value='$value' " . ($checked == $value ? 'checked' : '') . " class='RadioBox'>$label</label></div>";
                            } else {
                                return "<div class='RadioBox'><label><input type='radio' name='$name' value='$value' " . ($checked == $value ? 'checked' : '') . " class='RadioBox'>$label</label></div>";
                            }
                        },
                    ]
                )->label(false); ?></td>
        </tr>




    </tbody>
</table>

<hr/>

<h3>Aspek Kepribadian</h3>
<table class="table table-bordered table-responsive table-hover">
    <thead>
        <tr class="bg-info">
            <th width="15%">Aspek Kepribadian</th>
            <th>Keterangan</th>
            <th width="30%">Penilaian</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Motivasi</td>
            <td>Keinginan meningkatkan hasil kerja dan selalu berfokus pada profit opportunities</td>
            <td><?= $form->field($model, 'psikogram_motivasi')->radioList(
                    [1=>'1',2=>'2',3=>'3',4=>'4',5=>'5'],
                    [
                        'item' => function($index, $label, $name, $checked, $value) {
                            if ($index == 3 - 1) {
                                return "<div class='RadioBox2'><label><input type='radio' name='$name' value='$value' " . ($checked == $value ? 'checked' : '') . " class='RadioBox'>$label</label></div>";
                            } else {
                                return "<div class='RadioBox'><label><input type='radio' name='$name' value='$value' " . ($checked == $value ? 'checked' : '') . " class='RadioBox'>$label</label></div>";
                            }
                        },
                    ]
                )->label(false); ?></td>
        </tr>
        <tr>
            <td>Konsep Diri</td>
            <td>Pemahaman atas kelebihan dan kekurangan diri sendiri</td>
            <td><?= $form->field($model, 'psikogram_konsepdiri')->radioList(
                    [1=>'1',2=>'2',3=>'3',4=>'4',5=>'5'],
                    [
                        'item' => function($index, $label, $name, $checked, $value) {
                            if ($index == 3 - 1) {
                                return "<div class='RadioBox2'><label><input type='radio' name='$name' value='$value' " . ($checked == $value ? 'checked' : '') . " class='RadioBox'>$label</label></div>";
                            } else {
                                return "<div class='RadioBox'><label><input type='radio' name='$name' value='$value' " . ($checked == $value ? 'checked' : '') . " class='RadioBox'>$label</label></div>";
                            }
                        },
                    ]
                )->label(false); ?></td>
        </tr>
        <tr>
            <td>Empati</td>
            <td>Kemampuan memahami dan merasakan adanya permasalahan dan kondisi emosional orang lain   </td>
            <td><?= $form->field($model, 'psikogram_empati')->radioList(
                    [1=>'1',2=>'2',3=>'3',4=>'4',5=>'5'],
                    [
                        'item' => function($index, $label, $name, $checked, $value) {
                            if ($index == 4 - 1) {
                                return "<div class='RadioBox2'><label><input type='radio' name='$name' value='$value' " . ($checked == $value ? 'checked' : '') . " class='RadioBox'>$label</label></div>";
                            } else {
                                return "<div class='RadioBox'><label><input type='radio' name='$name' value='$value' " . ($checked == $value ? 'checked' : '') . " class='RadioBox'>$label</label></div>";
                            }
                        },
                    ]
                )->label(false); ?></td>
        </tr>
        <tr>
            <td>Pemahaman Sosial</td>
            <td>Kemampuan bereaksi dengan cepat terhadap kebutuhan orang lain atau tuntutan lingkungan, serta memahami norma sosial yang berlaku.   </td>
            <td><?= $form->field($model, 'psikogram_pemahamansosial')->radioList(
                    [1=>'1',2=>'2',3=>'3',4=>'4',5=>'5'],
                    [
                        'item' => function($index, $label, $name, $checked, $value) {
                            if ($index == 4 - 1) {
                                return "<div class='RadioBox2'><label><input type='radio' name='$name' value='$value' " . ($checked == $value ? 'checked' : '') . " class='RadioBox'>$label</label></div>";
                            } else {
                                return "<div class='RadioBox'><label><input type='radio' name='$name' value='$value' " . ($checked == $value ? 'checked' : '') . " class='RadioBox'>$label</label></div>";
                            }
                        },
                    ]
                )->label(false); ?></td>
        </tr>

        <tr>
            <td>Kematangan Emosi</td>
            <td>Keluasan pengetahuan dan kemampuan mengelola emosi secara optimal. </td>
            <td><?= $form->field($model, 'psikogram_kematanganemosi')->radioList(
                    [1=>'1',2=>'2',3=>'3',4=>'4',5=>'5'],
                    [
                        'item' => function($index, $label, $name, $checked, $value) {
                            if ($index == 3 - 1) {
                                return "<div class='RadioBox2'><label><input type='radio' name='$name' value='$value' " . ($checked == $value ? 'checked' : '') . " class='RadioBox'>$label</label></div>";
                            } else {
                                return "<div class='RadioBox'><label><input type='radio' name='$name' value='$value' " . ($checked == $value ? 'checked' : '') . " class='RadioBox'>$label</label></div>";
                            }
                        },
                    ]
                )->label(false); ?></td>
        </tr>

        <tr>
            <td>Adaptif</td>
            <td>Kemampuan menyesuaikan diri dengan lingkungan.</td>
            <td><?= $form->field($model, 'psikogram_adaptif')->radioList(
                    [1=>'1',2=>'2',3=>'3',4=>'4',5=>'5'],
                    [
                        'item' => function($index, $label, $name, $checked, $value) {
                            if ($index == 3 - 1) {
                                return "<div class='RadioBox2'><label><input type='radio' name='$name' value='$value' " . ($checked == $value ? 'checked' : '') . " class='RadioBox'>$label</label></div>";
                            } else {
                                return "<div class='RadioBox'><label><input type='radio' name='$name' value='$value' " . ($checked == $value ? 'checked' : '') . " class='RadioBox'>$label</label></div>";
                            }
                        },
                    ]
                )->label(false); ?></td>
        </tr>


    </tbody>
</table>

<?php

$psikogram_total = 0;
$psikogram_total += $model->psikogram_kemampuananalisa;
$psikogram_total += $model->psikogram_empati;
$psikogram_total += $model->psikogram_adaptif;
$psikogram_total += $model->psikogram_kemampuanumum;
$psikogram_total += $model->psikogram_kemampuanbelajar;
$psikogram_total += $model->psikogram_ketekunan;
$psikogram_total += $model->psikogram_ketelitian;
$psikogram_total += $model->psikogram_inisiatif;
$psikogram_total += $model->psikogram_komunikasiefektif;
$psikogram_total += $model->psikogram_konsepdiri;
$psikogram_total += $model->psikogram_logikaberpikir;
$psikogram_total += $model->psikogram_motivasi;
$psikogram_total += $model->psikogram_pemahamansosial;
$psikogram_total += $model->psikogram_kematanganemosi;
$psikogram_total += $model->psikogram_sistematikakerja;
$psikogram_total += $model->psikogram_tempokerja;

$psikogram_total_persen = round($psikogram_total / 54 * 100);

?>

<table class="table table-bordered table-responsive">
    <tr class="bg-info">
        <td align="right">
            <span class="h4">TOTAL SKOR</span>
        </td>
        <td width="30%" align="center">
            <span class="h4">
                <span class="result-number"><?php echo $psikogram_total; ?></span> = <span class="result-percentage"><?php echo $psikogram_total_persen ?>%</span>
            </span>
        </td>
    </tr>
</table>

<div class="row" style="margin-bottom: 2rem;">
    <div class="col-sm-12">
        <?php
        if ($psikogram_total_persen >=100) {
            echo "<img class='img-responsive center-block' style='width: 60%;' src=".Url::base()."/images/setkab-sumbuXtop.PNG>";
        } else if ($psikogram_total_persen >= 80 && $psikogram_total_persen <= 99) {
            echo "<img class='img-responsive center-block' style='width: 60%;' src=".Url::base()."/images/setkab-sumbuXmiddle.PNG>";
        } else {
            echo "<img class='img-responsive center-block' style='width: 60%;' src=".Url::base()."/images/setkab-sumbuXbot.PNG>";
        }
        ?>
    </div>
</div>


<?php
/*
    echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'assessee_id',
            'assessor_id',
            'second_opinion_id',
            'tanggal_test',
            'tempat_test',
            'tujuan_pemeriksaan',
            [
                'label' => 'LKI',
                'value' => function($data) {
                    //echo Html::activeRadioList($this->model, $this->attribute, $this->enum, $this->options);
                    return Html::radioList(array('1'=>'One',2=>'Two'));

                    //return 'sasdada';
                }
            ],
        ],
    ]);
    */
    ?>


        <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'value' => 'update', 'name' => 'submit2']) ?>
    </div>
    <?php ActiveForm::end(); ?>

    </div>
