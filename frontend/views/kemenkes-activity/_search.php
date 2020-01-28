<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\KemenkesActivitySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kemenkes-activity-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'assessee_id') ?>

    <?= $form->field($model, 'assessor_id') ?>

    <?= $form->field($model, 'second_opinion_id') ?>

    <?= $form->field($model, 'no_test') ?>

    <?php // echo $form->field($model, 'tanggal_test') ?>

    <?php // echo $form->field($model, 'tempat_test') ?>

    <?php // echo $form->field($model, 'tujuan_pemeriksaan') ?>

    <?php // echo $form->field($model, 'saran') ?>

    <?php // echo $form->field($model, 'executive_summary') ?>

    <?php // echo $form->field($model, 'kekuatan') ?>

    <?php // echo $form->field($model, 'kelemahan') ?>

    <?php // echo $form->field($model, 'integritas_lki') ?>

    <?php // echo $form->field($model, 'integritas_uraian') ?>

    <?php // echo $form->field($model, 'kerjasama_lki') ?>

    <?php // echo $form->field($model, 'kerjasama_uraian') ?>

    <?php // echo $form->field($model, 'komunikasi_lki') ?>

    <?php // echo $form->field($model, 'komunikasi_uraian') ?>

    <?php // echo $form->field($model, 'orientasihasil_lki') ?>

    <?php // echo $form->field($model, 'orientasihasil_uraian') ?>

    <?php // echo $form->field($model, 'pelayananpublik_lki') ?>

    <?php // echo $form->field($model, 'pelayananpublik_uraian') ?>

    <?php // echo $form->field($model, 'pengembangandiri_lki') ?>

    <?php // echo $form->field($model, 'pengembangandiri_uraian') ?>

    <?php // echo $form->field($model, 'pengelolaanperubahan_lki') ?>

    <?php // echo $form->field($model, 'pengelolaanperubahan_uraian') ?>

    <?php // echo $form->field($model, 'pengambilankeputusan_lki') ?>

    <?php // echo $form->field($model, 'pengambilankeputusan_uraian') ?>

    <?php // echo $form->field($model, 'perekatbangsa_lki') ?>

    <?php // echo $form->field($model, 'perekatbangsa_uraian') ?>

    <?php // echo $form->field($model, 'integritas_indikator') ?>

    <?php // echo $form->field($model, 'kerjasama_indikator') ?>

    <?php // echo $form->field($model, 'komunikasi_indikator') ?>

    <?php // echo $form->field($model, 'orientasihasil_indikator') ?>

    <?php // echo $form->field($model, 'pelayananpublik_indikator') ?>

    <?php // echo $form->field($model, 'pengembangandiri_indikator') ?>

    <?php // echo $form->field($model, 'pengelolaanperubahan_indikator') ?>

    <?php // echo $form->field($model, 'pengambilankeputusan_indikator') ?>

    <?php // echo $form->field($model, 'perekatbangsa_indikator') ?>

    <?php // echo $form->field($model, 'psikogram_kemampuananalisa') ?>

    <?php // echo $form->field($model, 'psikogram_empati') ?>

    <?php // echo $form->field($model, 'psikogram_kemampuanumum') ?>

    <?php // echo $form->field($model, 'psikogram_kemampuanbelajar') ?>

    <?php // echo $form->field($model, 'psikogram_ketekunan') ?>

    <?php // echo $form->field($model, 'psikogram_ketelitian') ?>

    <?php // echo $form->field($model, 'psikogram_komunikasiefektif') ?>

    <?php // echo $form->field($model, 'psikogram_konsepdiri') ?>

    <?php // echo $form->field($model, 'psikogram_logikaberpikir') ?>

    <?php // echo $form->field($model, 'psikogram_motivasi') ?>

    <?php // echo $form->field($model, 'psikogram_pemahamansosial') ?>

    <?php // echo $form->field($model, 'psikogram_kematanganemosi') ?>

    <?php // echo $form->field($model, 'psikogram_sistematikakerja') ?>

    <?php // echo $form->field($model, 'psikogram_tempokerja') ?>

    <?php // echo $form->field($model, 'psikogram_inisiatif') ?>

    <?php // echo $form->field($model, 'psikogram_adaptif') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
