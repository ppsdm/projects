<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Organization;
use app\modules\admin\models\OrganizationAdminuser;
use app\modules\cats\models\JobCandidate;
use common\modules\profile\models\ProfileGeneral;
use yii\helpers\Url;
use yii\jui\DatePicker;
use yii\helpers\ArrayHelper;

use dosamigos\ckeditor\CKEditor;
use dosamigos\ckeditor\CKEditorInline;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;


echo $model->description;

    //  echo Html::a(Yii::t('app', 'Apply job'), ['/admin/jobs/create'], ['class' => 'btn btn-primary']);

echo '<hr/><hr/>';

?>
