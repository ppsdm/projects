<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Organization;
use app\modules\admin\models\OrganizationAdminuser;
use yii\helpers\Url;
use yii\jui\DatePicker;
use yii\helpers\ArrayHelper;




?>
<div class="profile-general-create">

    <h1><?= Html::encode($this->title) ?></h1>


<div class="profile-general-form">

    <?php $form = ActiveForm::begin(); ?>


    <?php


    //$form->field($model, 'user_id')->textInput();
echo     $form->field($model, 'type')->textInput(['readonly' => true]);
echo     $form->field($model, 'candidate_id')->textInput(['readonly' => true]);
echo     $form->field($model, 'admin_id')->textInput(['readonly' => true]);
//echo     $form->field($model, 'datetime')->textInput(['readonly' => true]);


echo     $form->field($model, 'value')->textInput(['readonly' => false]);

    ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?> 

</div>


</div>
