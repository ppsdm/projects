<?php

namespace app\modules\projects\controllers;

use Yii;
use app\modules\projects\models\ProjectActivity;
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

use yii\filters\AccessControl;
//use mikehaertl\wkhtmlto\Pdf;
/**
 * ActivityController implements the CRUD actions for Activity model.
 */
class ActivityController extends Controller
{

   public function Actions()
   {
       return ArrayHelper::merge(parent::actions(), [
           'editname' => [                                       // identifier for your editable action
               'class' => EditableColumnAction::className(),     // action class name
               'modelClass' => ProjectActivity::className(),                // the update model class
               'outputValue' => function ($model, $attribute, $key, $index) {
                    $fmt = Yii::$app->formatter;
                    $value = $model->$attribute;                 // your attribute value
                    if ($attribute === 'name') {           // selective validation by attribute
                        //return $fmt->asDecimal($value, 2);       // return formatted value if desired
                        //return json_encode($value);
                        return '';
                    } elseif ($attribute === 'publish_date') {   // selective validation by attribute
                        return $fmt->asDate($value, 'php:Y-m-d');// return formatted value if desired
                    }
                    return '';                                   // empty is same as $value
               },
               'outputMessage' => function($model, $attribute, $key, $index) {
                     return '';                                  // any custom error after model save
               },
               // 'showModelErrors' => true,                     // show model errors after save
               // 'errorOptions' => ['header' => '']             // error summary HTML options
               // 'postOnly' => true,
               // 'ajaxOnly' => true,
               // 'findModel' => function($id, $action) {},
               // 'checkAccess' => function($action, $model) {}
           ],

           'editpsikogram' => [                                       // identifier for your editable action
               'class' => EditableColumnAction::className(),     // action class name
               'modelClass' => ProjectAssessmentResult::className(),                // the update model class
               'outputValue' => function ($model, $attribute, $key, $index) {
                    $fmt = Yii::$app->formatter;
          
                    $value = $model->$attribute;                 // your attribute value
                    if ($attribute === 'value') {           // selective validation by attribute
                        //return $fmt->asDecimal($value, 2);       // return formatted value if desired
                        //return json_encode($value);
                        $radiolistoptions = [1 => '1',2 => '2',3=>'3',4=>'4',5=>'5',6=>'6',7 =>'7'];

                        return Html::RadioList($model->key, $value, $radiolistoptions, [
                                 'item' => function($index, $label, $name, $checked, $value) 
                                    {
                                      $readonly = false;
                                      $aspek = CatalogMeta::find()->andWhere(['type' => 'psikogram'])->andWhere(['key' => 'aspek'])->andWhere(['value' => $name])->One();
                                      $islkj = '';
                                      if ($index == ($aspek->attribute_1-1)) {
                                       // $islkj = 'RadioBox2';
                                        return "<div class='RadioBox2'>".Html::Label(Html::Radio($name,$checked,['class' => 'RadioBox2', 'disabled' => $readonly]) .' '. $label)."</div>";
                                      }
                                  else {
                                                  return "<div class='RadioBox'>".Html::Label(Html::Radio($name,$checked,['class' => 'RadioBox', 'disabled' => $readonly]) .' '. $label)."</div>";
                                                  
                                              }   
                                    },
                                        
                          ]);

                        //return $value;
                    } elseif ($attribute === 'publish_date') {   // selective validation by attribute
                        return $fmt->asDate($value, 'php:Y-m-d');// return formatted value if desired
                    }
                    return 'sasa';                                   // empty is same as $value
               },
               'outputMessage' => function($model, $attribute, $key, $index) {
                     return '';                                  // any custom error after model save
               },
                'showModelErrors' => true,                     // show model errors after save
               // 'errorOptions' => ['header' => '']             // error summary HTML options
               // 'postOnly' => true,
               // 'ajaxOnly' => true,
               // 'findModel' => function($id, $action) {},
               // 'checkAccess' => function($action, $model) {}
           ],
           'editkompetensigram' => [                                       // identifier for your editable action
               'class' => EditableColumnAction::className(),     // action class name
               'modelClass' => ProjectAssessmentResult::className(),                // the update model class
               'outputValue' => function ($model, $attribute, $key, $index) {
                    $fmt = Yii::$app->formatter;
                    $value = $model->$attribute;                 // your attribute value
                    if ($attribute === 'value') {           // selective validation by attribute
                        //return $fmt->asDecimal($value, 2);       // return formatted value if desired
                        //return json_encode($value);
        
      $maxmodel = RefAssessmentDictionary::find()
      ->andWhere(['type' => 'uraian_kompetensigram'])
      ->andWhere(['key' => $model->key . $model->value])
      ->All();
      $size = sizeof($maxmodel);
      $randomizer = 1;
      if ($size > 0) {
      $random =  rand();
      $randomizer = $random % $size;
      $randomizer++;
      //echo 'randomizer : ' . $randomizer
            $model->attribute_1 = (string) $randomizer;
      $model->save();
      }


      
                        return $value;
                    } elseif ($attribute === 'publish_date') {   // selective validation by attribute
                        return $fmt->asDate($value, 'php:Y-m-d');// return formatted value if desired
                    }
                    return '';                                   // empty is same as $value
               },
               'outputMessage' => function($model, $attribute, $key, $index) {
                     return '';                                  // any custom error after model save
               },
               // 'showModelErrors' => true,                     // show model errors after save
               // 'errorOptions' => ['header' => '']             // error summary HTML options
               // 'postOnly' => true,
               // 'ajaxOnly' => true,
               // 'findModel' => function($id, $action) {},
               // 'checkAccess' => function($action, $model) {}
           ],
           'edituraiankompetensigram' => [                                       // identifier for your editable action
               'class' => EditableColumnAction::className(),     // action class name
               'modelClass' => Kompetensigram::className(),                // the update model class
               'outputValue' => function ($model, $attribute, $key, $index) {
                    $fmt = Yii::$app->formatter;
                    $value = $model->$attribute;                 // your attribute value
                    if ($attribute === 'value') {           // selective validation by attribute
                        //return $fmt->asDecimal($value, 2);       // return formatted value if desired
                        //return json_encode($value);
        
                        return $value;
                    } elseif ($attribute === 'publish_date') {   // selective validation by attribute
                        return $fmt->asDate($value, 'php:Y-m-d');// return formatted value if desired
                    }
                    return '';                                   // empty is same as $value
               },
               'outputMessage' => function($model, $attribute, $key, $index) {
                     return '';                                  // any custom error after model save
               },
               // 'showModelErrors' => true,                     // show model errors after save
               // 'errorOptions' => ['header' => '']             // error summary HTML options
               // 'postOnly' => true,
               // 'ajaxOnly' => true,
               // 'findModel' => function($id, $action) {},
               // 'checkAccess' => function($action, $model) {}
           ]


       ]);
   }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
                  'access' => [
                'class' => AccessControl::className(),
                'only' => ['cakimpdf'],
                'rules' => [
                    [
                        'actions' => ['cakimpdf'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['cakimpdf'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }





    /**
     * Lists all Activity models.
     * @return mixed
     */
    public function actionIndex($id)
    {

        
        
        $searchModel = new ProjectActivitySearch();
        $params = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        
    }

    public function initAssessment($id, $catalog_id)
    {
      $assessment = ProjectAssessment::find()->andWhere(['activity_id' => $id])->andWhere(['status' => 'active'])
      ->andWhere(['catalog_id' => $catalog_id])
      ->One();
      if (null !== $assessment) {
        $metas = CatalogMeta::find()->andWhere(['catalog_id' => $catalog_id])->All();

        foreach ($metas as $meta_key => $meta_value) {
          # code...
          //echo $meta_key . ': ' . $meta_value->type . ' : ' . $meta_value->key . ' ----> ' . $meta_value->value;
          //echo '<br/>';
          $result = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $assessment->id])
          ->andWhere(['type' => $meta_value->type])
          ->andWhere(['key' => $meta_value->value])->One();

          if (null !== $result){

          } else {
            $newresult = new ProjectAssessmentResult();
            $newresult->type  = $meta_value->type;
            $newresult->key = $meta_value->value;
            $newresult->project_assessment_id = $assessment->id;
            $newresult->save();

          }

        }
          //return $assessment->id;
     //   $ProjectAssessmentResult::find()->andWhere(['']);
      } else{

          echo 'ASSESSMENT NOT FOUND: catalog_id mismath. catalog_id  should be : ' . $catalog_id;
      }
    }
    public function actionActivate($id)
    {
        /**
        1. change status to active
        2. send notification to page
        3. send notification by email

        */

    }


    /**
     * Displays a single Activity model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {


        $data = [];
        $model = $this->findModel($id);

        $profi = Profile::find()->andWhere(['user_id' => Yii::$app->user->id])->One();
        $is_assessor = ProjectActivityMeta::find()
        ->andWhere(['project_activity_id' => $id])
        ->andWhere(['type' => 'general'])
        //->andWhere(['key' => 'assessor'])
        ->andWhere(['value' => $profi->id])->One();

        // UNTUK CAKIM //
        $is_assessor = true;
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




        }
    } else {

      echo 'not allowed';
     }

  }


public function actionValidateuraian($uraian)
{
    $model = DynamicModel::validateData(compact('uraian'), [
        [['name'], 'string', 'min' => 200,'max' => 1280],
        
    ]);

    if ($model->hasErrors()) {
        // validation fails
        echo 'ERROR';
    } else {
        // validation succeeds
        return true;
    }
}


  public function actionSaves($id)
  {

    echo '<pre>';
    print_r($_POST);
$email = 'test@examplecom';
$emailvalidator = new EmailValidator();
$stringvalidator = new StringValidator();
$stringvalidator->max = 1000;
$stringvalidator->min = 500;
$stringvalidator->tooLong ="kepanjangan!";
$stringvalidator->tooLong ="terlalu pendek!";
    echo '<hr/>';
    foreach ($_POST as $key => $value) {
      # code...
$uraian = explode('_', $key);
      if ($uraian[0] == 'uraiankompetensigram')
      {

if ($stringvalidator->validate(str_replace(' ','',strip_tags($value)), $error)) {
        echo $uraian[1];
        echo ' length :' . strlen($value);

        } else {
                //$this->addError('childrenCount', 'Your salary is not enough for children.');
          echo $error;
        }

      echo '<br/>';

      } else {

      }
    }





/*
            return $this->render('debug', [

            ]);
            */


  }

    public function Snapshot($id, $type)
    {
      $snapshot_data = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $id])->All();

