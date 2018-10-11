<?php

namespace app\modules\projects\controllers;

use Yii;
use app\modules\projects\models\ProjectActivity;
use app\modules\projects\models\CakimMaster;
use app\modules\projects\models\ProjectActivityMeta;
use app\modules\projects\models\ProjectActivitySearch;
use app\modules\projects\models\Project;
use app\modules\profile\models\Profile;
use app\modules\profile\models\ProfileMeta;
use app\modules\projects\models\ProjectMeta;
use app\modules\projects\models\ProjectAssessment;
use app\modules\projects\models\ProjectAssessmentResult;
use app\modules\projects\models\ProjectAssessmentResultSearch;

use app\modules\projects\models\ProjectResultSnapshot;
use app\modules\projects\models\ProjectResultSnapshotMeta;
use app\modules\projects\models\Kompetensigram;
use app\modules\projects\models\AssessmentReport;
use app\modules\projects\models\ProjectAssessmentMeta;
use common\modules\catalog\models\RefAssessmentDictionary;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\mpdf\Pdf;
use kartik\grid\EditableColumnAction;
use yii\helpers\ArrayHelper;

use common\modules\catalog\models\Catalog;
use common\modules\catalog\models\CatalogMeta;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\db\Expression;
use common\modules\core\models\Log;

use yii\validators\EmailValidator;
use yii\validators\StringValidator;
use yii\helpers\Html;
use yii2tech\html2pdf\Manager;
use yii\data\SqlDataProvider;




class CakimController extends \yii\web\Controller
{


    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionDebug($id)
    {
    	return $this->render('debug');
    }

    public function actionPrintreport($id)
    {

    }

    public function actionChoose($id)
    {
        $assessor_model = ProjectActivityMeta::find()->andWhere(['project_activity_id' => $id])->andWhere(['key' => 'assessor'])
        ->andWhere(['<>','value','2'])->One();
        if (null !== $assessor_model)
        {

        } else {
            $assessor_model = new ProjectActivityMeta;
            $assessor_model->key = 'assessor';
            $assessor_model->type = 'general';
            $assessor_model->project_activity_id = $id;
        }

        if(isset($_POST['ProjectActivityMeta']['value'])){
            $assessor_model->value = $_POST['ProjectActivityMeta']['value'];
            $assessor_model->save();

          Yii::$app->session->addFlash('success', 'assessor changed');
              return $this->redirect(['project/dashboard', 'id' => '2']);

        }


    return $this->render('choose',
        [
        'assessor_model' => $assessor_model,
            ]);
    }

    public function actionProcess($id)
    {
        echo 'process';
    }

    public function actionPrintblankreport($id)
    {
    	
    }

    public function actionPrintdisc($id)
    {

    }

    public function actionPrintprestatif($id)
    {

    }



