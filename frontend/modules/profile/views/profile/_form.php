<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\profile\models\Profile */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="profile-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'birthdate')->textInput() ?>

    <?= $form->field($model, 'gender')->textInput(['maxlength' => true]) ?>



    <?php

    foreach ($metas as $meta_key => $meta_values) {
        echo '<hr/><h1>';
        echo Html::label($meta_key);
        echo '</h1>';
        if ($meta_key=='education'){
            foreach ($meta_values as $mv_key => $mv_value) {            
                echo Html::label($mv_key);
                echo Html::input('text',':'. $meta_key . ':' . $mv_key,$mv_value['institution'],['class'=>'form-control']);           
                echo Html::input('text',':'. $meta_key . ':' . $mv_key,$mv_value['year'],['class'=>'form-control','placeholder' => 'year']);           

      } 
        } else{

            foreach ($meta_values as $mv_key => $mv_value) {            
                      echo Html::label($mv_key);
                      echo Html::input('text',':'. $meta_key . ':' . $mv_key,$mv_value,['class'=>'form-control']);           
            }   
        } 
    }



    /*if (null !== $is_assessor) {
        echo Html::label('Nomer Izin Praktek');
        echo Html::input('text',':assessor:nip',$mv_value,['class'=>'form-control']);
    } else {

    }
    */

    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
