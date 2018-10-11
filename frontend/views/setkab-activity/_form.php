<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\SetkabActivity */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="setkab-activity-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'assessee_id')->textInput() ?>

    <?= $form->field($model, 'assessor_id')->textInput() ?>

    <?= $form->field($model, 'second_opinion_id')->textInput() ?>

    <?= $form->field($model, 'tanggal_test')->textInput() ?>

    <?= $form->field($model, 'tempat_test')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tujuan_pemeriksaan')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
