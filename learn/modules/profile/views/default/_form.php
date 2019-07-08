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
    <?php

//EDULABID ONLY SHOWN IF VALID EDULABID and not just candidate-id

    $edulabidmodel = ProfileExtended::find()->andWhere(['user_id' => Yii::$app->user->id])->andWhere(['type'=>'edulab'])->andWhere(['key' => 'id'])->One();
       $candidateedulabidmodel = ProfileExtended::find()->andWhere(['user_id' => Yii::$app->user->id])->andWhere(['type'=>'edulab'])->andWhere(['key' => 'candidate_id'])->One();
if (null !== $edulabidmodel) {
//echo Html::label('Edulab ID', 'edulabid', ['class' => 'label edulabid']);
    echo 'edulab id';
echo Html::input('text', 'edulabid', $edulabidmodel->value, ['class' => 'form-control', 'readonly' => true]);
} else {
    if (null !== $candidateedulabidmodel) {
echo Html::input('text', 'edulabid', 'your edulab id is pending review', ['class' => 'form-control', 'readonly' => true]);
    }else{
            echo "
                  <div class='well'>
            if you are edulab member click" . Html::a(' Here ', ['/edulab/edulab/submitedulabid'], ['class' => 'profile-link']) . "to register your edulabID
        </div>";
    }

}




    ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'birthdate')->textInput() ?>

    <?= $form->field($model, 'gender')->dropdownList(['male'=>'male', 'female'=>'female'],['prompt'=>'Select Category']) ?>

<?php echo Html::img('@web/uploads/' . Yii::$app->user->id . '_' . $avatarmodel->value);


    //echo $form->field($avatarmodel, 'value')->textInput();



echo $form->field($imageuploadmodel, 'imageFile')->fileInput();

  //  echo $form->field($modelext, 'value')->label('Jenjang')->dropdownList(['smaxiiipa'=>'sma xii IPA','smaxiiips'=>'sma xii IPS'],['prompt'=>'Select Category']);

    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>



</div>
