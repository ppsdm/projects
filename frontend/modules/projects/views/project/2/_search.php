<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\projects\models\ProjectAssessmentResultSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-assessment-result-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'project_assessment_id') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'key') ?>

    <?= $form->field($model, 'value') ?>

    <?php // echo $form->field($model, 'textvalue') ?>

    <?php // echo $form->field($model, 'attribute_1') ?>

    <?php // echo $form->field($model, 'attribute_2') ?>

    <?php // echo $form->field($model, 'attribute_3') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
