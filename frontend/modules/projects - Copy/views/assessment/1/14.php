<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

use yii\web\View;
use app\assets\AppAsset;
use yii\helpers\ArrayHelper;

use app\modules\projects\models\Project;
use app\modules\projects\models\ProjectMeta;
use app\modules\projects\models\ProjectActivity;
use app\modules\projects\models\ProjectAssessmentResult;
use app\modules\projects\models\ProjectAssessment;
use app\modules\projects\models\ProjectActivityMeta;
use common\modules\profile\models\ProfileMeta;
use common\modules\profile\models\Profile;
use common\modules\catalog\models\RefAssessmentDictionary;
use common\modules\catalog\models\CatalogMeta;
use common\modules\catalog\models\Catalog;
use app\modules\projects\models\AssessmentReport;
use app\modules\projects\models\Kompetensigram;

use kartik\grid\GridView;
use kartik\form\ActiveForm;

use yii\widgets\ListView;
use kartik\editable\Editable;
use vova07\imperavi\Widget as Redactor;



echo $this->render('_project_report_template', [


            //'dataProvider' => $dataProvider,
            'kompetensiDataProvider' => $kompetensiDataProvider,
            'kompetensiSQLDataProvider' => $kompetensiSQLDataProvider,
            'psikogramDataProvider' => $psikogramDataProvider,
            'psikogramSQLDataProvider' => $psikogramSQLDataProvider,
            'psikogramSearchModel' => $psikogramSearchModel,
            'kompetensigramSearchModel' => $kompetensigramSearchModel,
            'catalog_id' => $catalog_id,
            'viewFile' => $this->context->view->viewFile,
            'assessment_report' => $assessment_report,
            'form' => $form,
            'readonly' => $readonly,]
  );

  ?>