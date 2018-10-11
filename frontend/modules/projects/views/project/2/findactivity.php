<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\modules\projects\models\ProjectActivity;
use app\modules\profile\models\Profile;
use app\modules\projects\models\AssessmentReport;
use app\modules\projects\models\ProjectActivityMeta;
use kartik\form\ActiveForm;


/* @var $this yii\web\View */
/* @var $searchModel vendor\gamantha\pao\project\models\ActivitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Activities');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activity-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


<?php Pjax::begin(); ?> 
<div class="project-assessment-result-form">

    <?php $form = ActiveForm::begin(); ?>

        <?= Html::textInput('assessorname', ''); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php Pjax::end(); ?></div>
