<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\SetkabActivitySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="setkab-activity-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'assessee_id') ?>

    <?= $form->field($model, 'assessor_id') ?>

    <?= $form->field($model, 'second_opinion_id') ?>

    <?= $form->field($model, 'tanggal_test') ?>

    <?php // echo $form->field($model, 'tempat_test') ?>

    <?php // echo $form->field($model, 'tujuan_pemeriksaan') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