   public function actionView($id)
    {


        $data = [];
        //$model = $this->findModel($id);
        $model = ProjectActivity::findOne($id);

        $profi = Profile::find()->andWhere(['user_id' => Yii::$app->user->id])->One();
        $is_assessor = ProjectActivityMeta::find()
        ->andWhere(['project_activity_id' => $id])
        ->andWhere(['type' => 'general'])
        //->andWhere(['key' => 'assessor'])
        ->andWhere(['value' => $profi->id])->One();
        if (null !== $is_assessor) {


        $model2 = new ProjectActivity;
                $uraian_model = new ProjectAssessmentResult;



        //SATU PROJECT SATU ASSESSMENT MODEL
        $project_assessment_model = ProjectAssessment::find()
                                        ->andWhere(['activity_id' => $id])
                                        ->andWhere(['status' => 'active'])
                                        ->One();


        $catalog = $project_assessment_model->catalog_id;

        
        $catalog_metas = CatalogMeta::find()->andWhere(['catalog_id' => $catalog])
        ->orderBy(['type'=>SORT_ASC, 'attribute_3'=>SORT_ASC])->All();


            foreach ($catalog_metas as $cm_key => $cm_value) {
                if ($cm_value['type'] == 'kompetensigram'){
                    $newdata = new ProjectAssessmentResult;
                    $newdata->project_assessment_id = $project_assessment_model->id;
                    $newdata->type = 'type';
                    $newdata->key = 'key';
                    array_push($data, $newdata);
                }
            }

            $query = Kompetensigram::find()->andWhere(['project_assessment_id' => $project_assessment_model->id])
                    ->andWhere(['type' => 'kompetensigram']);

                $dataProvider = new ActiveDataProvider([
                    'query' => $query,
                    'pagination' => [
                        'pageSize' => 30,
                    ],
                    'sort' => [
                        //'attributes' => ['id', 'name'],
                    ],
                ]);

$kompetensiDataProvider = $dataProvider;
          if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
              Yii::$app->response->format = Response::FORMAT_JSON;
              return ActiveForm::validate($model);
          }


$psikogramSearchModel = new ProjectAssessmentResultSearch();
$psikogram_params = Yii::$app->request->queryParams;

          $psikogramDataProvider = $psikogramSearchModel->search($psikogram_params);
$psikogramDataProvider->query->andWhere(['project_assessment_id' => $project_assessment_model->id])
                    ->andWhere(['project_assessment_result.type' => 'psikogram']);

$kompetensigramSearchModel = new ProjectAssessmentResultSearch();
$kompetensigram_params = Yii::$app->request->queryParams;
          $kompetensigramDataProvider = $kompetensigramSearchModel->search($kompetensigram_params);
$kompetensigramDataProvider->query->andWhere(['project_assessment_id' => $project_assessment_model->id])
                    ->andWhere(['project_assessment_result.type' => 'kompetensigram']);


$kompetensiSQLDataProvider = new SqlDataProvider([
    'sql' => 'select * from (select table1.id,table1.project_assessment_id, 
  table1.type,table1.key,table1.value,table1.attribute_1,table1.attribute_2,table1.attribute_3,
   table1.catalog_id, CAST(catalog_meta.attribute_3 AS UNSIGNED) as ordering,
   catalog_meta.attribute_1 as standar
   from (SELECT project_assessment_result.id, project_assessment_result.project_assessment_id, 
    project_assessment_result.type, project_assessment_result.key, project_assessment_result.value, 
    project_assessment_result.attribute_1, project_assessment_result.attribute_2, 
    project_assessment_result.attribute_3, project_assessment.catalog_id FROM `project_assessment_result`
     join project_assessment on project_assessment_result.project_assessment_id = project_assessment.id 
     where project_assessment_result.project_assessment_id = :project_assessment_id  AND project_assessment_result.type ="kompetensigram") as table1 
join catalog_meta 
on 
table1.catalog_id = catalog_meta.catalog_id 
and table1.type = catalog_meta.type 
and table1.key = catalog_meta.value) as table2 ORDER BY table2.type, table2.ordering',
    'params' => [':project_assessment_id' => $project_assessment_model->id],
    //'totalCount' => $count,
    'sort' => [
        'attributes' => [
           // 'age',
            /*'name' => [
                'asc' => ['first_name' => SORT_ASC, 'last_name' => SORT_ASC],
                'desc' => ['first_name' => SORT_DESC, 'last_name' => SORT_DESC],
                'default' => SORT_DESC,
                'label' => 'Name',
            ],
            */
        ],
    ],
    'pagination' => [
        'pageSize' => 20,
    ],
]);


$psikogramSQLDataProvider = new SqlDataProvider([
    'sql' => 'select * from (select table1.id,table1.project_assessment_id, 
  table1.type,table1.key,table1.value,table1.attribute_1,table1.attribute_2,table1.attribute_3,
   table1.catalog_id, CAST(catalog_meta.attribute_3 AS UNSIGNED) as ordering,
   catalog_meta.attribute_1 as standar
   from (SELECT project_assessment_result.id, project_assessment_result.project_assessment_id, 
    project_assessment_result.type, project_assessment_result.key, project_assessment_result.value, 
    project_assessment_result.attribute_1, project_assessment_result.attribute_2, 
    project_assessment_result.attribute_3, project_assessment.catalog_id FROM `project_assessment_result`
     join project_assessment on project_assessment_result.project_assessment_id = project_assessment.id 
     where project_assessment_result.project_assessment_id = :project_assessment_id  AND project_assessment_result.type ="psikogram") as table1 
join catalog_meta 
on 
table1.catalog_id = catalog_meta.catalog_id 
and table1.type = catalog_meta.type 
and table1.key = catalog_meta.value) as table2 ORDER BY table2.type, table2.ordering',
    'params' => [':project_assessment_id' => $project_assessment_model->id],
    //'totalCount' => $count,
    'sort' => [
        'attributes' => [
           // 'age',
            /*'name' => [
                'asc' => ['first_name' => SORT_ASC, 'last_name' => SORT_ASC],
                'desc' => ['first_name' => SORT_DESC, 'last_name' => SORT_DESC],
                'default' => SORT_DESC,
                'label' => 'Name',
            ],
            */
        ],
    ],
    'pagination' => [
        'pageSize' => 20,
    ],
]);



    if (isset($_POST['hasEditable'])) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if ($model2->load($_POST)) {
            // read or convert your posted information
            $value = $model2->name;
            
            // return JSON encoded output in the below format
            return ['output'=>$value, 'message'=>json_encode($_POST). 'save success'];
            
            // alternatively you can return a validation error
            // return ['output'=>'', 'message'=>'Validation error'];
        }
        // else if nothing to do always return an empty JSON encoded output
        else {
            return ['output'=>'', 'message'=>''];
        }
        

} else {


            return $this->render('view', [
                'model' => $model,
               // 'searchModel' => $searchModel,
                //'project_id' => $project_activity_model->project_id,
                'psikogramSearchModel' => $psikogramSearchModel,
                'kompetensigramSearchModel' => $kompetensigramSearchModel,
                'kompetensiSQLDataProvider' => $kompetensiSQLDataProvider,
                'kompetensiDataProvider' => $kompetensigramDataProvider,

                'psikogramDataProvider' => $psikogramDataProvider,
                //'psikogramDataProvider' => $psikogramSQLDataProvider,
                'psikogramSQLDataProvider' => $psikogramSQLDataProvider,
              //  'assessment_report' => $assessment_report,
                'catalog_metas' => $catalog_metas,
                'data' => $data,
            ]);


$result_object['kompetensigram'] = [];
$result_object['psikogram'] = [];
$result_object['profile'] = [];


$usia_object = ProjectAssessmentResult::find()
->andWhere(['project_assessment_id' => $Pa->id])
->andWhere(['type' => 'cakim'])->andWhere(['key' => 'usia']);
if (null !== $usia_object) {
    $usia = $usia_object->value;
} else {
    $usia = '--no usia--';
}
$Pa = ProjectAssessment::find()->andWhere(['activity_id'=> $_GET['id']])->One();
   
   $PArp = ProjectAssessmentResult::find()->andWhere(['type'=>'psikogram'])->andWhere(['project_assessment_id'=>$Pa->id])->Sum('value');
   $PArk = ProjectAssessmentResult::find()->andWhere(['type'=>'kompetensigram'])->andWhere(['project_assessment_id'=>$Pa->id])->Sum('value');

   $sumC =     CatalogMeta::find()->andWhere(['catalog_id'=>$Pa->catalog_id])->andWhere(['type'=>'kompetensigram'])->andWhere(['key'=>'kompetensi'])->Sum('attribute_1');

$result_object['Pa'] = $Pa;
$result_object['PArp'] = $PArp;
$result_object['PArk'] = $PArk;
$result_object['sumC'] = $sumC;


//$result_object['executive_summary'] = $assessment_report->executive_summary;

//$kompetensigram_models = $kompetensiSQLDataProvider->getModels();
//$psikogram_models = $psikogramSQLDataProvider->getModels();


$kompetensigram_models = $kompetensiSQLDataProvider->getModels();
$psikogram_models = $psikogramSQLDataProvider->getModels();



foreach ($kompetensigram_models as $kompkey => $kompvalue) {
    $result_object['kompetensigram'][$kompvalue['key']]['lki'] = isset($kompvalue['value']) ? $kompvalue['value'] : '0';
    $x = CatalogMeta::find()->andWhere(['type' => 'kompetensigram'])->andWhere(['key' => 'kompetensi'])
    ->andWhere(['value' => $kompvalue['key']])->One();
$result_object['kompetensigram'][$kompvalue['key']]['lkj'] = $x->attribute_1;
}

foreach ($psikogram_models as $psikey => $psivalue) {

  //echo json_encode($psivalue);
  //echo '<br/>';
    $result_object['psikogram'][$psivalue['key']]['lki'] = isset($psivalue['value']) ? $psivalue['value'] : '0';
    $y = CatalogMeta::find()->andWhere(['type' => 'psikogram'])->andWhere(['key' => 'aspek'])
    ->andWhere(['value' => $psivalue['key']])->One();
$result_object['psikogram'][$psivalue['key']]['lkj'] = $y->attribute_1;
$refdict = RefAssessmentDictionary::find()->andWhere(['type' => 'psikogram'])->andWhere(['key' => 'aspek'])
->andWhere(['value' => $psivalue['key']])->One();
$result_object['psikogram'][$psivalue['key']]['attribute_1'] = $refdict->attribute_1;
$result_object['psikogram'][$psivalue['key']]['attribute_2'] = $refdict->attribute_2;

}

//echo '<pre>';
//print_r($result_object);

//print_r($psikogram_models);


        }
    } else {

      echo 'not allowed';
     }

  }
    public function actionSave($id)
    {


        $project_activity_model = ProjectActivity::findOne($id);
        $assessee_model = ProjectActivityMeta::find()->andWhere(['project_activity_id' => $id])
                            ->andWhere(['type' => 'general'])
                            ->andWhere(['key' => 'assessee'])
                            ->One();

        $profile_assessee_model = Profile::findOne($assessee_model->value);
        $profile_id = $profile_assessee_model->id;
        $reg_no_model = ProjectActivityMeta::find()->andWhere(['project_activity_id' => $id])
                            ->andWhere(['type' => 'general'])
                            ->andWhere(['key' => 'reg_no'])
                            ->One();

/*
        if(!isset($reg_no_model)) {
            $reg_no_model = new ProjectActivityMeta;
            $reg_no_model->project_activity_id = $id;
            $reg_no_model->type = 'general';
            $reg_no_model->key = 'reg_no';
        }
        $reg_no_model->value = $_POST['reg_no'];
        $reg_no_model->save();

        */

		
		        $birthplace_model = ProfileMeta::find()->andWhere(['profile_id' => $profile_id])
                            ->andWhere(['type' => 'personal'])
                            ->andWhere(['key' => 'birthplace'])
                            ->One();
        if(!isset($birthplace_model)) {
            $birthplace_model = new ProfileMeta;
            $birthplace_model->profile_id = $profile_id;
            $birthplace_model->type = 'personal';
            $birthplace_model->key = 'birthplace';
			
        }
        $birthplace_model->value = $_POST['birthplace'];
        $birthplace_model->save();

        $current_job_model = ProfileMeta::find()->andWhere(['profile_id' => $profile_id])
                            ->andWhere(['type' => 'work'])
                            ->andWhere(['key' => 'current_job'])
                            ->One();
        if(!isset($current_job_model)) {
            $current_job_model = new ProfileMeta;
            $current_job_model->profile_id = $profile_id;
            $current_job_model->type = 'work';
            $current_job_model->key = 'current_job';
        }
        $current_job_model->value = $_POST['current_job'];
        $current_job_model->save();



        $job_prospect_model = ProjectActivityMeta::find()->andWhere(['project_activity_id' => $id])
                            ->andWhere(['type' => 'general'])
                            ->andWhere(['key' => 'job_prospect'])
                            ->One();
        if(!isset($job_prospect_model)) {
            $job_prospect_model = new ProjectActivityMeta;
            $job_prospect_model->project_activity_id = $id;
            $job_prospect_model->type = 'general';
            $job_prospect_model->key = 'job_prospect';
        }
        $job_prospect_model->value = $_POST['job_prospect'];
        $job_prospect_model->save();


        $latest_education_model = ProfileMeta::find()->andWhere(['profile_id' => $profile_id])
                            ->andWhere(['type' => 'education'])
                            ->andWhere(['key' => 'latest'])
                            ->One();
        if(!isset($latest_education_model)) {
            $latest_education_model = new ProfileMeta;
            $latest_education_model->profile_id = $profile_id;
            $latest_education_model->type = 'education';
            $latest_education_model->key = 'latest';
        }
        $latest_education_model->value = $_POST['latest_education'];
        $latest_education_model->save();


        $univ_model = ProfileMeta::find()->andWhere(['profile_id' => $profile_id])
                            ->andWhere(['type' => 'education'])
                            ->andWhere(['key' => 'univ'])
                            ->One();
        if(!isset($univ_model)) {
            $univ_model = new ProfileMeta;
            $univ_model->profile_id = $profile_id;
            $univ_model->type = 'education';
            $univ_model->key = 'univ';
        }
        $univ_model->value = $_POST['univ'];
        $univ_model->save();


        $schedule_place = ProjectActivityMeta::find()->andWhere(['project_activity_id' => $id])
                            ->andWhere(['type' => 'schedule'])
                            ->andWhere(['key' => 'place'])
                            ->One();
        if(!isset($schedule_place)) {
            $schedule_place = new ProjectActivityMeta;
            $schedule_place->project_activity_id = $id;
            $schedule_place->type = 'schedule';
            $schedule_place->key = 'place';
        }
        $schedule_place->value = $_POST['schedule_place'];
        $schedule_place->save();

        $schedule_time = ProjectActivityMeta::find()->andWhere(['project_activity_id' => $id])
                            ->andWhere(['type' => 'schedule'])
                            ->andWhere(['key' => 'time'])
                            ->One();
        if(!isset($schedule_time)) {
            $schedule_time = new ProjectActivityMeta;
            $schedule_time->project_activity_id = $id;
            $schedule_time->type = 'schedule';
            $schedule_time->key = 'time';
        }
        $schedule_time->value = $_POST['schedule_time'];
        $schedule_time->save();

    $profile_assessee_model->birthdate = $_POST['birthdate'];
    $profile_assessee_model->gender = $_POST['gender'];
    $profile_assessee_model->first_name = $_POST['first_name'];
    $profile_assessee_model->save();


/**

    [kemampuan_umum] => 1
    [analisa_sintesa] => 1
    [berfikir_konseptual] => 1
    [proses_belajar] => 1
    [motivasi_prestasi] => 1
    [inisiatif] => 1
    [sistematika_kerja] => 1
    [kkk] => 1
    [integritas_diri] => 1
    [loyalitas] => 1
    [stabilitas_emosi] => 1
    [pengendalian_diri] => 1
    [fleksibilitas] => 1
    [self_confidence] => 1
    [teamwork] => 1
    [sum] => 
    [penampilan_fisik] => 1
*/

    $proj_ass = ProjectAssessment::find()->andWhere(['activity_id' => $id])->One();

        $analisa_sintesa_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'analisa_sintesa'])
                            ->One();

        if(!isset($analisa_sintesa_model)) {
            $analisa_sintesa_model = new ProjectAssessmentResult;
            $analisa_sintesa_model->project_assessment_id = $proj_ass->id;
            $analisa_sintesa_model->type = 'psikogram_cakim';
            $analisa_sintesa_model->key = 'analisa_sintesa';
        }

                $analisa_sintesa_model->value = $_POST['analisa_sintesa'];
        $analisa_sintesa_model->save();


        $kemampuan_umum_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'kemampuan_umum'])
                            ->One();

        if(!isset($kemampuan_umum_model)) {
            $kemampuan_umum_model = new ProjectAssessmentResult;
            $kemampuan_umum_model->project_assessment_id = $proj_ass->id;
            $kemampuan_umum_model->type = 'psikogram_cakim';
            $kemampuan_umum_model->key = 'kemampuan_umum';
        }

                $kemampuan_umum_model->value = $_POST['kemampuan_umum'];
        $kemampuan_umum_model->save();


        $proses_belajar_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'proses_belajar'])
                            ->One();

        if(!isset($proses_belajar_model)) {
            $proses_belajar_model = new ProjectAssessmentResult;
            $proses_belajar_model->project_assessment_id = $proj_ass->id;
            $proses_belajar_model->type = 'psikogram_cakim';
            $proses_belajar_model->key = 'proses_belajar';
        }

                $proses_belajar_model->value = $_POST['proses_belajar'];
        $proses_belajar_model->save();


        $penampilan_fisik_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'penampilan_fisik'])
                            ->One();

        if(!isset($penampilan_fisik_model)) {
            $penampilan_fisik_model = new ProjectAssessmentResult;
            $penampilan_fisik_model->project_assessment_id = $proj_ass->id;
            $penampilan_fisik_model->type = 'psikogram_cakim';
            $penampilan_fisik_model->key = 'penampilan_fisik';
        }

                $penampilan_fisik_model->value = $_POST['penampilan_fisik'];
        $penampilan_fisik_model->save();


        $fleksibilitas_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'fleksibilitas'])
                            ->One();

        if(!isset($fleksibilitas_model)) {
            $fleksibilitas_model = new ProjectAssessmentResult;
            $fleksibilitas_model->project_assessment_id = $proj_ass->id;
            $fleksibilitas_model->type = 'psikogram_cakim';
            $fleksibilitas_model->key = 'fleksibilitas';
        }

                $fleksibilitas_model->value = $_POST['fleksibilitas'];
        $fleksibilitas_model->save();

        $integritas_diri_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'integritas_diri'])
                            ->One();

        if(!isset($integritas_diri_model)) {
            $integritas_diri_model = new ProjectAssessmentResult;
            $integritas_diri_model->project_assessment_id = $proj_ass->id;
            $integritas_diri_model->type = 'psikogram_cakim';
            $integritas_diri_model->key = 'integritas_diri';
        }

                $integritas_diri_model->value = $_POST['integritas_diri'];
        $integritas_diri_model->save();


        $loyalitas_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'loyalitas'])
                            ->One();

        if(!isset($loyalitas_model)) {
            $loyalitas_model = new ProjectAssessmentResult;
            $loyalitas_model->project_assessment_id = $proj_ass->id;
            $loyalitas_model->type = 'psikogram_cakim';
            $loyalitas_model->key = 'loyalitas';
        }

                $loyalitas_model->value = $_POST['loyalitas'];
        $loyalitas_model->save();


        $pengendalian_diri_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'pengendalian_diri'])
                            ->One();

        if(!isset($pengendalian_diri_model)) {
            $pengendalian_diri_model = new ProjectAssessmentResult;
            $pengendalian_diri_model->project_assessment_id = $proj_ass->id;
            $pengendalian_diri_model->type = 'psikogram_cakim';
            $pengendalian_diri_model->key = 'pengendalian_diri';
        }

                $pengendalian_diri_model->value = $_POST['pengendalian_diri'];
        $pengendalian_diri_model->save();

        $self_confidence_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'self_confidence'])
                            ->One();

        if(!isset($self_confidence_model)) {
            $self_confidence_model = new ProjectAssessmentResult;
            $self_confidence_model->project_assessment_id = $proj_ass->id;
            $self_confidence_model->type = 'psikogram_cakim';
            $self_confidence_model->key = 'self_confidence';
        }

                $self_confidence_model->value = $_POST['self_confidence'];
        $self_confidence_model->save();

        $stabilitas_emosi_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'stabilitas_emosi'])
                            ->One();

        if(!isset($stabilitas_emosi_model)) {
            $stabilitas_emosi_model = new ProjectAssessmentResult;
            $stabilitas_emosi_model->project_assessment_id = $proj_ass->id;
            $stabilitas_emosi_model->type = 'psikogram_cakim';
            $stabilitas_emosi_model->key = 'stabilitas_emosi';
        }

                $stabilitas_emosi_model->value = $_POST['stabilitas_emosi'];
        $stabilitas_emosi_model->save();

        $teamwork_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'teamwork'])
                            ->One();

        if(!isset($teamwork_model)) {
            $teamwork_model = new ProjectAssessmentResult;
            $teamwork_model->project_assessment_id = $proj_ass->id;
            $teamwork_model->type = 'psikogram_cakim';
            $teamwork_model->key = 'teamwork';
        }

                $teamwork_model->value = $_POST['teamwork'];
        $teamwork_model->save();


        $inisiatif_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'inisiatif'])
                            ->One();

        if(!isset($inisiatif_model)) {
            $inisiatif_model = new ProjectAssessmentResult;
            $inisiatif_model->project_assessment_id = $proj_ass->id;
            $inisiatif_model->type = 'psikogram_cakim';
            $inisiatif_model->key = 'inisiatif';
        }

                $inisiatif_model->value = $_POST['inisiatif'];
        $inisiatif_model->save();

        $kkk_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'kkk'])
                            ->One();

        if(!isset($kkk_model)) {
            $kkk_model = new ProjectAssessmentResult;
            $kkk_model->project_assessment_id = $proj_ass->id;
            $kkk_model->type = 'psikogram_cakim';
            $kkk_model->key = 'kkk';
        }

                $kkk_model->value = $_POST['kkk'];
        $kkk_model->save();

        $motivasi_prestasi_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'motivasi_prestasi'])
                            ->One();

        if(!isset($motivasi_prestasi_model)) {
            $motivasi_prestasi_model = new ProjectAssessmentResult;
            $motivasi_prestasi_model->project_assessment_id = $proj_ass->id;
            $motivasi_prestasi_model->type = 'psikogram_cakim';
            $motivasi_prestasi_model->key = 'motivasi_prestasi';
        }

                $motivasi_prestasi_model->value = $_POST['motivasi_prestasi'];
        $motivasi_prestasi_model->save();


        $sistematika_kerja_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'sistematika_kerja'])
                            ->One();

        if(!isset($sistematika_kerja_model)) {
            $sistematika_kerja_model = new ProjectAssessmentResult;
            $sistematika_kerja_model->project_assessment_id = $proj_ass->id;
            $sistematika_kerja_model->type = 'psikogram_cakim';
            $sistematika_kerja_model->key = 'sistematika_kerja';
        }

                $sistematika_kerja_model->value = $_POST['sistematika_kerja'];
        $sistematika_kerja_model->save();


        $berfikir_konseptual_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'berfikir_konseptual'])
                            ->One();

        if(!isset($berfikir_konseptual_model)) {
            $berfikir_konseptual_model = new ProjectAssessmentResult;
            $berfikir_konseptual_model->project_assessment_id = $proj_ass->id;
            $berfikir_konseptual_model->type = 'psikogram_cakim';
            $berfikir_konseptual_model->key = 'berfikir_konseptual';
        }

                $berfikir_konseptual_model->value = $_POST['berfikir_konseptual'];
        $berfikir_konseptual_model->save();


        $cakim_master = CakimMaster::find()->andWhere(['reg_no' => $_POST['reg_no']])->One();
        if (null !== $cakim_master)
        {
              $cakim_master->modified_at = new Expression('NOW()');  
        } else {
            $cakim_master = new CakimMaster;
                        $cakim_master->reg_no = $_POST['reg_no'];
                             $cakim_master->created_at = new Expression('NOW()');

        }
                    $cakim_master->inisiatif = $_POST['inisiatif'];
                    $cakim_master->sistematika_kerja = $_POST['sistematika_kerja'];
                    $cakim_master->kemampuan_umum = $_POST['kemampuan_umum'];
                    $cakim_master->kemampuan_berfikir_analisa_sintesa = $_POST['analisa_sintesa'];
                    $cakim_master->kkk = $_POST['kkk'];
                    $cakim_master->motivasi_berprestasi = $_POST['motivasi_prestasi'];
                    $cakim_master->kemampuan_berfikir_konseptual = $_POST['berfikir_konseptual'];
                    $cakim_master->integritas_diri = $_POST['integritas_diri'];
                    $cakim_master->loyalitas = $_POST['loyalitas'];
                    $cakim_master->kemampuan_proses_belajar = $_POST['proses_belajar'];
                    $cakim_master->stabilitas_emosi = $_POST['stabilitas_emosi'];
                    $cakim_master->pengendalian_diri = $_POST['pengendalian_diri'];
                    $cakim_master->fleksibilitas = $_POST['fleksibilitas'];
                    $cakim_master->self_confidence = $_POST['self_confidence'];
                    $cakim_master->teamwork = $_POST['teamwork'];
                    $cakim_master->penampilan_fisik = $_POST['penampilan_fisik'];
                    $cakim_master->total = $_POST['inisiatif'] + $_POST['sistematika_kerja'] + $_POST['kemampuan_umum'] 
                    + $_POST['analisa_sintesa'] + $_POST['kkk'] + $_POST['motivasi_prestasi'] + $_POST['berfikir_konseptual']
                    + $_POST['integritas_diri'] + $_POST['loyalitas'] + $_POST['proses_belajar'] + $_POST['stabilitas_emosi']
                    +$_POST['pengendalian_diri'] + $_POST['fleksibilitas'] + $_POST['self_confidence'] + $_POST['teamwork'];

                    $cakim_total = (int) $cakim_master->total;
                    if($_POST['penampilan_fisik'] !== 0) {


                    if ($cakim_total >= 77) {
                        $rekomendasi = 'K-1';
                    } else if (($cakim_total <= 76) &&($cakim_total >= 68))
                    {
                        $rekomendasi = 'K-2';
                    } else if (($cakim_total <= 67) &&($cakim_total >= 59))
                    {
                        $rekomendasi = 'K-3';
                    } else {
                             $rekomendasi = 'K-4';
                    }
                } else {
                     $rekomendasi = 'K-4';
                }
                    $cakim_master->rekomendasi = $rekomendasi;
                    $cakim_master->status = 'open';
                    $cakim_master->psikotes_no = $_POST['psikotes_no'];
                    $cakim_master->lokasi = $_POST['schedule_place'];
                    $cakim_master->nama = $_POST['first_name'];

        $userprofile = Profile::find()->andWhere(['user_id' => Yii::$app->user->id])->One();


                $cakim_master->assessor_id = (string) $userprofile->id;
                $cakim_master->assessor_name = $userprofile->first_name;

                    //$cakim_master->usia = $usia;
                    $cakim_master->jenis_kelamin = $_POST['gender'];
                    $cakim_master->tingkat_pendidikan = $_POST['latest_education'];
                    $cakim_master->prospek_jabatan = $_POST['job_prospect'];
                    $cakim_master->tanggal_pemeriksaan = $_POST['schedule_time'];
                    
         if($cakim_master->save())
         {
                    Yii::$app->session->addFlash('success', 'data saved');
                } else {
                            Yii::$app->session->addFlash('warning', 'master table not saved. ' . json_encode($cakim_master->errors));

                }
        echo '<pre>';
        print_r($_POST);


   

            //return $this->refresh;
            //return Yii::$app->getResponse()->refresh();
            return $this->redirect(Yii::$app->request->referrer);
            //return $this->redirect(['project/dashboard', 'id' => '2']);

        /**
            list to save
            1. regno
            2. birthplace
            3. birthdate
            4. current_job
            5. gender
            6. job_prospect
            7. latest_education
            8. univ
            9. schedule_place
            10.schedule_time



***PROFILE***
name -> first_name + last_name
tanggal_lahir           [birthdate]
gender                  [gender]
***PROFILE_META***
tempat_lahir            [personal][birthplace]


Pekerjaan               [work][current_job]
pendidikan_terakhir     [education][latest]
asal_perguruantinggi    [education][univ]


***PROJECT_ACTIVITY_META***
nomortest       [general][regno]
prospek_jabatan [general][job_prospect]
tempat_test     [schedule][place]
tanggal_test    [schedule][time]



        */

    $validate = true;

    if ($validate) {
        //Profile::find()
        //->andWhere(['profile_id' => ])

    } else {
        echo 'VALIDATION ERROR! NOT SAVED!';
    }


    }



    public function actionPdf()
    {
        return $this->renderPartial('print',[]);
    }




    public function actionClaim($id)
    {

        $is_exist = ProjectActivityMeta::find()
        ->andWhere(['project_activity_id' => $id])
        ->andWhere(['type' => 'general'])
        ->andWhere(['key' => 'assessor'])
            ->andWhere(['<>','value','2'])
        ->One();

        $userprofile = Profile::find()->andWhere(['user_id' => Yii::$app->user->id])->One();
        if(null!==$is_exist)
        {

        } else {
            $is_exist = new ProjectActivityMeta;
            $is_exist->project_activity_id = (string) $id;
            $is_exist->type = 'general';
            $is_exist->key = 'assessor';

        }

        $is_exist->value = (string) $userprofile->id;
        if($is_exist->save()){
                   Yii::$app->session->addFlash('success', 'Assessor added');
                   } else {
            print_r($is_exist->errors);
        }

                   return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }







    public function actionSubmit($id)
    {


        $project_activity_model = ProjectActivity::findOne($id);
        $assessee_model = ProjectActivityMeta::find()->andWhere(['project_activity_id' => $id])
                            ->andWhere(['type' => 'general'])
                            ->andWhere(['key' => 'assessee'])
                            ->One();

        $profile_assessee_model = Profile::findOne($assessee_model->value);
        $profile_id = $profile_assessee_model->id;
        $reg_no_model = ProjectActivityMeta::find()->andWhere(['project_activity_id' => $id])
                            ->andWhere(['type' => 'general'])
                            ->andWhere(['key' => 'reg_no'])
                            ->One();

/*
        if(!isset($reg_no_model)) {
            $reg_no_model = new ProjectActivityMeta;
            $reg_no_model->project_activity_id = $id;
            $reg_no_model->type = 'general';
            $reg_no_model->key = 'reg_no';
        }
        $reg_no_model->value = $_POST['reg_no'];
        $reg_no_model->save();

        */

        $birthplace_model = ProfileMeta::find()->andWhere(['profile_id' => $profile_id])
                            ->andWhere(['type' => 'personal'])
                            ->andWhere(['key' => 'birthplace'])
                            ->One();
        if(!isset($birthplace_model)) {
            $birthplace_model = new ProfileMeta;
            $birthplace_model->profile_id = $profile_id;
            $birthplace_model->type = 'personal';
            $birthplace_model->key = 'birthplace';
        }
        $birthplace_model->value = $_POST['birthplace'];
        $birthplace_model->save();

        $current_job_model = ProfileMeta::find()->andWhere(['profile_id' => $profile_id])
                            ->andWhere(['type' => 'work'])
                            ->andWhere(['key' => 'current_job'])
                            ->One();
        if(!isset($current_job_model)) {
            $current_job_model = new ProfileMeta;
            $current_job_model->profile_id = $profile_id;
            $current_job_model->type = 'work';
            $current_job_model->key = 'current_job';
        }
        $current_job_model->value = $_POST['current_job'];
        $current_job_model->save();



        $job_prospect_model = ProjectActivityMeta::find()->andWhere(['project_activity_id' => $id])
                            ->andWhere(['type' => 'general'])
                            ->andWhere(['key' => 'job_prospect'])
                            ->One();
        if(!isset($job_prospect_model)) {
            $job_prospect_model = new ProjectActivityMeta;
            $job_prospect_model->project_activity_id = $id;
            $job_prospect_model->type = 'general';
            $job_prospect_model->key = 'job_prospect';
        }
        $job_prospect_model->value = $_POST['job_prospect'];
        $job_prospect_model->save();


        $latest_education_model = ProfileMeta::find()->andWhere(['profile_id' => $profile_id])
                            ->andWhere(['type' => 'education'])
                            ->andWhere(['key' => 'latest'])
                            ->One();
        if(!isset($latest_education_model)) {
            $latest_education_model = new ProfileMeta;
            $latest_education_model->profile_id = $profile_id;
            $latest_education_model->type = 'education';
            $latest_education_model->key = 'latest';
        }
        $latest_education_model->value = $_POST['latest_education'];
        $latest_education_model->save();


        $univ_model = ProfileMeta::find()->andWhere(['profile_id' => $profile_id])
                            ->andWhere(['type' => 'education'])
                            ->andWhere(['key' => 'univ'])
                            ->One();
        if(!isset($univ_model)) {
            $univ_model = new ProfileMeta;
            $univ_model->profile_id = $profile_id;
            $univ_model->type = 'education';
            $univ_model->key = 'univ';
        }
        $univ_model->value = $_POST['univ'];
        $univ_model->save();


        $schedule_place = ProjectActivityMeta::find()->andWhere(['project_activity_id' => $id])
                            ->andWhere(['type' => 'schedule'])
                            ->andWhere(['key' => 'place'])
                            ->One();
        if(!isset($schedule_place)) {
            $schedule_place = new ProjectActivityMeta;
            $schedule_place->project_activity_id = $id;
            $schedule_place->type = 'schedule';
            $schedule_place->key = 'place';
        }
        $schedule_place->value = $_POST['schedule_place'];
        $schedule_place->save();

        $schedule_time = ProjectActivityMeta::find()->andWhere(['project_activity_id' => $id])
                            ->andWhere(['type' => 'schedule'])
                            ->andWhere(['key' => 'time'])
                            ->One();
        if(!isset($schedule_time)) {
            $schedule_time = new ProjectActivityMeta;
            $schedule_time->project_activity_id = $id;
            $schedule_time->type = 'schedule';
            $schedule_time->key = 'time';
        }
        $schedule_time->value = $_POST['schedule_time'];
        $schedule_time->save();

    $profile_assessee_model->birthdate = $_POST['birthdate'];
    $profile_assessee_model->gender = $_POST['gender'];
    $profile_assessee_model->first_name = $_POST['first_name'];
    $profile_assessee_model->save();


/**

    [kemampuan_umum] => 1
    [analisa_sintesa] => 1
    [berfikir_konseptual] => 1
    [proses_belajar] => 1
    [motivasi_prestasi] => 1
    [inisiatif] => 1
    [sistematika_kerja] => 1
    [kkk] => 1
    [integritas_diri] => 1
    [loyalitas] => 1
    [stabilitas_emosi] => 1
    [pengendalian_diri] => 1
    [fleksibilitas] => 1
    [self_confidence] => 1
    [teamwork] => 1
    [sum] => 
    [penampilan_fisik] => 1
*/

    $proj_ass = ProjectAssessment::find()->andWhere(['activity_id' => $id])->One();

        $analisa_sintesa_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'analisa_sintesa'])
                            ->One();

        if(!isset($analisa_sintesa_model)) {
            $analisa_sintesa_model = new ProjectAssessmentResult;
            $analisa_sintesa_model->project_assessment_id = $proj_ass->id;
            $analisa_sintesa_model->type = 'psikogram_cakim';
            $analisa_sintesa_model->key = 'analisa_sintesa';
        }

                $analisa_sintesa_model->value = $_POST['analisa_sintesa'];
        $analisa_sintesa_model->save();


        $kemampuan_umum_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'kemampuan_umum'])
                            ->One();

        if(!isset($kemampuan_umum_model)) {
            $kemampuan_umum_model = new ProjectAssessmentResult;
            $kemampuan_umum_model->project_assessment_id = $proj_ass->id;
            $kemampuan_umum_model->type = 'psikogram_cakim';
            $kemampuan_umum_model->key = 'kemampuan_umum';
        }

                $kemampuan_umum_model->value = $_POST['kemampuan_umum'];
        $kemampuan_umum_model->save();


        $proses_belajar_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'proses_belajar'])
                            ->One();

        if(!isset($proses_belajar_model)) {
            $proses_belajar_model = new ProjectAssessmentResult;
            $proses_belajar_model->project_assessment_id = $proj_ass->id;
            $proses_belajar_model->type = 'psikogram_cakim';
            $proses_belajar_model->key = 'proses_belajar';
        }

                $proses_belajar_model->value = $_POST['proses_belajar'];
        $proses_belajar_model->save();


        $penampilan_fisik_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'penampilan_fisik'])
                            ->One();

        if(!isset($penampilan_fisik_model)) {
            $penampilan_fisik_model = new ProjectAssessmentResult;
            $penampilan_fisik_model->project_assessment_id = $proj_ass->id;
            $penampilan_fisik_model->type = 'psikogram_cakim';
            $penampilan_fisik_model->key = 'penampilan_fisik';
        }

                $penampilan_fisik_model->value = $_POST['penampilan_fisik'];
        $penampilan_fisik_model->save();


        $fleksibilitas_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'fleksibilitas'])
                            ->One();

        if(!isset($fleksibilitas_model)) {
            $fleksibilitas_model = new ProjectAssessmentResult;
            $fleksibilitas_model->project_assessment_id = $proj_ass->id;
            $fleksibilitas_model->type = 'psikogram_cakim';
            $fleksibilitas_model->key = 'fleksibilitas';
        }

                $fleksibilitas_model->value = $_POST['fleksibilitas'];
        $fleksibilitas_model->save();

        $integritas_diri_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'integritas_diri'])
                            ->One();

        if(!isset($integritas_diri_model)) {
            $integritas_diri_model = new ProjectAssessmentResult;
            $integritas_diri_model->project_assessment_id = $proj_ass->id;
            $integritas_diri_model->type = 'psikogram_cakim';
            $integritas_diri_model->key = 'integritas_diri';
        }

                $integritas_diri_model->value = $_POST['integritas_diri'];
        $integritas_diri_model->save();


        $loyalitas_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'loyalitas'])
                            ->One();

        if(!isset($loyalitas_model)) {
            $loyalitas_model = new ProjectAssessmentResult;
            $loyalitas_model->project_assessment_id = $proj_ass->id;
            $loyalitas_model->type = 'psikogram_cakim';
            $loyalitas_model->key = 'loyalitas';
        }

                $loyalitas_model->value = $_POST['loyalitas'];
        $loyalitas_model->save();


        $pengendalian_diri_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'pengendalian_diri'])
                            ->One();

        if(!isset($pengendalian_diri_model)) {
            $pengendalian_diri_model = new ProjectAssessmentResult;
            $pengendalian_diri_model->project_assessment_id = $proj_ass->id;
            $pengendalian_diri_model->type = 'psikogram_cakim';
            $pengendalian_diri_model->key = 'pengendalian_diri';
        }

                $pengendalian_diri_model->value = $_POST['pengendalian_diri'];
        $pengendalian_diri_model->save();

        $self_confidence_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'self_confidence'])
                            ->One();

        if(!isset($self_confidence_model)) {
            $self_confidence_model = new ProjectAssessmentResult;
            $self_confidence_model->project_assessment_id = $proj_ass->id;
            $self_confidence_model->type = 'psikogram_cakim';
            $self_confidence_model->key = 'self_confidence';
        }

                $self_confidence_model->value = $_POST['self_confidence'];
        $self_confidence_model->save();

        $stabilitas_emosi_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'stabilitas_emosi'])
                            ->One();

        if(!isset($stabilitas_emosi_model)) {
            $stabilitas_emosi_model = new ProjectAssessmentResult;
            $stabilitas_emosi_model->project_assessment_id = $proj_ass->id;
            $stabilitas_emosi_model->type = 'psikogram_cakim';
            $stabilitas_emosi_model->key = 'stabilitas_emosi';
        }

                $stabilitas_emosi_model->value = $_POST['stabilitas_emosi'];
        $stabilitas_emosi_model->save();

        $teamwork_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'teamwork'])
                            ->One();

        if(!isset($teamwork_model)) {
            $teamwork_model = new ProjectAssessmentResult;
            $teamwork_model->project_assessment_id = $proj_ass->id;
            $teamwork_model->type = 'psikogram_cakim';
            $teamwork_model->key = 'teamwork';
        }

                $teamwork_model->value = $_POST['teamwork'];
        $teamwork_model->save();


        $inisiatif_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'inisiatif'])
                            ->One();

        if(!isset($inisiatif_model)) {
            $inisiatif_model = new ProjectAssessmentResult;
            $inisiatif_model->project_assessment_id = $proj_ass->id;
            $inisiatif_model->type = 'psikogram_cakim';
            $inisiatif_model->key = 'inisiatif';
        }

                $inisiatif_model->value = $_POST['inisiatif'];
        $inisiatif_model->save();

        $kkk_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'kkk'])
                            ->One();

        if(!isset($kkk_model)) {
            $kkk_model = new ProjectAssessmentResult;
            $kkk_model->project_assessment_id = $proj_ass->id;
            $kkk_model->type = 'psikogram_cakim';
            $kkk_model->key = 'kkk';
        }

                $kkk_model->value = $_POST['kkk'];
        $kkk_model->save();

        $motivasi_prestasi_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'motivasi_prestasi'])
                            ->One();

        if(!isset($motivasi_prestasi_model)) {
            $motivasi_prestasi_model = new ProjectAssessmentResult;
            $motivasi_prestasi_model->project_assessment_id = $proj_ass->id;
            $motivasi_prestasi_model->type = 'psikogram_cakim';
            $motivasi_prestasi_model->key = 'motivasi_prestasi';
        }

                $motivasi_prestasi_model->value = $_POST['motivasi_prestasi'];
        $motivasi_prestasi_model->save();


        $sistematika_kerja_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'sistematika_kerja'])
                            ->One();

        if(!isset($sistematika_kerja_model)) {
            $sistematika_kerja_model = new ProjectAssessmentResult;
            $sistematika_kerja_model->project_assessment_id = $proj_ass->id;
            $sistematika_kerja_model->type = 'psikogram_cakim';
            $sistematika_kerja_model->key = 'sistematika_kerja';
        }

                $sistematika_kerja_model->value = $_POST['sistematika_kerja'];
        $sistematika_kerja_model->save();


        $berfikir_konseptual_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'berfikir_konseptual'])
                            ->One();

        if(!isset($berfikir_konseptual_model)) {
            $berfikir_konseptual_model = new ProjectAssessmentResult;
            $berfikir_konseptual_model->project_assessment_id = $proj_ass->id;
            $berfikir_konseptual_model->type = 'psikogram_cakim';
            $berfikir_konseptual_model->key = 'berfikir_konseptual';
        }

                $berfikir_konseptual_model->value = $_POST['berfikir_konseptual'];
        $berfikir_konseptual_model->save();


  $cakim_master = CakimMaster::find()->andWhere(['reg_no' => $_POST['reg_no']])->One();
        if (null !== $cakim_master)
        {
                $cakim_master->modified_at = new Expression('NOW()');
        } else {
            $cakim_master = new CakimMaster;
                        $cakim_master->reg_no = $_POST['reg_no'];
                             $cakim_master->created_at = new Expression('NOW()');

        }
                    $cakim_master->inisiatif = $_POST['inisiatif'];
                    $cakim_master->sistematika_kerja = $_POST['sistematika_kerja'];
                    $cakim_master->kemampuan_umum = $_POST['kemampuan_umum'];
                    $cakim_master->kemampuan_berfikir_analisa_sintesa = $_POST['analisa_sintesa'];
                    $cakim_master->kkk = $_POST['kkk'];
                    $cakim_master->motivasi_berprestasi = $_POST['motivasi_prestasi'];
                    $cakim_master->kemampuan_berfikir_konseptual = $_POST['berfikir_konseptual'];
                    $cakim_master->integritas_diri = $_POST['integritas_diri'];
                    $cakim_master->loyalitas = $_POST['loyalitas'];
                    $cakim_master->kemampuan_proses_belajar = $_POST['proses_belajar'];
                    $cakim_master->stabilitas_emosi = $_POST['stabilitas_emosi'];
                    $cakim_master->pengendalian_diri = $_POST['pengendalian_diri'];
                    $cakim_master->fleksibilitas = $_POST['fleksibilitas'];
                    $cakim_master->self_confidence = $_POST['self_confidence'];
                    $cakim_master->teamwork = $_POST['teamwork'];
                             $cakim_master->status = 'done';
                    $cakim_master->penampilan_fisik = $_POST['penampilan_fisik'];

                    $cakim_master->total = $_POST['inisiatif'] + $_POST['sistematika_kerja'] + $_POST['kemampuan_umum'] 
                    + $_POST['analisa_sintesa'] + $_POST['kkk'] + $_POST['motivasi_prestasi'] + $_POST['berfikir_konseptual']
                    + $_POST['integritas_diri'] + $_POST['loyalitas'] + $_POST['proses_belajar'] + $_POST['stabilitas_emosi']
                    +$_POST['pengendalian_diri'] + $_POST['fleksibilitas'] + $_POST['self_confidence'] + $_POST['teamwork'];

                    $cakim_total = (int) $cakim_master->total;
                    if ($cakim_total >= 77) {
                        $rekomendasi = 'K-1';
                    } else if (($cakim_total <= 76) &&($cakim_total >= 68))
                    {
                        $rekomendasi = 'K-2';
                    } else if (($cakim_total <= 67) &&($cakim_total >= 59))
                    {
                        $rekomendasi = 'K-3';
                    } else {
                             $rekomendasi = 'K-4';
                    }
                    $cakim_master->rekomendasi = $rekomendasi;

                    $cakim_master->psikotes_no = $_POST['psikotes_no'];
                    $cakim_master->lokasi = $_POST['schedule_place'];
                    $cakim_master->nama = $_POST['first_name'];

        $userprofile = Profile::find()->andWhere(['user_id' => Yii::$app->user->id])->One();


                $cakim_master->assessor_id = (string) $userprofile->id;
                $cakim_master->assessor_name = $userprofile->first_name;

                    //$cakim_master->usia = $usia;
                    $cakim_master->jenis_kelamin = $_POST['gender'];
                    $cakim_master->tingkat_pendidikan = $_POST['latest_education'];
                    $cakim_master->prospek_jabatan = $_POST['job_prospect'];
                    $cakim_master->tanggal_pemeriksaan = $_POST['schedule_time'];
               
         if($cakim_master->save())
         {
                    Yii::$app->session->addFlash('success', 'data submitted');
                } else {
                            Yii::$app->session->addFlash('warning', 'master table not saved. ' . json_encode($cakim_master->errors));

                }

        echo '<pre>';
        print_r($_POST);

        //$this->redirect([''])
        $activity_status_model = ProjectActivityMeta::find()->andWhere(['project_activity_id' => $id])
                            ->andWhere(['type' => 'assessment'])
                            ->andWhere(['key' => 'status'])
                            ->One();

        if(!isset($activity_status_model)) {
            $activity_status_model = new ProjectActivityMeta;
            $activity_status_model->project_activity_id = $id;
            $activity_status_model->type = 'assessment';
            $activity_status_model->key = 'status';
        }


                            $activity_status_model->value = 'done';
                            $activity_status_model->save();

           Yii::$app->session->addFlash('success', 'data submitted');

            return $this->redirect(['project/dashboard', 'id' => '2']);


    $validate = true;

    if ($validate) {
        //Profile::find()
        //->andWhere(['profile_id' => ])

    } else {
        echo 'VALIDATION ERROR! NOT SAVED!';
    }


    }

	
	



    public function actionSaveprofile($id)
    {


        $project_activity_model = ProjectActivity::findOne($id);
        $assessee_model = ProjectActivityMeta::find()->andWhere(['project_activity_id' => $id])
                            ->andWhere(['type' => 'general'])
                            ->andWhere(['key' => 'assessee'])
                            ->One();

        $profile_assessee_model = Profile::findOne($assessee_model->value);
        $profile_id = $profile_assessee_model->id;
        $reg_no_model = ProjectActivityMeta::find()->andWhere(['project_activity_id' => $id])
                            ->andWhere(['type' => 'general'])
                            ->andWhere(['key' => 'reg_no'])
                            ->One();

/*
        if(!isset($reg_no_model)) {
            $reg_no_model = new ProjectActivityMeta;
            $reg_no_model->project_activity_id = $id;
            $reg_no_model->type = 'general';
            $reg_no_model->key = 'reg_no';
        }
        $reg_no_model->value = $_POST['reg_no'];
        $reg_no_model->save();

        */

        $birthplace_model = ProfileMeta::find()->andWhere(['profile_id' => $profile_id])
                            ->andWhere(['type' => 'personal'])
                            ->andWhere(['key' => 'birthplace'])
                            ->One();
        if(!isset($birthplace_model)) {
            $birthplace_model = new ProfileMeta;
            $birthplace_model->profile_id = $profile_id;
            $birthplace_model->type = 'personal';
            $birthplace_model->key = 'birthplace';
        }
        $birthplace_model->value = $_POST['birthplace'];
        $birthplace_model->save();

        $current_job_model = ProfileMeta::find()->andWhere(['profile_id' => $profile_id])
                            ->andWhere(['type' => 'work'])
                            ->andWhere(['key' => 'current_job'])
                            ->One();
        if(!isset($current_job_model)) {
            $current_job_model = new ProfileMeta;
            $current_job_model->profile_id = $profile_id;
            $current_job_model->type = 'work';
            $current_job_model->key = 'current_job';
        }
        $current_job_model->value = $_POST['current_job'];
        $current_job_model->save();



        $job_prospect_model = ProjectActivityMeta::find()->andWhere(['project_activity_id' => $id])
                            ->andWhere(['type' => 'general'])
                            ->andWhere(['key' => 'job_prospect'])
                            ->One();
        if(!isset($job_prospect_model)) {
            $job_prospect_model = new ProjectActivityMeta;
            $job_prospect_model->project_activity_id = $id;
            $job_prospect_model->type = 'general';
            $job_prospect_model->key = 'job_prospect';
        }
        $job_prospect_model->value = $_POST['job_prospect'];
        $job_prospect_model->save();


        $latest_education_model = ProfileMeta::find()->andWhere(['profile_id' => $profile_id])
                            ->andWhere(['type' => 'education'])
                            ->andWhere(['key' => 'latest'])
                            ->One();
        if(!isset($latest_education_model)) {
            $latest_education_model = new ProfileMeta;
            $latest_education_model->profile_id = $profile_id;
            $latest_education_model->type = 'education';
            $latest_education_model->key = 'latest';
        }
        $latest_education_model->value = $_POST['latest_education'];
        $latest_education_model->save();


        $univ_model = ProfileMeta::find()->andWhere(['profile_id' => $profile_id])
                            ->andWhere(['type' => 'education'])
                            ->andWhere(['key' => 'univ'])
                            ->One();
        if(!isset($univ_model)) {
            $univ_model = new ProfileMeta;
            $univ_model->profile_id = $profile_id;
            $univ_model->type = 'education';
            $univ_model->key = 'univ';
        }
        $univ_model->value = $_POST['univ'];
        $univ_model->save();


        $schedule_place = ProjectActivityMeta::find()->andWhere(['project_activity_id' => $id])
                            ->andWhere(['type' => 'schedule'])
                            ->andWhere(['key' => 'place'])
                            ->One();
        if(!isset($schedule_place)) {
            $schedule_place = new ProjectActivityMeta;
            $schedule_place->project_activity_id = $id;
            $schedule_place->type = 'schedule';
            $schedule_place->key = 'place';
        }
        $schedule_place->value = $_POST['schedule_place'];
        $schedule_place->save();

        $schedule_time = ProjectActivityMeta::find()->andWhere(['project_activity_id' => $id])
                            ->andWhere(['type' => 'schedule'])
                            ->andWhere(['key' => 'time'])
                            ->One();
        if(!isset($schedule_time)) {
            $schedule_time = new ProjectActivityMeta;
            $schedule_time->project_activity_id = $id;
            $schedule_time->type = 'schedule';
            $schedule_time->key = 'time';
        }
        $schedule_time->value = $_POST['schedule_time'];
        $schedule_time->save();

    $profile_assessee_model->birthdate = $_POST['birthdate'];
    $profile_assessee_model->gender = $_POST['gender'];
    $profile_assessee_model->first_name = $_POST['first_name'];
    $profile_assessee_model->save();





  $cakim_master = CakimMaster::find()->andWhere(['reg_no' => $_POST['reg_no']])->One();
        if (null !== $cakim_master)
        {
                $cakim_master->modified_at = new Expression('NOW()');
        } else {
            $cakim_master = new CakimMaster;
                        $cakim_master->reg_no = $_POST['reg_no'];
                             $cakim_master->created_at = new Expression('NOW()');

        }


                    $cakim_master->psikotes_no = $_POST['psikotes_no'];
                    $cakim_master->lokasi = $_POST['schedule_place'];
                    $cakim_master->nama = $_POST['first_name'];

        $userprofile = Profile::find()->andWhere(['user_id' => Yii::$app->user->id])->One();


                $cakim_master->assessor_id = (string) $userprofile->id;
                $cakim_master->assessor_name = $userprofile->first_name;

                    //$cakim_master->usia = $usia;
                    $cakim_master->jenis_kelamin = $_POST['gender'];
                    $cakim_master->tingkat_pendidikan = $_POST['latest_education'];
                    $cakim_master->prospek_jabatan = $_POST['job_prospect'];
                    $cakim_master->tanggal_pemeriksaan = $_POST['schedule_time'];
               
         if($cakim_master->save())
         {
                    Yii::$app->session->addFlash('success', 'data submitted');
                } else {
                            Yii::$app->session->addFlash('warning', 'master table not saved. ' . json_encode($cakim_master->errors));

                }

        //echo '<pre>';
        //print_r($_POST);

  
/*  //$this->redirect([''])
        $activity_status_model = ProjectActivityMeta::find()->andWhere(['project_activity_id' => $id])
                            ->andWhere(['type' => 'assessment'])
                            ->andWhere(['key' => 'status'])
                            ->One();

        if(!isset($activity_status_model)) {
            $activity_status_model = new ProjectActivityMeta;
            $activity_status_model->project_activity_id = $id;
            $activity_status_model->type = 'assessment';
            $activity_status_model->key = 'status';
        }


                            $activity_status_model->value = 'done';
                            $activity_status_model->save();
*/
           Yii::$app->session->addFlash('success', 'data submitted');

            return $this->redirect(['project/dashboard', 'id' => '2']);


    $validate = true;

    if ($validate) {
        //Profile::find()
        //->andWhere(['profile_id' => ])

    } else {
        echo 'VALIDATION ERROR! NOT SAVED!';
    }


    }



    public function actionSoreviewed($id)
    {


        $project_activity_model = ProjectActivity::findOne($id);
        $assessee_model = ProjectActivityMeta::find()->andWhere(['project_activity_id' => $id])
                            ->andWhere(['type' => 'general'])
                            ->andWhere(['key' => 'assessee'])
                            ->One();

        $profile_assessee_model = Profile::findOne($assessee_model->value);
        $profile_id = $profile_assessee_model->id;
        $reg_no_model = ProjectActivityMeta::find()->andWhere(['project_activity_id' => $id])
                            ->andWhere(['type' => 'general'])
                            ->andWhere(['key' => 'reg_no'])
                            ->One();



        $birthplace_model = ProfileMeta::find()->andWhere(['profile_id' => $profile_id])
                            ->andWhere(['type' => 'personal'])
                            ->andWhere(['key' => 'birthplace'])
                            ->One();
        if(!isset($birthplace_model)) {
            $birthplace_model = new ProfileMeta;
            $birthplace_model->profile_id = $profile_id;
            $birthplace_model->type = 'personal';
            $birthplace_model->key = 'birthplace';
        }
        $birthplace_model->value = $_POST['birthplace'];
        $birthplace_model->save();

        $current_job_model = ProfileMeta::find()->andWhere(['profile_id' => $profile_id])
                            ->andWhere(['type' => 'work'])
                            ->andWhere(['key' => 'current_job'])
                            ->One();
        if(!isset($current_job_model)) {
            $current_job_model = new ProfileMeta;
            $current_job_model->profile_id = $profile_id;
            $current_job_model->type = 'work';
            $current_job_model->key = 'current_job';
        }
        $current_job_model->value = $_POST['current_job'];
        $current_job_model->save();



        $job_prospect_model = ProjectActivityMeta::find()->andWhere(['project_activity_id' => $id])
                            ->andWhere(['type' => 'general'])
                            ->andWhere(['key' => 'job_prospect'])
                            ->One();
        if(!isset($job_prospect_model)) {
            $job_prospect_model = new ProjectActivityMeta;
            $job_prospect_model->project_activity_id = $id;
            $job_prospect_model->type = 'general';
            $job_prospect_model->key = 'job_prospect';
        }
        $job_prospect_model->value = $_POST['job_prospect'];
        $job_prospect_model->save();


        $latest_education_model = ProfileMeta::find()->andWhere(['profile_id' => $profile_id])
                            ->andWhere(['type' => 'education'])
                            ->andWhere(['key' => 'latest'])
                            ->One();
        if(!isset($latest_education_model)) {
            $latest_education_model = new ProfileMeta;
            $latest_education_model->profile_id = $profile_id;
            $latest_education_model->type = 'education';
            $latest_education_model->key = 'latest';
        }
        $latest_education_model->value = $_POST['latest_education'];
        $latest_education_model->save();


        $univ_model = ProfileMeta::find()->andWhere(['profile_id' => $profile_id])
                            ->andWhere(['type' => 'education'])
                            ->andWhere(['key' => 'univ'])
                            ->One();
        if(!isset($univ_model)) {
            $univ_model = new ProfileMeta;
            $univ_model->profile_id = $profile_id;
            $univ_model->type = 'education';
            $univ_model->key = 'univ';
        }
        $univ_model->value = $_POST['univ'];
        $univ_model->save();


        $schedule_place = ProjectActivityMeta::find()->andWhere(['project_activity_id' => $id])
                            ->andWhere(['type' => 'schedule'])
                            ->andWhere(['key' => 'place'])
                            ->One();
        if(!isset($schedule_place)) {
            $schedule_place = new ProjectActivityMeta;
            $schedule_place->project_activity_id = $id;
            $schedule_place->type = 'schedule';
            $schedule_place->key = 'place';
        }
        $schedule_place->value = $_POST['schedule_place'];
        $schedule_place->save();

        $schedule_time = ProjectActivityMeta::find()->andWhere(['project_activity_id' => $id])
                            ->andWhere(['type' => 'schedule'])
                            ->andWhere(['key' => 'time'])
                            ->One();
        if(!isset($schedule_time)) {
            $schedule_time = new ProjectActivityMeta;
            $schedule_time->project_activity_id = $id;
            $schedule_time->type = 'schedule';
            $schedule_time->key = 'time';
        }
        $schedule_time->value = $_POST['schedule_time'];
        $schedule_time->save();

    $profile_assessee_model->birthdate = $_POST['birthdate'];
    $profile_assessee_model->gender = $_POST['gender'];
    $profile_assessee_model->first_name = $_POST['first_name'];
    $profile_assessee_model->save();


/**

    [kemampuan_umum] => 1
    [analisa_sintesa] => 1
    [berfikir_konseptual] => 1
    [proses_belajar] => 1
    [motivasi_prestasi] => 1
    [inisiatif] => 1
    [sistematika_kerja] => 1
    [kkk] => 1
    [integritas_diri] => 1
    [loyalitas] => 1
    [stabilitas_emosi] => 1
    [pengendalian_diri] => 1
    [fleksibilitas] => 1
    [self_confidence] => 1
    [teamwork] => 1
    [sum] => 
    [penampilan_fisik] => 1
*/

    $proj_ass = ProjectAssessment::find()->andWhere(['activity_id' => $id])->One();

        $analisa_sintesa_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'analisa_sintesa'])
                            ->One();

        if(!isset($analisa_sintesa_model)) {
            $analisa_sintesa_model = new ProjectAssessmentResult;
            $analisa_sintesa_model->project_assessment_id = $proj_ass->id;
            $analisa_sintesa_model->type = 'psikogram_cakim';
            $analisa_sintesa_model->key = 'analisa_sintesa';
        }

                $analisa_sintesa_model->value = $_POST['analisa_sintesa'];
        $analisa_sintesa_model->save();


        $kemampuan_umum_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'kemampuan_umum'])
                            ->One();

        if(!isset($kemampuan_umum_model)) {
            $kemampuan_umum_model = new ProjectAssessmentResult;
            $kemampuan_umum_model->project_assessment_id = $proj_ass->id;
            $kemampuan_umum_model->type = 'psikogram_cakim';
            $kemampuan_umum_model->key = 'kemampuan_umum';
        }

                $kemampuan_umum_model->value = $_POST['kemampuan_umum'];
        $kemampuan_umum_model->save();


        $proses_belajar_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'proses_belajar'])
                            ->One();

        if(!isset($proses_belajar_model)) {
            $proses_belajar_model = new ProjectAssessmentResult;
            $proses_belajar_model->project_assessment_id = $proj_ass->id;
            $proses_belajar_model->type = 'psikogram_cakim';
            $proses_belajar_model->key = 'proses_belajar';
        }

                $proses_belajar_model->value = $_POST['proses_belajar'];
        $proses_belajar_model->save();


        $penampilan_fisik_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'penampilan_fisik'])
                            ->One();

        if(!isset($penampilan_fisik_model)) {
            $penampilan_fisik_model = new ProjectAssessmentResult;
            $penampilan_fisik_model->project_assessment_id = $proj_ass->id;
            $penampilan_fisik_model->type = 'psikogram_cakim';
            $penampilan_fisik_model->key = 'penampilan_fisik';
        }

                $penampilan_fisik_model->value = $_POST['penampilan_fisik'];
        $penampilan_fisik_model->save();


        $fleksibilitas_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'fleksibilitas'])
                            ->One();

        if(!isset($fleksibilitas_model)) {
            $fleksibilitas_model = new ProjectAssessmentResult;
            $fleksibilitas_model->project_assessment_id = $proj_ass->id;
            $fleksibilitas_model->type = 'psikogram_cakim';
            $fleksibilitas_model->key = 'fleksibilitas';
        }

                $fleksibilitas_model->value = $_POST['fleksibilitas'];
        $fleksibilitas_model->save();

        $integritas_diri_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'integritas_diri'])
                            ->One();

        if(!isset($integritas_diri_model)) {
            $integritas_diri_model = new ProjectAssessmentResult;
            $integritas_diri_model->project_assessment_id = $proj_ass->id;
            $integritas_diri_model->type = 'psikogram_cakim';
            $integritas_diri_model->key = 'integritas_diri';
        }

                $integritas_diri_model->value = $_POST['integritas_diri'];
        $integritas_diri_model->save();

		

        $loyalitas_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'loyalitas'])
                            ->One();

        if(!isset($loyalitas_model)) {
            $loyalitas_model = new ProjectAssessmentResult;
            $loyalitas_model->project_assessment_id = $proj_ass->id;
            $loyalitas_model->type = 'psikogram_cakim';
            $loyalitas_model->key = 'loyalitas';
        }

                $loyalitas_model->value = $_POST['loyalitas'];
        $loyalitas_model->save();


        $pengendalian_diri_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'pengendalian_diri'])
                            ->One();

        if(!isset($pengendalian_diri_model)) {
            $pengendalian_diri_model = new ProjectAssessmentResult;
            $pengendalian_diri_model->project_assessment_id = $proj_ass->id;
            $pengendalian_diri_model->type = 'psikogram_cakim';
            $pengendalian_diri_model->key = 'pengendalian_diri';
        }

                $pengendalian_diri_model->value = $_POST['pengendalian_diri'];
        $pengendalian_diri_model->save();

        $self_confidence_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'self_confidence'])
                            ->One();

        if(!isset($self_confidence_model)) {
            $self_confidence_model = new ProjectAssessmentResult;
            $self_confidence_model->project_assessment_id = $proj_ass->id;
            $self_confidence_model->type = 'psikogram_cakim';
            $self_confidence_model->key = 'self_confidence';
        }

                $self_confidence_model->value = $_POST['self_confidence'];
        $self_confidence_model->save();

        $stabilitas_emosi_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'stabilitas_emosi'])
                            ->One();

        if(!isset($stabilitas_emosi_model)) {
            $stabilitas_emosi_model = new ProjectAssessmentResult;
            $stabilitas_emosi_model->project_assessment_id = $proj_ass->id;
            $stabilitas_emosi_model->type = 'psikogram_cakim';
            $stabilitas_emosi_model->key = 'stabilitas_emosi';
        }

                $stabilitas_emosi_model->value = $_POST['stabilitas_emosi'];
        $stabilitas_emosi_model->save();

        $teamwork_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'teamwork'])
                            ->One();

        if(!isset($teamwork_model)) {
            $teamwork_model = new ProjectAssessmentResult;
            $teamwork_model->project_assessment_id = $proj_ass->id;
            $teamwork_model->type = 'psikogram_cakim';
            $teamwork_model->key = 'teamwork';
        }

                $teamwork_model->value = $_POST['teamwork'];
        $teamwork_model->save();


        $inisiatif_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'inisiatif'])
                            ->One();

        if(!isset($inisiatif_model)) {
            $inisiatif_model = new ProjectAssessmentResult;
            $inisiatif_model->project_assessment_id = $proj_ass->id;
            $inisiatif_model->type = 'psikogram_cakim';
            $inisiatif_model->key = 'inisiatif';
        }

                $inisiatif_model->value = $_POST['inisiatif'];
        $inisiatif_model->save();

        $kkk_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'kkk'])
                            ->One();

        if(!isset($kkk_model)) {
            $kkk_model = new ProjectAssessmentResult;
            $kkk_model->project_assessment_id = $proj_ass->id;
            $kkk_model->type = 'psikogram_cakim';
            $kkk_model->key = 'kkk';
        }

                $kkk_model->value = $_POST['kkk'];
        $kkk_model->save();

        $motivasi_prestasi_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'motivasi_prestasi'])
                            ->One();

        if(!isset($motivasi_prestasi_model)) {
            $motivasi_prestasi_model = new ProjectAssessmentResult;
            $motivasi_prestasi_model->project_assessment_id = $proj_ass->id;
            $motivasi_prestasi_model->type = 'psikogram_cakim';
            $motivasi_prestasi_model->key = 'motivasi_prestasi';
        }

                $motivasi_prestasi_model->value = $_POST['motivasi_prestasi'];
        $motivasi_prestasi_model->save();


        $sistematika_kerja_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'sistematika_kerja'])
                            ->One();

        if(!isset($sistematika_kerja_model)) {
            $sistematika_kerja_model = new ProjectAssessmentResult;
            $sistematika_kerja_model->project_assessment_id = $proj_ass->id;
            $sistematika_kerja_model->type = 'psikogram_cakim';
            $sistematika_kerja_model->key = 'sistematika_kerja';
        }

                $sistematika_kerja_model->value = $_POST['sistematika_kerja'];
        $sistematika_kerja_model->save();


        $berfikir_konseptual_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'berfikir_konseptual'])
                            ->One();

        if(!isset($berfikir_konseptual_model)) {
            $berfikir_konseptual_model = new ProjectAssessmentResult;
            $berfikir_konseptual_model->project_assessment_id = $proj_ass->id;
            $berfikir_konseptual_model->type = 'psikogram_cakim';
            $berfikir_konseptual_model->key = 'berfikir_konseptual';
        }

                $berfikir_konseptual_model->value = $_POST['berfikir_konseptual'];
        $berfikir_konseptual_model->save();


  $cakim_master = CakimMaster::find()->andWhere(['reg_no' => $_POST['reg_no']])->One();
        if (null !== $cakim_master)
        {
                $cakim_master->modified_at = new Expression('NOW()');
        } else {
            $cakim_master = new CakimMaster;
                        $cakim_master->reg_no = $_POST['reg_no'];
                             $cakim_master->created_at = new Expression('NOW()');

        }
                    $cakim_master->inisiatif = $_POST['inisiatif'];
                    $cakim_master->sistematika_kerja = $_POST['sistematika_kerja'];
                    $cakim_master->kemampuan_umum = $_POST['kemampuan_umum'];
                    $cakim_master->kemampuan_berfikir_analisa_sintesa = $_POST['analisa_sintesa'];
                    $cakim_master->kkk = $_POST['kkk'];
                    $cakim_master->motivasi_berprestasi = $_POST['motivasi_prestasi'];
                    $cakim_master->kemampuan_berfikir_konseptual = $_POST['berfikir_konseptual'];
                    $cakim_master->integritas_diri = $_POST['integritas_diri'];
                    $cakim_master->loyalitas = $_POST['loyalitas'];
                    $cakim_master->kemampuan_proses_belajar = $_POST['proses_belajar'];
                    $cakim_master->stabilitas_emosi = $_POST['stabilitas_emosi'];
                    $cakim_master->pengendalian_diri = $_POST['pengendalian_diri'];
                    $cakim_master->fleksibilitas = $_POST['fleksibilitas'];
                    $cakim_master->self_confidence = $_POST['self_confidence'];
                    $cakim_master->teamwork = $_POST['teamwork'];
                             $cakim_master->status = 'so_reviewed';
                    $cakim_master->penampilan_fisik = $_POST['penampilan_fisik'];

                    $cakim_master->total = $_POST['inisiatif'] + $_POST['sistematika_kerja'] + $_POST['kemampuan_umum'] 
                    + $_POST['analisa_sintesa'] + $_POST['kkk'] + $_POST['motivasi_prestasi'] + $_POST['berfikir_konseptual']
                    + $_POST['integritas_diri'] + $_POST['loyalitas'] + $_POST['proses_belajar'] + $_POST['stabilitas_emosi']
                    +$_POST['pengendalian_diri'] + $_POST['fleksibilitas'] + $_POST['self_confidence'] + $_POST['teamwork'];

                    $cakim_total = (int) $cakim_master->total;
                    if ($cakim_total >= 77) {
                        $rekomendasi = 'K-1';
                    } else if (($cakim_total <= 76) &&($cakim_total >= 68))
                    {
                        $rekomendasi = 'K-2';
                    } else if (($cakim_total <= 67) &&($cakim_total >= 59))
                    {
                        $rekomendasi = 'K-3';
                    } else {
                             $rekomendasi = 'K-4';
                    }
                    $cakim_master->rekomendasi = $rekomendasi;

                    $cakim_master->psikotes_no = $_POST['psikotes_no'];
                    $cakim_master->lokasi = $_POST['schedule_place'];
                    $cakim_master->nama = $_POST['first_name'];

        $userprofile = Profile::find()->andWhere(['user_id' => Yii::$app->user->id])->One();


                $cakim_master->so_id = (string) $userprofile->id;
                $cakim_master->so_name = $userprofile->first_name;

                    //$cakim_master->usia = $usia;
                    $cakim_master->jenis_kelamin = $_POST['gender'];
                    $cakim_master->tingkat_pendidikan = $_POST['latest_education'];
                    $cakim_master->prospek_jabatan = $_POST['job_prospect'];
                    $cakim_master->tanggal_pemeriksaan = $_POST['schedule_time'];
               
         if($cakim_master->save())
         {
                    Yii::$app->session->addFlash('success', 'data submitted');
                } else {
                            Yii::$app->session->addFlash('warning', 'master table not saved. ' . json_encode($cakim_master->errors));

                }

