<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\profile\models\ProfileGeneral */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="profile-general-form">

    <?php $form = ActiveForm::begin(); ?>


    <?php

			//echo     $form->field($model, 'username')->textInput();
    //$form->field($model, 'user_id')->textInput();



echo Html::textInput('bonus','50');
echo Html::textInput('xxx1','sample');
echo Html::textInput('xxx2','sample');
echo Html::textInput('xxx3','sample');



    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
