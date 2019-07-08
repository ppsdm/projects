<?php

use yii\helpers\Html;
use kartik\sidenav\SideNav;


/* @var $this yii\web\View */
/* @var $model app\modules\profile\models\ProfileGeneral */

$this->title = Yii::t('app', 'Profile');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Profile Generals'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


    <p>

        <?= Html::a(Yii::t('app', 'Contacts'), ['/admin/profile/contacts', 'id' => $model->user_id], ['class' => 'btn btn-info']) ?>


    </p>
    


<div class="profile-general-update">


    <h1><?= Html::encode($this->title) ?></h1>


    <?= $this->render('_generalform', [
        'model' => $model,
       // 'modelext' => $modelext,
                'imageuploadmodel' => $imageuploadmodel,
                     'avatarmodel' => $avatarmodel,
    ]) ?>

</div>
