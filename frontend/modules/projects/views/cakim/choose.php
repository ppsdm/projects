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
/* @var $model vendor\gamantha\pao\project\models\Activity */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="activity-form">

    <?php $form = ActiveForm::begin(); ?>


<?php

//$countries=Country::find()->all();
$loc_model = ProjectActivityMeta::find()->andWhere(['key' => 'place'])->andWhere(['project_activity_id' =>$_GET['id']])->One();

$location = $loc_model->value;
$assessor_list_area = ProfileMeta::find()->andWhere(['type' => 'cakim'])->andWhere(['key' => 'location'])->andWhere(['value' => $location])->asArray()->All();
$assessor_list_area2 = ArrayHelper::getColumn($assessor_list_area, 'profile_id');

$assessor_list_area_2 = Profile::find()->andWhere(['in', 'id', $assessor_list_area2])->All();
//use yii\helpers\ArrayHelper;
$listData=ArrayHelper::map($assessor_list_area_2,'id','first_name');
//$listData = ['ret' => 'ret', 'bu'=>'bapak'];

echo $form->field($assessor_model, 'value')->dropDownList(
								$listData, 
								['prompt'=>'Select...']);


//echo $form->field($assessor_model, 'value')->textInput();

?>


    <div class="form-group">
        <?= Html::submitButton($assessor_model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $assessor_model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
