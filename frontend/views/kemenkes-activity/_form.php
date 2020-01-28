<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\KemenkesActivity */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kemenkes-activity-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'assessee_id')->textInput() ?>

    <?= $form->field($model, 'assessor_id')->textInput() ?>

    <?= $form->field($model, 'second_opinion_id')->textInput() ?>

    <?= $form->field($model, 'no_test')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tanggal_test')->textInput() ?>

    <?= $form->field($model, 'tempat_test')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tujuan_pemeriksaan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'saran')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'executive_summary')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'kekuatan')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'kelemahan')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'integritas_lki')->textInput() ?>

    <?= $form->field($model, 'integritas_uraian')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'kerjasama_lki')->textInput() ?>

    <?= $form->field($model, 'kerjasama_uraian')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'komunikasi_lki')->textInput() ?>

    <?= $form->field($model, 'komunikasi_uraian')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'orientasihasil_lki')->textInput() ?>

    <?= $form->field($model, 'orientasihasil_uraian')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'pelayananpublik_lki')->textInput() ?>

    <?= $form->field($model, 'pelayananpublik_uraian')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'pengembangandiri_lki')->textInput() ?>

    <?= $form->field($model, 'pengembangandiri_uraian')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'pengelolaanperubahan_lki')->textInput() ?>

    <?= $form->field($model, 'pengelolaanperubahan_uraian')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'pengambilankeputusan_lki')->textInput() ?>

    <?= $form->field($model, 'pengambilankeputusan_uraian')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'perekatbangsa_lki')->textInput() ?>

    <?= $form->field($model, 'perekatbangsa_uraian')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'integritas_indikator')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kerjasama_indikator')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'komunikasi_indikator')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'orientasihasil_indikator')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pelayananpublik_indikator')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pengembangandiri_indikator')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pengelolaanperubahan_indikator')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pengambilankeputusan_indikator')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'perekatbangsa_indikator')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'psikogram_kemampuananalisa')->textInput() ?>

    <?= $form->field($model, 'psikogram_empati')->textInput() ?>

    <?= $form->field($model, 'psikogram_kemampuanumum')->textInput() ?>

    <?= $form->field($model, 'psikogram_kemampuanbelajar')->textInput() ?>

    <?= $form->field($model, 'psikogram_ketekunan')->textInput() ?>

    <?= $form->field($model, 'psikogram_ketelitian')->textInput() ?>

    <?= $form->field($model, 'psikogram_komunikasiefektif')->textInput() ?>

    <?= $form->field($model, 'psikogram_konsepdiri')->textInput() ?>

    <?= $form->field($model, 'psikogram_logikaberpikir')->textInput() ?>

    <?= $form->field($model, 'psikogram_motivasi')->textInput() ?>

    <?= $form->field($model, 'psikogram_pemahamansosial')->textInput() ?>

    <?= $form->field($model, 'psikogram_kematanganemosi')->textInput() ?>

    <?= $form->field($model, 'psikogram_sistematikakerja')->textInput() ?>

    <?= $form->field($model, 'psikogram_tempokerja')->textInput() ?>

    <?= $form->field($model, 'psikogram_inisiatif')->textInput() ?>

    <?= $form->field($model, 'psikogram_adaptif')->textInput() ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