;

        //$this->redirect([''])
        $activity_status_model = ProjectActivityMeta::find()->andWhere(['project_activity_id' => $id])
                            ->andWhere(['type' => 'assessment'])
                            ->andWhere(['key' => 'status'])
                            ->One();

        if(!isset($activity_status_model)) {
            $activity_status_model = new ProjectActivityMeta;
            $activity_status_model->project_activity_id = $id;
            $activity_status_model->type = 'assessment';
            $activity_status_model->key = 'status';
        }


                            $activity_status_model->value = 'done';
                            $activity_status_model->save();

	$activity_status = ProjectActivityMeta::find()->andWhere(['project_activity_id' => $id])
    ->andWhere(['type' => 'assessment'])
            ->andWhere(['key' => 'status'])->One();
			
			$activity_status->value = 'so_reviewed';
			$activity_status->save();
			
           Yii::$app->session->addFlash('success', 'data submitted');

            return $this->redirect(['project/dashboard', 'id' => '2']);


    $validate = true;

    if ($validate) {
        //Profile::find()
        //->andWhere(['profile_id' => ])

    } else {
        echo 'VALIDATION ERROR! NOT SAVED!';
    }


    }











    public function actionSorejected($id)
    {


        $project_activity_model = ProjectActivity::findOne($id);
        $assessee_model = ProjectActivityMeta::find()->andWhere(['project_activity_id' => $id])
                            ->andWhere(['type' => 'general'])
                            ->andWhere(['key' => 'assessee'])
                            ->One();

        $profile_assessee_model = Profile::findOne($assessee_model->value);
        $profile_id = $profile_assessee_model->id;
        $reg_no_model = ProjectActivityMeta::find()->andWhere(['project_activity_id' => $id])
                            ->andWhere(['type' => 'general'])
                            ->andWhere(['key' => 'reg_no'])
                            ->One();



        $birthplace_model = ProfileMeta::find()->andWhere(['profile_id' => $profile_id])
                            ->andWhere(['type' => 'personal'])
                            ->andWhere(['key' => 'birthplace'])
                            ->One();
        if(!isset($birthplace_model)) {
            $birthplace_model = new ProfileMeta;
            $birthplace_model->profile_id = $profile_id;
            $birthplace_model->type = 'personal';
            $birthplace_model->key = 'birthplace';
        }
        $birthplace_model->value = $_POST['birthplace'];
        $birthplace_model->save();

        $current_job_model = ProfileMeta::find()->andWhere(['profile_id' => $profile_id])
                            ->andWhere(['type' => 'work'])
                            ->andWhere(['key' => 'current_job'])
                            ->One();
        if(!isset($current_job_model)) {
            $current_job_model = new ProfileMeta;
            $current_job_model->profile_id = $profile_id;
            $current_job_model->type = 'work';
            $current_job_model->key = 'current_job';
        }
        $current_job_model->value = $_POST['current_job'];
        $current_job_model->save();



        $job_prospect_model = ProjectActivityMeta::find()->andWhere(['project_activity_id' => $id])
                            ->andWhere(['type' => 'general'])
                            ->andWhere(['key' => 'job_prospect'])
                            ->One();
        if(!isset($job_prospect_model)) {
            $job_prospect_model = new ProjectActivityMeta;
            $job_prospect_model->project_activity_id = $id;
            $job_prospect_model->type = 'general';
            $job_prospect_model->key = 'job_prospect';
        }
        $job_prospect_model->value = $_POST['job_prospect'];
        $job_prospect_model->save();


        $latest_education_model = ProfileMeta::find()->andWhere(['profile_id' => $profile_id])
                            ->andWhere(['type' => 'education'])
                            ->andWhere(['key' => 'latest'])
                            ->One();
        if(!isset($latest_education_model)) {
            $latest_education_model = new ProfileMeta;
            $latest_education_model->profile_id = $profile_id;
            $latest_education_model->type = 'education';
            $latest_education_model->key = 'latest';
        }
        $latest_education_model->value = $_POST['latest_education'];
        $latest_education_model->save();


        $univ_model = ProfileMeta::find()->andWhere(['profile_id' => $profile_id])
                            ->andWhere(['type' => 'education'])
                            ->andWhere(['key' => 'univ'])
                            ->One();
        if(!isset($univ_model)) {
            $univ_model = new ProfileMeta;
            $univ_model->profile_id = $profile_id;
            $univ_model->type = 'education';
            $univ_model->key = 'univ';
        }
        $univ_model->value = $_POST['univ'];
        $univ_model->save();


        $schedule_place = ProjectActivityMeta::find()->andWhere(['project_activity_id' => $id])
                            ->andWhere(['type' => 'schedule'])
                            ->andWhere(['key' => 'place'])
                            ->One();
        if(!isset($schedule_place)) {
            $schedule_place = new ProjectActivityMeta;
            $schedule_place->project_activity_id = $id;
            $schedule_place->type = 'schedule';
            $schedule_place->key = 'place';
        }
        $schedule_place->value = $_POST['schedule_place'];
        $schedule_place->save();

        $schedule_time = ProjectActivityMeta::find()->andWhere(['project_activity_id' => $id])
                            ->andWhere(['type' => 'schedule'])
                            ->andWhere(['key' => 'time'])
                            ->One();
        if(!isset($schedule_time)) {
            $schedule_time = new ProjectActivityMeta;
            $schedule_time->project_activity_id = $id;
            $schedule_time->type = 'schedule';
            $schedule_time->key = 'time';
        }
        $schedule_time->value = $_POST['schedule_time'];
        $schedule_time->save();

    $profile_assessee_model->birthdate = $_POST['birthdate'];
    $profile_assessee_model->gender = $_POST['gender'];
    $profile_assessee_model->first_name = $_POST['first_name'];
    $profile_assessee_model->save();


/**

    [kemampuan_umum] => 1
    [analisa_sintesa] => 1
    [berfikir_konseptual] => 1
    [proses_belajar] => 1
    [motivasi_prestasi] => 1
    [inisiatif] => 1
    [sistematika_kerja] => 1
    [kkk] => 1
    [integritas_diri] => 1
    [loyalitas] => 1
    [stabilitas_emosi] => 1
    [pengendalian_diri] => 1
    [fleksibilitas] => 1
    [self_confidence] => 1
    [teamwork] => 1
    [sum] => 
    [penampilan_fisik] => 1
*/

    $proj_ass = ProjectAssessment::find()->andWhere(['activity_id' => $id])->One();

        $analisa_sintesa_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'analisa_sintesa'])
                            ->One();

        if(!isset($analisa_sintesa_model)) {
            $analisa_sintesa_model = new ProjectAssessmentResult;
            $analisa_sintesa_model->project_assessment_id = $proj_ass->id;
            $analisa_sintesa_model->type = 'psikogram_cakim';
            $analisa_sintesa_model->key = 'analisa_sintesa';
        }

                $analisa_sintesa_model->value = $_POST['analisa_sintesa'];
        $analisa_sintesa_model->save();


        $kemampuan_umum_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'kemampuan_umum'])
                            ->One();

        if(!isset($kemampuan_umum_model)) {
            $kemampuan_umum_model = new ProjectAssessmentResult;
            $kemampuan_umum_model->project_assessment_id = $proj_ass->id;
            $kemampuan_umum_model->type = 'psikogram_cakim';
            $kemampuan_umum_model->key = 'kemampuan_umum';
        }

                $kemampuan_umum_model->value = $_POST['kemampuan_umum'];
        $kemampuan_umum_model->save();


        $proses_belajar_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'proses_belajar'])
                            ->One();

        if(!isset($proses_belajar_model)) {
            $proses_belajar_model = new ProjectAssessmentResult;
            $proses_belajar_model->project_assessment_id = $proj_ass->id;
            $proses_belajar_model->type = 'psikogram_cakim';
            $proses_belajar_model->key = 'proses_belajar';
        }

                $proses_belajar_model->value = $_POST['proses_belajar'];
        $proses_belajar_model->save();


        $penampilan_fisik_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'penampilan_fisik'])
                            ->One();

        if(!isset($penampilan_fisik_model)) {
            $penampilan_fisik_model = new ProjectAssessmentResult;
            $penampilan_fisik_model->project_assessment_id = $proj_ass->id;
            $penampilan_fisik_model->type = 'psikogram_cakim';
            $penampilan_fisik_model->key = 'penampilan_fisik';
        }

                $penampilan_fisik_model->value = $_POST['penampilan_fisik'];
        $penampilan_fisik_model->save();


        $fleksibilitas_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'fleksibilitas'])
                            ->One();

        if(!isset($fleksibilitas_model)) {
            $fleksibilitas_model = new ProjectAssessmentResult;
            $fleksibilitas_model->project_assessment_id = $proj_ass->id;
            $fleksibilitas_model->type = 'psikogram_cakim';
            $fleksibilitas_model->key = 'fleksibilitas';
        }

                $fleksibilitas_model->value = $_POST['fleksibilitas'];
        $fleksibilitas_model->save();

        $integritas_diri_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'integritas_diri'])
                            ->One();

        if(!isset($integritas_diri_model)) {
            $integritas_diri_model = new ProjectAssessmentResult;
            $integritas_diri_model->project_assessment_id = $proj_ass->id;
            $integritas_diri_model->type = 'psikogram_cakim';
            $integritas_diri_model->key = 'integritas_diri';
        }

                $integritas_diri_model->value = $_POST['integritas_diri'];
        $integritas_diri_model->save();


        $loyalitas_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'loyalitas'])
                            ->One();

        if(!isset($loyalitas_model)) {
            $loyalitas_model = new ProjectAssessmentResult;
            $loyalitas_model->project_assessment_id = $proj_ass->id;
            $loyalitas_model->type = 'psikogram_cakim';
            $loyalitas_model->key = 'loyalitas';
        }

                $loyalitas_model->value = $_POST['loyalitas'];
        $loyalitas_model->save();


        $pengendalian_diri_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'pengendalian_diri'])
                            ->One();

        if(!isset($pengendalian_diri_model)) {
            $pengendalian_diri_model = new ProjectAssessmentResult;
            $pengendalian_diri_model->project_assessment_id = $proj_ass->id;
            $pengendalian_diri_model->type = 'psikogram_cakim';
            $pengendalian_diri_model->key = 'pengendalian_diri';
        }

                $pengendalian_diri_model->value = $_POST['pengendalian_diri'];
        $pengendalian_diri_model->save();

        $self_confidence_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'self_confidence'])
                            ->One();

        if(!isset($self_confidence_model)) {
            $self_confidence_model = new ProjectAssessmentResult;
            $self_confidence_model->project_assessment_id = $proj_ass->id;
            $self_confidence_model->type = 'psikogram_cakim';
            $self_confidence_model->key = 'self_confidence';
        }

                $self_confidence_model->value = $_POST['self_confidence'];
        $self_confidence_model->save();

        $stabilitas_emosi_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'stabilitas_emosi'])
                            ->One();

        if(!isset($stabilitas_emosi_model)) {
            $stabilitas_emosi_model = new ProjectAssessmentResult;
            $stabilitas_emosi_model->project_assessment_id = $proj_ass->id;
            $stabilitas_emosi_model->type = 'psikogram_cakim';
            $stabilitas_emosi_model->key = 'stabilitas_emosi';
        }

                $stabilitas_emosi_model->value = $_POST['stabilitas_emosi'];
        $stabilitas_emosi_model->save();

        $teamwork_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'teamwork'])
                            ->One();

        if(!isset($teamwork_model)) {
            $teamwork_model = new ProjectAssessmentResult;
            $teamwork_model->project_assessment_id = $proj_ass->id;
            $teamwork_model->type = 'psikogram_cakim';
            $teamwork_model->key = 'teamwork';
        }

                $teamwork_model->value = $_POST['teamwork'];
        $teamwork_model->save();


        $inisiatif_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'inisiatif'])
                            ->One();

        if(!isset($inisiatif_model)) {
            $inisiatif_model = new ProjectAssessmentResult;
            $inisiatif_model->project_assessment_id = $proj_ass->id;
            $inisiatif_model->type = 'psikogram_cakim';
            $inisiatif_model->key = 'inisiatif';
        }

                $inisiatif_model->value = $_POST['inisiatif'];
        $inisiatif_model->save();

        $kkk_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'kkk'])
                            ->One();

        if(!isset($kkk_model)) {
            $kkk_model = new ProjectAssessmentResult;
            $kkk_model->project_assessment_id = $proj_ass->id;
            $kkk_model->type = 'psikogram_cakim';
            $kkk_model->key = 'kkk';
        }

                $kkk_model->value = $_POST['kkk'];
        $kkk_model->save();

        $motivasi_prestasi_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'motivasi_prestasi'])
                            ->One();

        if(!isset($motivasi_prestasi_model)) {
            $motivasi_prestasi_model = new ProjectAssessmentResult;
            $motivasi_prestasi_model->project_assessment_id = $proj_ass->id;
            $motivasi_prestasi_model->type = 'psikogram_cakim';
            $motivasi_prestasi_model->key = 'motivasi_prestasi';
        }

                $motivasi_prestasi_model->value = $_POST['motivasi_prestasi'];
        $motivasi_prestasi_model->save();


        $sistematika_kerja_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'sistematika_kerja'])
                            ->One();

        if(!isset($sistematika_kerja_model)) {
            $sistematika_kerja_model = new ProjectAssessmentResult;
            $sistematika_kerja_model->project_assessment_id = $proj_ass->id;
            $sistematika_kerja_model->type = 'psikogram_cakim';
            $sistematika_kerja_model->key = 'sistematika_kerja';
        }

                $sistematika_kerja_model->value = $_POST['sistematika_kerja'];
        $sistematika_kerja_model->save();


        $berfikir_konseptual_model = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $proj_ass->id])
                            ->andWhere(['type' => 'psikogram_cakim'])
                            ->andWhere(['key' => 'berfikir_konseptual'])
                            ->One();

        if(!isset($berfikir_konseptual_model)) {
            $berfikir_konseptual_model = new ProjectAssessmentResult;
            $berfikir_konseptual_model->project_assessment_id = $proj_ass->id;
            $berfikir_konseptual_model->type = 'psikogram_cakim';
            $berfikir_konseptual_model->key = 'berfikir_konseptual';
        }

                $berfikir_konseptual_model->value = $_POST['berfikir_konseptual'];
        $berfikir_konseptual_model->save();


  $cakim_master = CakimMaster::find()->andWhere(['reg_no' => $_POST['reg_no']])->One();
        if (null !== $cakim_master)
        {
                $cakim_master->modified_at = new Expression('NOW()');
        } else {
            $cakim_master = new CakimMaster;
                        $cakim_master->reg_no = $_POST['reg_no'];
                             $cakim_master->created_at = new Expression('NOW()');

        }
                    $cakim_master->inisiatif = $_POST['inisiatif'];
                    $cakim_master->sistematika_kerja = $_POST['sistematika_kerja'];
                    $cakim_master->kemampuan_umum = $_POST['kemampuan_umum'];
                    $cakim_master->kemampuan_berfikir_analisa_sintesa = $_POST['analisa_sintesa'];
                    $cakim_master->kkk = $_POST['kkk'];
                    $cakim_master->motivasi_berprestasi = $_POST['motivasi_prestasi'];
                    $cakim_master->kemampuan_berfikir_konseptual = $_POST['berfikir_konseptual'];
                    $cakim_master->integritas_diri = $_POST['integritas_diri'];
                    $cakim_master->loyalitas = $_POST['loyalitas'];
                    $cakim_master->kemampuan_proses_belajar = $_POST['proses_belajar'];
                    $cakim_master->stabilitas_emosi = $_POST['stabilitas_emosi'];
                    $cakim_master->pengendalian_diri = $_POST['pengendalian_diri'];
                    $cakim_master->fleksibilitas = $_POST['fleksibilitas'];
                    $cakim_master->self_confidence = $_POST['self_confidence'];
                    $cakim_master->teamwork = $_POST['teamwork'];
                             $cakim_master->status = 'so_rejected';
                    $cakim_master->penampilan_fisik = $_POST['penampilan_fisik'];

                    $cakim_master->total = $_POST['inisiatif'] + $_POST['sistematika_kerja'] + $_POST['kemampuan_umum'] 
                    + $_POST['analisa_sintesa'] + $_POST['kkk'] + $_POST['motivasi_prestasi'] + $_POST['berfikir_konseptual']
                    + $_POST['integritas_diri'] + $_POST['loyalitas'] + $_POST['proses_belajar'] + $_POST['stabilitas_emosi']
                    +$_POST['pengendalian_diri'] + $_POST['fleksibilitas'] + $_POST['self_confidence'] + $_POST['teamwork'];

                    $cakim_total = (int) $cakim_master->total;
                    if($_POST['penampilan_fisik'] !== 0) {


                    if ($cakim_total >= 77) {
                        $rekomendasi = 'K-1';
                    } else if (($cakim_total <= 76) &&($cakim_total >= 68))
                    {
                        $rekomendasi = 'K-2';
                    } else if (($cakim_total <= 67) &&($cakim_total >= 59))
                    {
                        $rekomendasi = 'K-3';
                    } else {
                             $rekomendasi = 'K-4';
                    }
                } else {
                     $rekomendasi = 'K-4';
                }
                    $cakim_master->rekomendasi = $rekomendasi;

                    $cakim_master->psikotes_no = $_POST['psikotes_no'];
                    $cakim_master->lokasi = $_POST['schedule_place'];
                    $cakim_master->nama = $_POST['first_name'];

        $userprofile = Profile::find()->andWhere(['user_id' => Yii::$app->user->id])->One();


                $cakim_master->so_id = (string) $userprofile->id;
                $cakim_master->so_name = $userprofile->first_name;

                    //$cakim_master->usia = $usia;
                    $cakim_master->jenis_kelamin = $_POST['gender'];
                    $cakim_master->tingkat_pendidikan = $_POST['latest_education'];
                    $cakim_master->prospek_jabatan = $_POST['job_prospect'];
                    $cakim_master->tanggal_pemeriksaan = $_POST['schedule_time'];
               
         if($cakim_master->save())
         {
                    Yii::$app->session->addFlash('success', 'data submitted');
                } else {
                            Yii::$app->session->addFlash('warning', 'master table not saved. ' . json_encode($cakim_master->errors));

                }

;

        //$this->redirect([''])
        $activity_status_model = ProjectActivityMeta::find()->andWhere(['project_activity_id' => $id])
                            ->andWhere(['type' => 'assessment'])
                            ->andWhere(['key' => 'status'])
                            ->One();

        if(!isset($activity_status_model)) {
            $activity_status_model = new ProjectActivityMeta;
            $activity_status_model->project_activity_id = $id;
            $activity_status_model->type = 'assessment';
            $activity_status_model->key = 'status';
        }


                            $activity_status_model->value = 'done';
                            $activity_status_model->save();
	$activity_status = ProjectActivityMeta::find()->andWhere(['project_activity_id' => $id])
    ->andWhere(['type' => 'assessment'])
            ->andWhere(['key' => 'status'])->One();
			
			$activity_status->value = 'so_rejected';
			$activity_status->save();
			
           Yii::$app->session->addFlash('success', 'data submitted');

            return $this->redirect(['project/dashboard', 'id' => '2']);


    $validate = true;

    if ($validate) {
        //Profile::find()
        //->andWhere(['profile_id' => ])

    } else {
        echo 'VALIDATION ERROR! NOT SAVED!';
    }


    }



}
