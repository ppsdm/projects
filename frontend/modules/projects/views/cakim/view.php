<?php

use yii\helpers\Html;
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

$this->title = $model->name;


    $proj_act = ProjectActivity::findOne($_GET['id']);
  //echo $proj_act->project_id;      
        echo $this->render('/assessment/'.$proj_act->project_id.'/view', [
                'model' => $model,
               // 'searchModel' => $searchModel,

                'psikogramSearchModel' => $psikogramSearchModel,
                'kompetensigramSearchModel' => $kompetensigramSearchModel,
                'kompetensiSQLDataProvider' => $kompetensiSQLDataProvider,
                'kompetensiDataProvider' => $kompetensiDataProvider,

                'psikogramDataProvider' => $psikogramDataProvider,
                //'psikogramDataProvider' => $psikogramSQLDataProvider,
                'psikogramSQLDataProvider' => $psikogramSQLDataProvider,
              //  'assessment_report' => $assessment_report,
                'catalog_metas' => $catalog_metas,
                'data' => $data,
        ]);


?>