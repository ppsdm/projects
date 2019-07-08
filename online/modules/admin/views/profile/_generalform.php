<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\profile\models\ProfileExtended;
use app\modules\profile\models\ProfileGeneral;
use app\models\ImageUpload;
use kartik\sidenav\SideNav;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\modules\profile\models\ProfileGeneral */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="profile-general-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'user_id')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'first_name')->textInput(['readonly' => true,'maxlength' => true]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true,'readonly' => true]) ?>

    <?= $form->field($model, 'birthdate')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'gender')->dropdownList(['male'=>'male', 'female'=>'female'],['prompt'=>'Select Category','readonly' => true]) ?>

<?php echo Html::img('@web/uploads/' . Yii::$app->user->id . '_' . $avatarmodel->value);
    ?>


    <?php ActiveForm::end(); ?>



</div>