        $new_snapshot = new ProjectResultSnapshot;
        $new_snapshot->project_assessment_id = $id;
        $new_snapshot->snapshot_type = $type;

        $new_snapshot->created_at = new Expression('NOW()');
        $new_snapshot->save();

        $user_save = new ProjectResultSnapshotMeta;
        $user_save->project_result_snapshot_id = $new_snapshot->id;
        $user_save->type = 'subject';
        $user_save->key = 'user_id';
        $user_save->value = (string) Yii::$app->user->id;
                $user_save->save();

      foreach ($snapshot_data as $key => $value) {
        $new_result_snapshot = new ProjectResultSnapshotMeta;
        $new_result_snapshot->project_result_snapshot_id = $new_snapshot->id;
        $new_result_snapshot->type = $value->type;
        $new_result_snapshot->key = $value->key;
        $new_result_snapshot->value = $value->value;
        $new_result_snapshot->textvalue = $value->textvalue;
        $new_result_snapshot->attribute_1 = $value->attribute_1;
        $new_result_snapshot->attribute_2 = $value->attribute_2;
        $new_result_snapshot->attribute_3 = $value->attribute_3;
        $new_result_snapshot->save();
        

      }
      
    }

    public function Save($id, $post)
    {

$stringvalidator = new StringValidator();
$stringvalidator->max = 30000;
$stringvalidator->min = 500;
$stringvalidator->tooLong ="terlalu panjang";
$stringvalidator->tooShort ="terlalu pendek";

      $errorexist = 0;
              $activi = ProjectActivityMeta::find()
              ->andWhere(['project_activity_id' => $id])
              ->andWhere(['type' => 'general'])
              ->andWhere(['key' => 'assessee'])
              ->One();
                $assessee_prof = Profile::findOne($activi->value);
        if (isset($post['Profile'])) {
                $assessee_prof->birthdate = $post['Profile']['birthdate'];
                $assessee_prof->first_name = $post['Profile']['first_name'];
                $assessee_prof->save();
             }

        if (isset($_POST['ProfileMeta'])) {
              $birthplace = ProfileMeta::find()
              ->andWhere(['profile_id' => $assessee_prof->id])
              ->andWhere(['type' => 'personal'])
              ->andWhere(['key' => 'birthplace'])
              ->One();
              if (null !== $birthplace) {
                $birthplace->value = $post['ProfileMeta']['value'];
                $birthplace->save();
             } else {
                $newbirthplace = new ProfileMeta();
                $newbirthplace->type = 'personal';
                $newbirthplace->key = 'birthplace';
                $newbirthplace->profile_id = $assessee_prof->id;
                $newbirthplace->value = $post['ProfileMeta']['value'];
                $newbirthplace->save();

             }
           }


        if (isset($_POST['AssessmentReport'])) {
            $project_assessment = ProjectAssessment::find()->andWhere(['activity_id' => $id])->One();
            $exec_summary = ProjectAssessmentResult::find()
            ->andWhere(['project_assessment_id' => $project_assessment->id])
            ->andWhere(['type' => 'executive_summary'])->One();

            $kekuatan = ProjectAssessmentResult::find()
            ->andWhere(['project_assessment_id' => $project_assessment->id])
            ->andWhere(['type' => 'kekuatan'])->One();

            $kelemahan = ProjectAssessmentResult::find()
            ->andWhere(['project_assessment_id' => $project_assessment->id])
            ->andWhere(['type' => 'kelemahan'])->One();


            $saran_pengembangan = ProjectAssessmentResult::find()
            ->andWhere(['project_assessment_id' => $project_assessment->id])
            ->andWhere(['type' => 'saran_pengembangan'])->One();

                    $address = ProfileMeta::find()
                    ->andWhere(['profile_id' => $assessee_prof->id])
                    ->andWhere(['type' => 'address'])
                    ->andWhere(['key' => 'home_address'])->One();


                    $latest_education = ProfileMeta::find()
                    ->andWhere(['profile_id' => $assessee_prof->id])
                    ->andWhere(['type' => 'education'])
                    ->andWhere(['key' => 'latest'])->One();

                    $current_position = ProfileMeta::find()
                    ->andWhere(['profile_id' => $assessee_prof->id])
                    ->andWhere(['type' => 'work'])
                    ->andWhere(['key' => 'current_position'])->One();

                    $satuan_kerja = ProfileMeta::find()
                    ->andWhere(['profile_id' => $assessee_prof->id])
                    ->andWhere(['type' => 'work'])
                    ->andWhere(['key' => 'satuan_kerja'])->One();



            if (null !== $address) {
                $address->value = $post['AssessmentReport']['alamat'];
                $address->save();
            } else {
                $address = new ProfileMeta();
                $address->type = 'address';
                $address->key = 'home_address';
                $address->value = $post['AssessmentReport']['alamat'];
                $address->save();
            }

            if (null !== $latest_education) {
                $latest_education->value = $post['AssessmentReport']['pendidikan_terakhir'];
                $latest_education->save();
            } else {
                $latest_education = new ProfileMeta();
                $latest_education->type = 'education';
                $latest_education->key = 'latest';
                $latest_education->value = $post['AssessmentReport']['pendidikan_terakhir'];
                $latest_education->save();
            }

            if (null !== $current_position) {
                $current_position->value = $post['AssessmentReport']['current_position'];
                $current_position->save();
            } else {
                $current_position = new ProfileMeta();
                $current_position->type = 'work';
                $current_position->key = 'current_position';
                $current_position->value = $post['AssessmentReport']['current_position'];
                $current_position->save();
            }

            if (null !== $satuan_kerja) {
                $satuan_kerja->value = $post['AssessmentReport']['satuan_kerja'];
                $satuan_kerja->save();
            } else {
                $satuan_kerja = new ProfileMeta();
                $satuan_kerja->type = 'work';
                $satuan_kerja->key = 'satuan_kerja';
                $satuan_kerja->value = $post['AssessmentReport']['satuan_kerja'];
                $satuan_kerja->save();
            }


            if (null !== $exec_summary) {
                $exec_summary->textvalue = $post['AssessmentReport']['executive_summary'];

            } else {
                $exec_summary = new ProjectAssessmentResult();
                $exec_summary->project_assessment_id = $project_assessment->id;
                $exec_summary->type = 'executive_summary';
                $exec_summary->textvalue = $post['AssessmentReport']['executive_summary'];

            }
 //$exec_summary_stripped = ;
            if ($stringvalidator->validate(str_replace(' ','',strip_tags($exec_summary->textvalue)) , $error)) {
              $exec_summary->save();
              } else {
                $errorexist++;
           Yii::$app->session->addFlash('warning', 'uraian exec_summary ' . $error . ' : jumlah karakter ' . strlen(str_replace(' ','',strip_tags($exec_summary->textvalue))));
              if ($error == 'terlalu panjang' || $error == 'terlalu pendek')
                  {
                    $exec_summary->save();
              
                  }
              }

            if (null !== $kekuatan) {
                $kekuatan->textvalue = $post['AssessmentReport']['kekuatan'];
            } else {
                $kekuatan = new ProjectAssessmentResult();
                $kekuatan->project_assessment_id = $project_assessment->id;
                $kekuatan->type = 'kekuatan';
                $kekuatan->textvalue = $post['AssessmentReport']['kekuatan'];
            }

            if ($stringvalidator->validate(str_replace(' ','',strip_tags($kekuatan->textvalue)), $error)) {
              $kekuatan->save();
              } else {
                $errorexist++;
                  Yii::$app->session->addFlash('warning', 'uraian kekuatan ' . $error . ' : jumlah karakter ' . strlen(str_replace(' ','',strip_tags($kekuatan->textvalue))));
                  if ($error == 'terlalu panjang' || $error == 'terlalu pendek')
                  {
                    $kekuatan->save();
                  
                  }
              }

            if (null !== $kelemahan) {
                $kelemahan->textvalue = $post['AssessmentReport']['kelemahan'];

            } else {
                $kelemahan = new ProjectAssessmentResult();
                $kelemahan->project_assessment_id = $project_assessment->id;
                $kelemahan->type = 'kelemahan';
                $kelemahan->textvalue = $post['AssessmentReport']['kelemahan'];
   
            }
            if ($stringvalidator->validate(str_replace(' ','',strip_tags($kelemahan->textvalue)), $error)) {
              $kelemahan->save();
              } else {
                $errorexist++;
           Yii::$app->session->addFlash('warning', 'uraian kelemahan ' . $error . ' : jumlah karakter ' . strlen(str_replace(' ','',strip_tags($kelemahan->textvalue))));
              if ($error == 'terlalu panjang' || $error == 'terlalu pendek')
                  {
                    $kelemahan->save();
                   
                  }
              }


            if (null !== $saran_pengembangan) {
                $saran_pengembangan->textvalue = $post['saranpengembangan'];

            } else {
                $saran_pengembangan = new ProjectAssessmentResult();
                $saran_pengembangan->project_assessment_id = $project_assessment->id;
                $saran_pengembangan->type = 'saran_pengembangan';
                $saran_pengembangan->textvalue = $post['saranpengembangan'];

            }

            if ($stringvalidator->validate(str_replace(' ','',strip_tags($saran_pengembangan->textvalue)), $error)) {
              $saran_pengembangan->save();
              } else {
                $errorexist++;
           Yii::$app->session->addFlash('warning', 'uraian saran_pengembangan ' . $error . ' : jumlah karakter ' . strlen(str_replace(' ','',strip_tags($saran_pengembangan->textvalue))));
              if ($error == 'terlalu panjang' || $error == 'terlalu pendek')
                  {
                    $saran_pengembangan->save();

                  }
              }
        }
         
            foreach ($post as $key => $value) {
                $keyx = explode('_', $key);
                //echo $key;
                //echo '<br/>';
                if ($keyx[0] == 'uraiankompetensigram')
                {
                    echo $keyx[1];
                    $project_assessment = ProjectAssessment::find()->andWhere(['activity_id' => $id])->One();
                    $result = Kompetensigram::find()
                    ->andWhere(['project_assessment_id' => $project_assessment->id])
                    ->andWhere(['type'=>'kompetensigram'])->andWhere(['key' => $keyx[1]])->One();



                                if (null !== $result) {
                                    $result->textvalue = $value;
                            
                                } else {
                                    $result = new Kompetensigram();
                                    $result->project_assessment_id = $project_assessment->id;
                                    $result->type = 'kompetensigram';
                                    $result->key = $keyx[1];
                                    $result->textvalue = $value;
                     
                                }
            if ($stringvalidator->validate(str_replace(' ','',strip_tags($result->textvalue)), $error)) {
              //echo 'uraian kesave';
              $result->save();
              } else {
                //echo 'uraian ga kesave';
                $errorexist++;
           Yii::$app->session->addFlash('warning', 'uraian '. $result->key .' ' . $error . ' : jumlah karakter ' . strlen(str_replace(' ','',strip_tags($result->textvalue))));
              if ($error == 'terlalu panjang' || $error == 'terlalu pendek')
                  {
                    $result->save();
                  }
              }
                }
           
            }

return $errorexist;


    }

    public function actionSoreturned($id)
    {

              if(isset($_POST)){
            $errorexist = $this->save($id, $_POST);
            $newlog = new Log();
        $newlog->user_id = Yii::$app->user->id;
        $newlog->controller = 'activity';
        $newlog->action = 'so_returned';
        $newlog->type = 'assessment';
  $newlog->timestamp = new Expression('NOW()');
  $newlog->save();



    $activity_status = ProjectActivityMeta::find()->andWhere(['project_activity_id' => $id])
    ->andWhere(['type' => 'assessment'])
            ->andWhere(['key' => 'status'])->One();
            
//echo '<br/>errro : ' . $errorexist;
            
          if ($errorexist > 0) {
Yii::$app->session->addFlash('danger', 'Status belum berubah. jumlah requirement yang belum terpenuhi = ' . $errorexist);
          } else {
                        if (null !== $activity_status) {
                $activity_status->value = 'so_returned';
                $activity_status->save();
            } else {
                $activity_status = new ProjectActivityMeta();
                $activity_status->project_activity_id = $id;
                $activity_status->type = 'assessment';
                $activity_status->key = 'status';
                $activity_status->value = 'so_returned';
                $activity_status->save();
            }

            $assessment = ProjectAssessment::find()->andWhere(['activity_id' => $id])->One();
            $this->snapshot($assessment->id, 'so_returned');

          Yii::$app->session->setFlash('success', 'Returned by SO -> Success');

          }
       return $this->redirect(Yii::$app->request->referrer);
          
        } 

        else {
          echo 'NO POST';
        }

   

    }


    public function actionSosaved($id)
    {

              if(isset($_POST)){
            $errorexist = $this->save($id, $_POST);
            $newlog = new Log();
        $newlog->user_id = Yii::$app->user->id;
        $newlog->controller = 'activity';
        $newlog->action = 'under_review';
        $newlog->type = 'assessment';
  $newlog->timestamp = new Expression('NOW()');
  $newlog->save();



    $activity_status = ProjectActivityMeta::find()->andWhere(['project_activity_id' => $id])
    ->andWhere(['type' => 'assessment'])
            ->andWhere(['key' => 'status'])->One();
            
//echo '<br/>errro : ' . $errorexist;
            
          if ($errorexist > 0) {
Yii::$app->session->addFlash('danger', 'Status belum berubah. jumlah requirement yang belum terpenuhi = ' . $errorexist);
          } else {
                        if (null !== $activity_status) {
                $activity_status->value = 'under_review';
                $activity_status->save();
            } else {
                $activity_status = new ProjectActivityMeta();
                $activity_status->project_activity_id = $id;
                $activity_status->type = 'assessment';
                $activity_status->key = 'status';
                $activity_status->value = 'under_review';
                $activity_status->save();
            }

            $assessment = ProjectAssessment::find()->andWhere(['activity_id' => $id])->One();
            $this->snapshot($assessment->id, 'under_review');

          Yii::$app->session->setFlash('success', 'saved');

          }
       return $this->redirect(Yii::$app->request->referrer);
          
        } 

        else {
          echo 'NO POST';
        }
/*
   echo '<pre>';
print_r($_POST);
*/

    }


    public function actionSoreviewed($id)
    {

              if(isset($_POST)){
            $errorexist = $this->save($id, $_POST);
            $newlog = new Log();
        $newlog->user_id = Yii::$app->user->id;
        $newlog->controller = 'activity';
        $newlog->action = 'so_reviewed';
        $newlog->type = 'assessment';
  $newlog->timestamp = new Expression('NOW()');
  $newlog->save();



    $activity_status = ProjectActivityMeta::find()->andWhere(['project_activity_id' => $id])
    ->andWhere(['type' => 'assessment'])
            ->andWhere(['key' => 'status'])->One();
            
//echo '<br/>errro : ' . $errorexist;
            
          if ($errorexist > 0) {
Yii::$app->session->addFlash('danger', 'Status belum berubah. jumlah requirement yang belum terpenuhi = ' . $errorexist);
          } else {
                        if (null !== $activity_status) {
                $activity_status->value = 'so_reviewed';
                $activity_status->save();
            } else {
                $activity_status = new ProjectActivityMeta();
                $activity_status->project_activity_id = $id;
                $activity_status->type = 'assessment';
                $activity_status->key = 'status';
                $activity_status->value = 'so_reviewed';
                $activity_status->save();
            }

            $assessment = ProjectAssessment::find()->andWhere(['activity_id' => $id])->One();
            $this->snapshot($assessment->id, 'so_reviewed');

          Yii::$app->session->setFlash('success', 'Reviewed by SO -> Success');

          }
       return $this->redirect(Yii::$app->request->referrer);
          
        } 

        else {
          echo 'NO POST';
        }

   

    }


    public function actionSoreviewedlama($id)
    {
        if(isset($_POST)){


        if (isset($_POST['AssessmentReport'])) {
            $project_assessment = ProjectAssessment::find()->andWhere(['activity_id' => $id])->One();
            $exec_summary = ProjectAssessmentResult::find()
            ->andWhere(['project_assessment_id' => $project_assessment->id])
            ->andWhere(['type' => 'executive_summary'])->One();
            if (null !== $exec_summary) {
                $exec_summary->textvalue = $_POST['AssessmentReport']['executive_summary'];
                $exec_summary->save();
            } else {
                $exec_summary = new ProjectAssessmentResult();
                $exec_summary->project_assessment_id = $project_assessment->id;
                $exec_summary->type = 'executive_summary';
                $exec_summary->textvalue = $_POST['AssessmentReport']['executive_summary'];
                $exec_summary->save();
            }
        }

            $post = $_POST;
            foreach ($post as $key => $value) {
                $keyx = explode('_', $key);
                if ($keyx[0] == 'uraian')
                {
                //    echo $keyx[1];
                    $project_assessment = ProjectAssessment::find()->andWhere(['activity_id' => $id])->One();
                    $result = ProjectAssessmentResult::find()
                    ->andWhere(['project_assessment_id' => $project_assessment->id])
                    ->andWhere(['type'=>'kompetensigram'])->andWhere(['key' => $keyx[1]])->One();
                    if (null !== $result) {
                        $result->textvalue = $value;
                        $result->save();
                    } else {
                        $result = new ProjectAssessmentResult();
                        $result->project_assessment_id = $project_assessment->id;
                        $result->type = 'kompetensigram';
                        $result->key = $keyx[1];
                        $result->textvalue = $value;
                        $result->save();
                    }
                }
                # code...
                //echo $key;
           
            }

            $activity_status = ProjectActivityMeta::find()->andWhere(['project_activity_id' => $id])->andWhere(['type' => 'assessment'])
            ->andWhere(['key' => 'status'])->One();
            if (null !== $activity_status) {
                $activity_status->value = 'so_reviewed';
                $activity_status->save();
            } else {
                $activity_status = new ProjectActivityMeta();
                $activity_status->project_activity_id = $id;
                $activity_status->type = 'assessment';
                $activity_status->key = 'status';
                $activity_status->value = 'so_reviewed';
                $activity_status->save();
            }

        }

        $newlog = new Log();
        $newlog->user_id = Yii::$app->user->id;
        $newlog->controller = 'activity';
        $newlog->action = 'so_reviewed';
        $newlog->type = 'assessment';
  $newlog->timestamp = new Expression('NOW()');
  $newlog->save();

Yii::$app->session->setFlash('success', 'Data is reviewed by SO');
        return $this->redirect(Yii::$app->request->referrer);


    }

    public function actionSoreturnedlama($id)
    {
        if(isset($_POST)){


        if (isset($_POST['AssessmentReport'])) {
            $project_assessment = ProjectAssessment::find()->andWhere(['activity_id' => $id])->One();
            $exec_summary = ProjectAssessmentResult::find()
            ->andWhere(['project_assessment_id' => $project_assessment->id])
            ->andWhere(['type' => 'executive_summary'])->One();
            if (null !== $exec_summary) {
                $exec_summary->textvalue = $_POST['AssessmentReport']['executive_summary'];
                $exec_summary->save();
            } else {
                $exec_summary = new ProjectAssessmentResult();
                $exec_summary->project_assessment_id = $project_assessment->id;
                $exec_summary->type = 'executive_summary';
                $exec_summary->textvalue = $_POST['AssessmentReport']['executive_summary'];
                $exec_summary->save();
            }
        }

            $post = $_POST;
            foreach ($post as $key => $value) {
                $keyx = explode('_', $key);
                if ($keyx[0] == 'uraian')
                {
                //    echo $keyx[1];
                    $project_assessment = ProjectAssessment::find()->andWhere(['activity_id' => $id])->One();
                    $result = ProjectAssessmentResult::find()
                    ->andWhere(['project_assessment_id' => $project_assessment->id])
                    ->andWhere(['type'=>'kompetensigram'])->andWhere(['key' => $keyx[1]])->One();
                    if (null !== $result) {
                        $result->textvalue = $value;
                        $result->save();
                    } else {
                        $result = new ProjectAssessmentResult();
                        $result->project_assessment_id = $project_assessment->id;
                        $result->type = 'kompetensigram';
                        $result->key = $keyx[1];
                        $result->textvalue = $value;
                        $result->save();
                    }
                }
                # code...
                //echo $key;
           
            }

            $activity_status = ProjectActivityMeta::find()->andWhere(['project_activity_id' => $id])->andWhere(['type' => 'assessment'])
            ->andWhere(['key' => 'status'])->One();
            if (null !== $activity_status) {
                $activity_status->value = 'so_returned';
                $activity_status->save();
            } else {
                $activity_status = new ProjectActivityMeta();
                $activity_status->project_activity_id = $id;
                $activity_status->type = 'assessment';
                $activity_status->key = 'status';
                $activity_status->value = 'so_returned';
                $activity_status->save();
            }

        }
        $newlog = new Log();
        $newlog->user_id = Yii::$app->user->id;
        $newlog->controller = 'activity';
        $newlog->action = 'so_returned';
        $newlog->type = 'assessment';
  $newlog->timestamp = new Expression('NOW()');
  $newlog->save();
Yii::$app->session->setFlash('danger', 'Data is returned to assessor');
        return $this->redirect(Yii::$app->request->referrer);


    }

    public function actionSave($id)
    {
        if(isset($_POST)){
            $errorexist = $this->save($id, $_POST);
            $newlog = new Log();
        $newlog->user_id = Yii::$app->user->id;
        $newlog->controller = 'activity';
        $newlog->action = 'save';
        $newlog->type = 'assessment';
  $newlog->timestamp = new Expression('NOW()');
  $newlog->save();

              $activity_status = ProjectActivityMeta::find()->andWhere(['project_activity_id' => $id])->andWhere(['type' => 'assessment'])
            ->andWhere(['key' => 'status'])->One();
            if (null !== $activity_status) {
                $activity_status->value = 'open';
                $activity_status->save();
            } else {
                $activity_status = new ProjectActivityMeta();
                $activity_status->project_activity_id = $id;
                $activity_status->type = 'assessment';
                $activity_status->key = 'status';
                $activity_status->value = 'open';
                $activity_status->save();
            }

Yii::$app->session->setFlash('success', 'Data tersimpan. Harap perhatikan warning diatas sebelum melakukan submit final');
        return $this->redirect(Yii::$app->request->referrer);
      } else {
        echo 'NO POST';
      }

    }


    public function actionFinalize($id)
    {
        if(isset($_POST)){
            $errorexist = $this->save($id, $_POST);
            $newlog = new Log();
        $newlog->user_id = Yii::$app->user->id;
        $newlog->controller = 'activity';
        $newlog->action = 'done';
        $newlog->type = 'assessment';
  $newlog->timestamp = new Expression('NOW()');
  $newlog->save();



    $activity_status = ProjectActivityMeta::find()->andWhere(['project_activity_id' => $id])
    ->andWhere(['type' => 'assessment'])
            ->andWhere(['key' => 'status'])->One();
            
//echo '<br/>errro : ' . $errorexist;
            
          if ($errorexist > 0) {
Yii::$app->session->addFlash('danger', 'Data BELUM ter-submit. jumlah requirement yang belum terpenuhi = ' . $errorexist);
          } else {
                        if (null !== $activity_status) {
                $activity_status->value = 'done';
                $activity_status->save();
            } else {
                $activity_status = new ProjectActivityMeta();
                $activity_status->project_activity_id = $id;
                $activity_status->type = 'assessment';
                $activity_status->key = 'status';
                $activity_status->value = 'done';
                $activity_status->save();
            }

            $assessment = ProjectAssessment::find()->andWhere(['activity_id' => $id])->One();
            $this->snapshot($assessment->id, 'finalize');

          Yii::$app->session->setFlash('success', 'Data is FINALIZED and Readonly');

          }
       return $this->redirect(Yii::$app->request->referrer);
          
        } 

        else {
          echo 'NO POST';
        }

   
    }

    /**
     * Creates a new Activity model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProjectActivity();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Activity model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Activity model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    public function beforeAction($action) {
/*
if (isset($_GET['id'])){
        $profile_model = Profile::find()->andWhere(['user_id' => Yii::$app->user->id])->One();
        $hasrole = ProjectActivityMeta::find()->andWhere(['project_activity_id' => $_GET['id']])
        ->andWhere(['type' => 'general'])
        ->andWhere(['value' => $profile_model->id])
        ->andWhere(['in', 'key',['assessor', 'secondopinion','admin']])->One();
        if (isset($hasrole)) {
                return parent::beforeAction($action);
            } else {
                Yii::$app->session->setFlash('danger', 'You dont have access');
                //return $this->redirect('http://www.google.com');
            }
} else {
    return parent::beforeAction($action);
}
///echo $action->id;
*/
    return parent::beforeAction($action);
}

    

    public function actionPrint($id)
    {


        

        $data = [];
        $model = $this->findModel($id);
        $model2 = new ProjectActivity;
         $uraian_model = new ProjectAssessmentResult;



        //SATU PROJECT SATU ASSESSMENT MODEL
        $project_assessment_model = ProjectAssessment::find()
                                        ->andWhere(['activity_id' => $id])
                                        ->andWhere(['status' => 'active'])
                                        ->One();

        $assessment_report = new AssessmentReport();
        $exec_summary_model = ProjectAssessmentResult::find()->andWhere(['type' => 'executive_summary'])
        ->andWhere(['project_assessment_id' =>$project_assessment_model->id])->One();
        $assessment_report->executive_summary = $exec_summary_model->textvalue;
        $catalog = $project_assessment_model->catalog_id;

        
        $catalog_metas = CatalogMeta::find()->andWhere(['catalog_id' => $catalog])->All();


            foreach ($catalog_metas as $cm_key => $cm_value) {
                if ($cm_value['type'] == 'kompetensigram'){
                    $newdata = new ProjectAssessmentResult;
                    $newdata->project_assessment_id = $project_assessment_model->id;
                    $newdata->type = 'type';
                    $newdata->key = 'key';
                    array_push($data, $newdata);
                }
            }

            $query = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $project_assessment_model->id])
                    ->andWhere(['type' => 'kompetensigram']);

                $dataProvider = new ActiveDataProvider([
                    'query' => $query,
                    'pagination' => [
                        'pageSize' => 10,
                    ],
                    'sort' => [
                        //'attributes' => ['id', 'name'],
                    ],
                ]);




            $query2 = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $project_assessment_model->id])
                    ->andWhere(['type' => 'psikogram']);

