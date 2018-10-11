<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\projects\models\ProjectAssessmentResult */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-assessment-result-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'project_assessment_id')->textInput() ?>

    <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'key')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'textvalue')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'attribute_1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'attribute_2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'attribute_3')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
