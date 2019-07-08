<?php

use yii\helpers\Html;
use kartik\sidenav\SideNav;


/* @var $this yii\web\View */
/* @var $model app\modules\profile\models\ProfileGeneral */

$this->title = Yii::t('app', 'Education');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Profile Generals'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


    <p>
        <?= Html::a(Yii::t('app', 'Education'), ['/cats/profile/education'], ['class' => 'btn btn-info']) ?>
        <?= Html::a(Yii::t('app', 'Contacts'), ['/cats/profile/contacts'], ['class' => 'btn btn-info']) ?>
        <?= Html::a(Yii::t('app', 'Work'), ['/cats/profile/work'], ['class' => 'btn btn-info']) ?>

    </p>
    


<div class="profile-general-update">


    <h1><?= Html::encode($this->title) ?></h1>
<?php

    echo Html::input('text','email',$email,['class'=>'form-control']);
        echo Html::input('text','mobile phone',$mobile_phone,['class'=>'form-control']);
            echo Html::input('text','home phone',$home_phone,['class'=>'form-control']);
                echo Html::input('text','work phone',$work_phone,['class'=>'form-control']);

?>
</div>