$psikogramDataProvider = new ActiveDataProvider([
    'query' => $query2,
    'pagination' => [
        'pageSize' => 10,
    ],
    'sort' => [
        //'attributes' => ['id', 'name'],
    ],
]);





$result_object['kompetensigram'] = [];
$result_object['psikogram'] = [];
$result_object['profile_meta'] = [];
$result_object['executive_summary'] = $assessment_report->executive_summary;

$kompetensigram_models = $dataProvider->getModels();
$psikogram_models = $psikogramDataProvider->getModels();



$pa_id = ProjectActivityMeta::find()->andWhere(['project_activity_id' =>$id])->andWhere(['type' => 'general'])
->andWhere(['key' => 'assessee'])->One();

$profile_basic = Profile::find()->andWhere(['id' => $pa_id->value])->One();

$result_object['firstname'] = $profile_basic->first_name;
$result_object['last_name'] = $profile_basic->last_name;
$result_object['birthdate'] = $profile_basic->birthdate;
$result_object['gender'] = $profile_basic->gender;




$profilemetas = ProfileMeta::find()->andWhere(['profile_id' => $pa_id->value])->All();
foreach ($profilemetas as $prof_meta_key => $prof_meta_value) {
    if ($prof_meta_value->type == 'work') {
        $result_object['profile_meta']['work'][$prof_meta_value->key] = $prof_meta_value->value;
    } else if ($prof_meta_value->type == 'address') {
        $result_object['profile_meta']['address'][$prof_meta_value->key] = $prof_meta_value->value;
    } else if ($prof_meta_value->type == 'contact') {
        $result_object['profile_meta']['contact'][$prof_meta_value->key] = $prof_meta_value->value;
    } else if ($prof_meta_value->type == 'personal') {
        $result_object['profile_meta']['personal'][$prof_meta_value->key] = $prof_meta_value->value;
    } else if ($prof_meta_value->type == 'education') {
        $result_object['profile_meta']['education'][$prof_meta_value->key] = $prof_meta_value->value;
    }
}
foreach ($kompetensigram_models as $kompkey => $kompvalue) {
    $result_object['kompetensigram'][$kompvalue->key]['lki'] = $kompvalue->value;
    $x = CatalogMeta::find()->andWhere(['type' => 'kompetensigram'])->andWhere(['key' => 'kompetensi'])
    ->andWhere(['value' => $kompvalue->key])->One();
$result_object['kompetensigram'][$kompvalue->key]['lkj'] = $x->attribute_1;
}

