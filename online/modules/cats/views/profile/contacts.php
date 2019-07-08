<?php

use yii\helpers\Html;
use kartik\sidenav\SideNav;

use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\modules\profile\models\ProfileGeneral */

$this->title = Yii::t('app', 'Contacts');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Profile Generals'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


    <p>

        <?= Html::a(Yii::t('app', 'Contacts'), ['/cats/profile/contacts'], ['class' => 'btn btn-info']) ?>


    </p>
    


<div class="profile-general-update">


    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>






<?php


    echo 'email<br/>';
    echo Html::input('text','email',$email,['readonly' => true, 'class'=>'form-control']);
        echo 'mobile<br/>';
        echo Html::input('text','mobile',$mobile,['class'=>'form-control']);
            echo 'home<br/>';
            echo Html::input('text','home',$home,['class'=>'form-control']);
                echo 'work<br/>';
                echo Html::input('text','work',$work,['class'=>'form-control']);
                echo 'home adress<br/>';
                echo Html::input('text','home_address',$home_address,['class'=>'form-control']);
                echo 'work address<br/>';
                echo Html::input('text','work_address',$work_address,['class'=>'form-control']);

?>
    <div class="form-group">
        <?= Html::submitButton( Yii::t('app', 'Update'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>


</div>
