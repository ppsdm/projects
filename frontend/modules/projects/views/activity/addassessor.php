<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;
//use kartik\detail\DetailView;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;

use kartik\widgets\DatePicker;


use yii\web\View;
use app\assets\AppAsset;
use common\modules\core\models\RefValue;
use app\modules\projects\models\Project;
use app\modules\projects\models\ProjectMeta;
use app\modules\projects\models\ProjectActivity;
use app\modules\projects\models\AssessmentReport;
use app\modules\projects\models\ProjectActivityMeta;
use app\modules\projects\models\ProjectAssessment;
use app\modules\projects\models\ProjectAssessmentResult;
use common\modules\profile\models\ProfileMeta;
use common\modules\profile\models\Profile;
use common\modules\catalog\models\RefAssessmentDictionary;
use common\modules\catalog\models\Catalog;
use common\modules\catalog\models\CatalogMeta;

use kartik\grid\GridView;
use machour\yii2\notifications\widgets\NotificationsWidget;
use common\modules\core\models\Notification;
use kartik\editable\Editable;
use yii2tech\html2pdf\Manager;

/* @var $this yii\web\View */
/* @var $model app\modules\projects\models\Activity */


?>
<div class="activity-form">

    <?php $form = ActiveForm::begin(); 

$project_activity_model = ProjectActivity::findOne($_GET['id']);
$assessor_list = ProfileMeta::find()->andWhere(['type' => 'project-role'])->andWhere(['value' => 'assessor'])
->andWhere(['<>', 'profile_id', '2'])
->andWhere(['key' => $project_activity_model->project_id])->asArray()->All();

$ids = ArrayHelper::getColumn($assessor_list, 'profile_id');

$assessor_profiles = Profile::find()->andWhere(['in', 'id', $ids])->All();

$listData=ArrayHelper::map($assessor_profiles,'id','first_name');

//echo '<pre>';
//print_r($listData);
/*
$countries=Country::find()->all();

//use yii\helpers\ArrayHelper;
$listData=ArrayHelper::map($countries,'code','name');

echo $form->field($model, 'name')->dropDownList(
								$listData, 
								['prompt'=>'Select...']);
*/





 echo $form->field($assessor_model, 'value')->dropDownList(
								$listData, 
								['prompt'=>'Select...']);

								?>


    <div class="form-group">
        <?= Html::submitButton($assessor_model->isNewRecord ? Yii::t('app', 'Update') : Yii::t('app', 'Update'), ['class' => $assessor_model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