foreach ($psikogram_models as $psikey => $psivalue) {
    $result_object['psikogram'][$psivalue->key]['lki'] = $psivalue->value;
    $y = CatalogMeta::find()->andWhere(['type' => 'psikogram'])->andWhere(['key' => 'aspek'])
    ->andWhere(['value' => $psivalue->key])->One();
$result_object['psikogram'][$psivalue->key]['lkj'] = $y->attribute_1;
}




    $pdf = new Pdf([
        'mode' => Pdf::MODE_ASIAN, // leaner size using standard fonts
        'content' => $this->renderPartial('privacy',
    ['objectPrint'=>$result_object]
    ),

        'cssFile' => './css/ReportPDF.css' ,
        'cssFile' => './css/psikogramTable.css',
       
        
        //'cssInline' => '.Judul{text-align: center}',
        'options' => [
            'title' => 'Laporan Asesmen Potensi Dan Kompetensi',
            'subject' => 'Subject : Laporan Asesmen Potensi Dan Kompetensi'
        ],
        'methods' => [
            'SetHTMLHeader'=> ['<p align="right"><img src="./images/ppsdm-logo-atas.png"></p>'],                          
            //'SetHeader' => ['Generated By: Krajee Pdf Component||Generated On: ' . date("r")],
            'SetFooter' => ['Pendekatan & Metodologi Asessmen Kompetensi Pejabat struktural di Kementrian Kesehatan'.'| Hal. {PAGENO}|'],
        ]
    ]);
    return $pdf->render();
    //echo '<pre>';
    //print_r($result_object);
    }

    /**
     * Finds the Activity model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Activity the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProjectActivity::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionPdf($id)
    {


        $data = [];
        $model = $this->findModel($id);
        $model2 = new ProjectActivity;
         $uraian_model = new ProjectAssessmentResult;



        //SATU PROJECT SATU ASSESSMENT MODEL
        $project_assessment_model = ProjectAssessment::find()
                                        ->andWhere(['activity_id' => $id])
                                        ->andWhere(['status' => 'active'])
                                        ->One();

        $nomor_test = ProjectAssessmentResult::find()->andWhere(['type' => 'inventory'])
        ->andWhere(['project_assessment_id' =>$project_assessment_model->id])
        ->andWhere(['key'=>'nomor_test'])
        ->One();  

       if (isset($nomor_test->value)) {$result_object['nomor_test'] = explode(" ", $nomor_test->value, 2)[0]; } else { $result_object['nomor_test'] =  '0001';  }
       // $result_object['nomor_test'] = $nomor_test->value;

        $tanggal_test = ProjectAssessmentResult::find()->andWhere(['type' => 'inventory'])
        ->andWhere(['project_assessment_id' =>$project_assessment_model->id])
        ->andWhere(['key'=>'tanggal_test'])
        ->One(); 

        if (!isset($tanggal_test->value)) { $result_object['tanggal_test']= '04092017';} else {$result_object['tanggal_test'] = $tanggal_test->value; }
            

        $assessment_report = new AssessmentReport();
        $exec_summary_model = ProjectAssessmentResult::find()->andWhere(['type' => 'executive_summary'])
        ->andWhere(['project_assessment_id' =>$project_assessment_model->id])->One();

        $kekuatan_model = ProjectAssessmentResult::find()->andWhere(['type' => 'kekuatan'])
        ->andWhere(['project_assessment_id' =>$project_assessment_model->id])->One();

        $kelemahan_model = ProjectAssessmentResult::find()->andWhere(['type' => 'kelemahan'])
        ->andWhere(['project_assessment_id' =>$project_assessment_model->id])->One();

        $saran_pengembangan_model = ProjectAssessmentResult::find()->andWhere(['type' => 'saran_pengembangan'])
        ->andWhere(['project_assessment_id' =>$project_assessment_model->id])->One();


        $assessment_report->executive_summary =  isset($exec_summary_model->textvalue) ? $exec_summary_model->textvalue : '';
        $assessment_report->kekuatan = isset($kekuatan_model->textvalue) ? $kekuatan_model->textvalue : '';
        $assessment_report->kelemahan = isset($kelemahan_model->textvalue)?$kelemahan_model->textvalue : '';
        $assessment_report->saran_pengembangan = isset($saran_pengembangan_model->textvalue) ?$saran_pengembangan_model->textvalue: '' ;
        $catalog = isset($project_assessment_model->catalog_id)? $project_assessment_model->catalog_id: '0';

        
        $catalog_metas = CatalogMeta::find()->andWhere(['catalog_id' => $catalog])->All();


            foreach ($catalog_metas as $cm_key => $cm_value) {
                if ($cm_value['type'] == 'kompetensigram'){
                    $newdata = new ProjectAssessmentResult;
                    $newdata->project_assessment_id = $project_assessment_model->id;
                    $newdata->type = 'type';
                    $newdata->key = 'key';
                    array_push($data, $newdata);
                }
            }

            $query = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $project_assessment_model->id])
                    ->andWhere(['type' => 'kompetensigram']);

                $dataProvider = new ActiveDataProvider([
                    'query' => $query,
                    'pagination' => [
                        'pageSize' => 10,
                    ],
                    'sort' => [
                        //'attributes' => ['id', 'name'],
                    ],
                ]);




            $query2 = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $project_assessment_model->id])
                    ->andWhere(['type' => 'psikogram']);

$psikogramDataProvider = new ActiveDataProvider([
    'query' => $query2,
    'pagination' => [
        'pageSize' => 10,
    ],
    'sort' => [
        //'attributes' => ['id', 'name'],
    ],
]);





$result_object['kompetensigram'] = [];
$result_object['psikogram'] = [];
$result_object['profile_meta'] = [];
$result_object['executive_summary'] = $assessment_report->executive_summary;
$result_object['kekuatan'] = $assessment_report->kekuatan;
$result_object['kelemahan'] = $assessment_report->kelemahan;
$result_object['saran_pengembangan'] = $assessment_report->saran_pengembangan;
$result_object['catalog_id'] = $catalog;

$kompetensigram_models = $dataProvider->getModels();
$psikogram_models = $psikogramDataProvider->getModels();



$pa_id = ProjectActivityMeta::find()->andWhere(['project_activity_id' =>$id])->andWhere(['type' => 'general'])
->andWhere(['key' => 'assessee'])->One();

$profile_basic = Profile::find()->andWhere(['id' => $pa_id->value])->One();

$result_object['firstname'] = $profile_basic->first_name;
$result_object['last_name'] = $profile_basic->last_name;
$result_object['birthdate'] = $profile_basic->birthdate;
$result_object['gender'] = $profile_basic->gender;
$result_object['profile_id'] = $profile_basic->id;

$assessor_id = ProjectActivityMeta::find()->andWhere(['project_activity_id' =>$id])->andWhere(['type' => 'general'])
->andWhere(['key' => 'assessor'])
->andWhere(['!=','value',2])
->One();
$result_object['assessor_id'] = $assessor_id->value;

$assessor_name = Profile::find()->andWhere(['id' => $assessor_id->value])->One();
$result_object['assessor_name'] = $assessor_name->first_name;


$profilemetas = ProfileMeta::find()->andWhere(['profile_id' => $pa_id->value])->All();
foreach ($profilemetas as $prof_meta_key => $prof_meta_value) {
    if ($prof_meta_value->type == 'work') {
        $result_object['profile_meta']['work'][$prof_meta_value->key] = $prof_meta_value->value;
    } else if ($prof_meta_value->type == 'address') {
        $result_object['profile_meta']['address'][$prof_meta_value->key] = $prof_meta_value->value;
    } else if ($prof_meta_value->type == 'contact') {
        $result_object['profile_meta']['contact'][$prof_meta_value->key] = $prof_meta_value->value;
    } else if ($prof_meta_value->type == 'personal') {
        $result_object['profile_meta']['personal'][$prof_meta_value->key] = $prof_meta_value->value;
    } else if ($prof_meta_value->type == 'education') {
        $result_object['profile_meta']['education'][$prof_meta_value->key] = $prof_meta_value->value;
    }
    
}
foreach ($kompetensigram_models as $kompkey => $kompvalue) {
    $result_object['kompetensigram'][$kompvalue->key]['lki'] = $kompvalue->value;
    $result_object['kompetensigram'][$kompvalue->key]['uraian'] = $kompvalue->textvalue;
    $x = CatalogMeta::find()
->andWhere(['catalog_id' => $catalog])
    ->andWhere(['type' => 'kompetensigram'])->andWhere(['key' => 'kompetensi'])
    ->andWhere(['value' => $kompvalue->key])->One();
$result_object['kompetensigram'][$kompvalue->key]['lkj'] = $x->attribute_1;
}

foreach ($psikogram_models as $psikey => $psivalue) {
    $result_object['psikogram'][$psivalue->key]['lki'] = $psivalue->value;
    $y = CatalogMeta::find()
->andWhere(['catalog_id' => $catalog])
    ->andWhere(['type' => 'psikogram'])->andWhere(['key' => 'aspek'])
    ->andWhere(['value' => $psivalue->key])->One();
$result_object['psikogram'][$psivalue->key]['lkj'] = $y->attribute_1;
}


/*
$deskripsi = RefAssessmentDictionary::find()
->andWhere(['type' => 'kompetensigram'])
->andWhere(['key'=> 'kompetensi'])
->All();

$result_object['deskripsi'][] = $deskripsi;
*/

