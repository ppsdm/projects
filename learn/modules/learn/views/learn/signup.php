<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;

use app\assets\AppAsset;
use app\assets\MomentAsset;
use yii\helpers\Url;

AppAsset::register($this);

MomentAsset::register($this);


$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">


    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to signup:</p>

    <div class="row">


        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'first_name') ?>
                                <?= $form->field($model, 'last_name') ?>
<?php
                                echo $form->field($model, 'gender')->dropdownList(['male'=>'male', 'female'=>'female'],['prompt'=>'Select Category']
);


    echo $form->field($model, 'birthdate')->widget(DatePicker::classname(), [
    //'language' => 'ru',
    'dateFormat' => 'yyyy-MM-dd',
    'options' =>['class'=>'form-control'],
]);

//echo $form->field($model, 'current_ed_level')->dropdownList(['smaxiiipa'=>'SMA XII IPA', 'smaxiiips'=>'SMA XII IPS'],['prompt'=>'Select Category'])->label('Education Level');

?>



                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <div class="form-group">
                    <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>