$kompetensiSQLDataProvider = new SqlDataProvider([
    'sql' => 'select * from (select table1.id,table1.project_assessment_id, 
  table1.type,table1.key,table1.value,table1.attribute_1,table1.attribute_2,table1.attribute_3,
   table1.catalog_id, catalog_meta.attribute_3 * 1 as ordering,
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

$psikogram_models= $psikogramSQLDataProvider->getModels();
$result_object['psikogramSQLDataProvider'] = $psikogram_models;



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
   
   $Pa = ProjectAssessment::find()->andWhere(['activity_id'=> $_GET['id']])->One();
   
   $PArp = ProjectAssessmentResult::find()->andWhere(['type'=>'psikogram'])->andWhere(['project_assessment_id'=>$Pa->id])->Sum('value');
   $PArk = ProjectAssessmentResult::find()->andWhere(['type'=>'kompetensigram'])->andWhere(['project_assessment_id'=>$Pa->id])->Sum('value');

   $sumC =     CatalogMeta::find()->andWhere(['catalog_id'=>$Pa->catalog_id])->andWhere(['type'=>'kompetensigram'])->andWhere(['key'=>'kompetensi'])->Sum('attribute_1');
   


$result_object['PArp'] = $PArp;
$result_object['PArk'] = $PArk;
$result_object['sumC'] = $sumC;

$kompetensigram_models = $kompetensiSQLDataProvider->getModels();
$result_object['kompetensiSQLDataProvider'] = $kompetensigram_models;

foreach ($kompetensigram_models as $psikey => $psivalue) {
    
    $refdict = RefAssessmentDictionary::find()->andWhere(['type' => 'kompetensigram'])->andWhere(['key' => 'kompetensi'])
    ->andWhere(['value' => $psivalue['key']])->One();
    $result_object['kompetensigramDict'][$psivalue['key']]['attribute_1'] = $refdict->attribute_1;
    $result_object['kompetensigramDict'][$psivalue['key']]['textvalue'] = $refdict->textvalue;

    }





$report=$this->renderPartial('pdf',['objectPrint'=>$result_object, 'result_object' => $result_object, ]);


echo $report;


//echo '<pre>';
//print_r($result_object);
    }


    public function actionGetfile($id)
    {


        $pa_id = ProjectActivityMeta::find()->andWhere(['project_activity_id' =>$id])->andWhere(['type' => 'general'])
        ->andWhere(['key' => 'assessee'])->One();   
        $profile_basic = Profile::find()->andWhere(['id' => $pa_id->value])->One();
        $search  = array('.', ' ', ',');
        $replace = array('', '_', '');

        
        $filename = trim(str_replace($search, $replace, $profile_basic->first_name)).".pdf";

        /* GET METHOD
        $base64url = base64_encode('{url:"http://projects.ppsdm.com/index.php/projects/activity/pdf?id='.$id.'",renderType:"pdf",paperSize :"A4"}');
        $phantomPdf = "https://api.phantomjscloud.com/api/browser/v2/ak-e6rha-y3pt8-t036y-443eq-52eyk/?requestBase64=".$base64url;
        $filecontent=file_get_contents($phantomPdf);
        header("Content-type:application/pdf");
        header("Content-disposition: attachment; filename=$filename");
        header("Pragma: no-cache");
        echo $filecontent;
        */

        $url = 'https://api.phantomjscloud.com/api/browser/v2/ak-sxjfq-71djm-5h900-r9z2s-0dd0h/';
        $payload = '
        {
            "url":"http://projects.ppsdm.com/index.php/projects/activity/pdf?id='.$id.'",
            "renderType":"pdf",
            "renderSettings": {
                "quality": 70,
                "pdfOptions": {
                    "border": null,
                    "footer": {
                        "firstPage": "",
                        "height": "1cm",
                        "lastPage": null,
                        "onePage": null,
                        "repeating": "Halaman %pageNum%  dari %numPages%"
                    },
                    "format": "A4",
                    "header": "this is header",
                    "height": "210mm",
                    "orientation": "portrait",
                    "width": "210mm"
                },
				"viewport": {
					"height": 1280,
					"width": 1280
				},
				"zoomFactor": 10,
            },
        }'
        ;
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/pdf\r\n",
                'method'  => 'POST',
                'content' => $payload
            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === FALSE) { /* Handle error */ }
        header("Content-type:application/pdf");
        header("Content-disposition: attachment; filename=$filename");
        header("Pragma: no-cache");
        echo $result;
 
    }



    public function actionAddassessor($id)
    {


                          $assessor_model = ProjectActivityMeta::find()->andWhere(['project_activity_id' => $id])
                          ->andWhere(['type' => 'general'])->andWhere(['key' => 'assessor'])
                          ->andWhere([ '<>','value', '2'])
                          ->One();

                          if (null == $assessor_model)
                          {
                            $assessor_model = new ProjectActivityMeta;
                            $assessor_model->project_activity_id = $id;
                            $assessor_model->type = 'general';
                            $assessor_model->key = 'assessor';

                          }

                          if($_POST)
                          {
                                $assessor_model->value = $_POST['ProjectActivityMeta']['value'];
                                $assessor_model->save();
                            //echo '<pre>';
                            //print_r($_POST);
   Yii::$app->session->addFlash('success', 'assessor set');
                                return $this->redirect(Yii::$app->request->referrer);


                          } else {



        return $this->render('addassessor', [
          'assessor_model' => $assessor_model,
            //'searchModel' => $searchModel,
            //'dataProvider' => $dataProvider,
        ]);
      }
    }
  public function actionMapassessor($id)
  {
    
      /*$query = ProjectActivity::find()->andWhere([])
        $searchModel = new ProjectActivitySearch();
        $params = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search($params);

        return $this->render('mapassessor', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
*/
  }


  public function actionCakimpdf($id)
    {


        $data = [];
        $model = $this->findModel($id);

        $profi = Profile::find()->andWhere(['user_id' => Yii::$app->user->id])->One();
        $is_assessor = ProjectActivityMeta::find()
        ->andWhere(['project_activity_id' => $id])
        ->andWhere(['type' => 'general'])
        //->andWhere(['key' => 'assessor'])
        ->andWhere(['value' => $profi->id])->One();

        // UNTUK CAKIM //
        $is_assessor = true;
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


            return $this->renderPartial('cakimpdf', [
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



}



