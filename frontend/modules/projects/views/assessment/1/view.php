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

$Pa = ProjectAssessment::find()->andWhere(['activity_id'=> $_GET['id']])->One();

echo '<div style="display: inline-block;">'. Html::a(Yii::t('app', 'Print'), ['pdf', 'id' => $model->id], ['class' => 'btn btn-info']).'</div>';
echo '&nbsp;';
echo '<div style="display: inline-block;">'. Html::a(Yii::t('app', 'Download PDF'), ['getfile', 'id' => $model->id], ['class' => 'btn btn-info']).'</div>';
echo '&nbsp;';
echo '<div style="display: inline-block;">'. Html::a(Yii::t('app', 'SUBMIT ASSESSMENT'), ['', 'id' => $model->id], ['class' => 'btn btn-danger','data' => ['confirm'=> 'Yakin? tidak akan bisa kembali']]).'</div>';
echo '<hr/>';
echo '<div style="display: inline-block;">'. Html::a(Yii::t('app', 'Data Assessee'), ['assessment/datapeserta', 'id' => $Pa->id], ['class' => 'btn btn-info']).'</div>';
echo '&nbsp;';
echo '<div style="display: inline-block;">'. Html::a(Yii::t('app', 'Executive Summary'), ['assessment/exsum', 'id' => $Pa->id], ['class' => 'btn btn-info']).'</div>';
echo '&nbsp;';
echo '<div style="display: inline-block;">'. Html::a(Yii::t('app', 'Psikogram'), ['assessment/psikogram', 'id' => $Pa->id], ['class' => 'btn btn-info']).'</div>';
echo '&nbsp;';
echo '<div style="display: inline-block;">'. Html::a(Yii::t('app', 'Kekuatan'), ['assessment/kekuatan', 'id' => $Pa->id], ['class' => 'btn btn-info']).'</div>';
echo '&nbsp;';
echo '<div style="display: inline-block;">'. Html::a(Yii::t('app', 'Kelemahan'), ['assessment/kelemahan', 'id' => $Pa->id], ['class' => 'btn btn-info']).'</div>';
echo '&nbsp;';
echo '<div style="display: inline-block;">'. Html::a(Yii::t('app', 'Saran Pengembangan'), ['assessment/saran', 'id' => $Pa->id], ['class' => 'btn btn-info']).'</div>';
echo '<h2>Aspek Kompetensi</h2>';
echo '<div style="display: inline-block;">'. Html::a(Yii::t('app', 'Integritas'), ['assessment/integritas', 'id' => $Pa->id, 'lki' => '1'], ['class' => 'btn btn-primary']).'</div>';
echo '&nbsp;';
echo '<div style="display: inline-block;">'. Html::a(Yii::t('app', 'Kerjasama'), ['assessment/kerjasama', 'id' => $Pa->id], ['class' => 'btn btn-primary']).'</div>';
echo '&nbsp;';
echo '<div style="display: inline-block;">'. Html::a(Yii::t('app', 'Komunikasi'), ['assessment/komunikasi', 'id' => $Pa->id], ['class' => 'btn btn-primary']).'</div>';
echo '&nbsp;';
echo '<div style="display: inline-block;">'. Html::a(Yii::t('app', 'Orientasi pada Hasil'), ['assessment/orientasihasil', 'id' => $Pa->id], ['class' => 'btn btn-primary']).'</div>';
echo '&nbsp;';
echo '<div style="display: inline-block;">'. Html::a(Yii::t('app', 'Pelayanan Publik'), ['assessment/pelayananpublik', 'id' => $Pa->id], ['class' => 'btn btn-primary']).'</div>';
echo '&nbsp;';
echo '<div style="display: inline-block;">'. Html::a(Yii::t('app', 'Pengembangan Diri dan Orang Lain'), ['assessment/pengembangandiridanoranglain', 'id' => $Pa->id], ['class' => 'btn btn-primary']).'</div>';
echo '&nbsp;';
echo '<div style="display: inline-block;">'. Html::a(Yii::t('app', 'Mengelola Perubahan'), ['assessment/mengelolaperubahan', 'id' => $Pa->id], ['class' => 'btn btn-primary']).'</div>';
echo '&nbsp;';
echo '<div style="display: inline-block;">'. Html::a(Yii::t('app', 'Pengambilan Keputusan'), ['assessment/pengambilankeputusan', 'id' => $Pa->id], ['class' => 'btn btn-primary']).'</div>';
echo '&nbsp;';
echo '<div style="display: inline-block;">'. Html::a(Yii::t('app', 'Perekat Bangsa'), ['assessment/perekatbangsa', 'id' => $Pa->id], ['class' => 'btn btn-primary']).'</div>';
    $proj_act = ProjectActivity::findOne($_GET['id']);



$options = [1 => '1',2 => '2',3=>'3',4=>'4',5=>'5',6=>'6',7 => '7'];

   $form = ActiveForm::begin([
        'enableAjaxValidation' => true]);
//Notification::notify(Notification::KEY_NEW_MESSAGE, '2', '99');

$statusproject = ProjectActivityMeta::find()
->andWhere(['project_activity_id' => $_GET['id']])
->andWhere(['type' => 'assessment'])
->andWhere(['key' => 'status'])
->One();

                    $assessee_model = ProjectActivityMeta::find()
                    ->andWhere(['project_activity_id' => $_GET['id']])
                    ->andWhere(['type' => 'general'])
                    ->andWhere(['key' => 'assessee'])->One();
                    if (null !== $assessee_model) {
                    $assessee_profile_model = Profile::findOne($assessee_model->value);
                    $profile_id = $assessee_profile_model->id;
    $rumpunjabatan = ProfileMeta::find()
    ->andWhere(['profile_id' => $profile_id])
    ->andWhere(['key' => 'rumpun_skj'])
    ->andWhere(['type' => 'work'])->One();

    $leveljabatan = ProfileMeta::find()
    ->andWhere(['profile_id' => $profile_id])
    ->andWhere(['key' => 'level'])
    ->andWhere(['type' => 'work'])->One();

        $rumpun = ProfileMeta::find()
    ->andWhere(['profile_id' => $profile_id])
    ->andWhere(['key' => 'rumpun'])
    ->andWhere(['type' => 'work'])->One();


    $find_catalog = RefValue::find()->andWhere(['type' => 'catalog-mapping'])->andWhere(['key' => 'catalog_id'])
->andWhere(['attribute_1' => $rumpun->value])
->andWhere(['attribute_2' => $leveljabatan->value])
->One();
if (null !== $find_catalog) {
    $catalog_id = $find_catalog->value;
} else {
    $catalog_id = null;
}


//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Activities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title .'(cat='.$catalog_id . ', assessment='. $Pa->id. ')';


                } else {
                        $profile_id = 'NO-ID';
                }

$user_profile = Profile::find()->andWhere(['user_id' => Yii::$app->user->id])->One();

$is_so = ProjectActivityMeta::find()
->andWhere(['project_activity_id' => $_GET['id']])
->andWhere(['type' => 'general'])
->andWhere(['key' => 'second_opinion'])
->andWhere(['value'=> $user_profile->id])
->One();

$is_assessor = ProjectActivityMeta::find()
->andWhere(['project_activity_id' => $_GET['id']])
->andWhere(['type' => 'general'])
->andWhere(['key' => 'assessor'])
->andWhere(['value'=> $user_profile->id])
->One();


if (null !== $is_so) { //IF SO
        if (($statusproject->value == 'done') || ($statusproject->value == 'so_reviewed') || ($statusproject->value == 'under_review') )
        {
            $readonly = false;
        } else {
            $readonly = true;
        }
} else { //IF ASSESSOR
        if (($statusproject->value == 'new') || ($statusproject->value == 'open') || ($statusproject->value == 'so_returned'))
        {
            $readonly = false;
        } else {
            $readonly = true;
        }
    }
?>
<div class="activity-view">

    <h1><span>
        <?php
        
        echo Html::img('@web/project-uploads/'.$proj_act->project_id.'/photos/'.$profile_id.'.jpg', ['alt' => '--missing image--','style'=> 'max-width:200px;max-height:200px'
            ]);
        ?>
    </span><?= Html::encode($this->title) ?></h1>


<?php




/**
value dibawah ini hanya untuk dummy saat dev saja
*/


 $assessment_report = new AssessmentReport();

echo DetailView::widget([
        'model' => $model,
   //     'mode'=>DetailView::MODE_EDIT,
        'attributes' => [
            [
                'label' => 'Nomor Test',
                'value' => '',
            ],
            [
                'label' => 'Nama Lengkap',
                'format' => 'raw',
                'value' => function($data) use ($form, $readonly){
                    $activity_assessee_model = ProjectActivityMeta::find()
                    ->andWhere(['project_activity_id' => $data->id])
                    ->andWhere(['type' => 'general'])
                    ->andWhere(['key' => 'assessee'])->One();
                    if (null !== $activity_assessee_model) {
                    $assessee_model = Profile::findOne($activity_assessee_model->value);
                    if ($readonly) {
                        $fn = isset($assessee_model->first_name)?$assessee_model->first_name  : '';
                        $ln = isset($assessee_model->last_name) ? $assessee_model->last_name : '';
                    return  $fn . ' ' . $ln;
                    } else {
return $form->field($assessee_model, 'first_name')->textInput(['readonly'=> $readonly])->label('');
                        
                }
                    } else {
                        return 'no profile set for this assessee';
                    }
                }
            ],

            [
                'label' => 'Tanggal Lahir (Wajib diisi)',
                'format' => 'raw',
                'value' => function($data) use ($form, $readonly){


                    $activity_assessee_model = ProjectActivityMeta::find()
                    ->andWhere(['project_activity_id' => $data->id])
                    ->andWhere(['type' => 'general'])
                    ->andWhere(['key' => 'assessee'])->One();
                    if (null !== $activity_assessee_model) {
                    $assessee_model = Profile::findOne($activity_assessee_model->value);

return $form->field($assessee_model, 'birthdate')->textInput(['readonly'=> $readonly])->hint('Tahun-Bulan-Hari. Contoh: 1985-04-21')->label('');
                        //return '';
                    }
                }
            ],


            [
                'label' => 'Tempat lahir (Wajib diisi)',
                 'format' => 'raw',
                'value' => function($data) use ($form, $readonly){

                    $fmt = Yii::$app->formatter;
                    $activity_assessee_model = ProjectActivityMeta::find()
                    ->andWhere(['project_activity_id' => $data->id])
                    ->andWhere(['type' => 'general'])
                    ->andWhere(['key' => 'assessee'])->One();
                    if (null !== $activity_assessee_model) {
                    $assessee_model = Profile::findOne($activity_assessee_model->value);
                    $birthplace = ProfileMeta::find()
                    ->andWhere(['profile_id' => $activity_assessee_model->value])
                    ->andWhere(['type' => 'personal'])
                    ->andWhere(['key' => 'birthplace'])->One();
                    $birthdate = $fmt->asDate($assessee_model->birthdate, 'dd MMMM yyyy');
                    return $form->field($birthplace, 'value')->textInput(['readonly'=> $readonly])->label('');
                    } else {
                        return 'no profile set for this assessee';
                    }
                }
            ],
            [
                'label' => 'Jabatan saat ini',
                'format' => 'raw',
                'value' => function($data) use ($form, $readonly, $assessment_report){
                    $fmt = Yii::$app->formatter;
                    $activity_assessee_model = ProjectActivityMeta::find()
                    ->andWhere(['project_activity_id' => $data->id])
                    ->andWhere(['type' => 'general'])
                    ->andWhere(['key' => 'assessee'])->One();
                    if (null !== $activity_assessee_model) {
                    $assessee_model = Profile::findOne($activity_assessee_model->value);
                    $latest = ProfileMeta::find()
                    ->andWhere(['profile_id' => $activity_assessee_model->value])
                    ->andWhere(['type' => 'work'])
                    ->andWhere(['key' => 'current_position'])->One();
                    //$birthdate = $fmt->asDate($assessee_model->birthdate, 'dd MMMM yyyy');

                    if (null !== $latest){
                        $assessment_report->current_position = $latest->value;
                    } else {

                    }
                    return $form->field($assessment_report, 'current_position')->textInput(['readonly'=> $readonly])->label('');
                    } else {
                        return 'no profile set for this assessee';
                    }
                }
            ],

            [
                'label' => 'Rumpun',
                'value' => function($data) use ($form, $readonly){
                    $activity_assessee_model = ProjectActivityMeta::find()
                    ->andWhere(['project_activity_id' => $data->id])
                    ->andWhere(['type' => 'general'])
                    ->andWhere(['key' => 'assessee'])->One();
                    if (null !== $activity_assessee_model) {
                    $assessee_model = Profile::findOne($activity_assessee_model->value);
                    $unit = ProfileMeta::find()
                    ->andWhere(['profile_id' => $activity_assessee_model->value])
                    ->andWhere(['type' => 'work'])
                    ->andWhere(['key' => 'unit'])->One();
                    return isset($unit->value) ? $unit->value : '';
                    } else {
                        return 'no profile set for this assessee';
                    }
                }
            ],
            [
                'label' => 'Satuan Kerja',
                'format' => 'raw',
                'value' => function($data) use ($form, $readonly, $assessment_report){
                    $fmt = Yii::$app->formatter;
                    $activity_assessee_model = ProjectActivityMeta::find()
                    ->andWhere(['project_activity_id' => $data->id])
                    ->andWhere(['type' => 'general'])
                    ->andWhere(['key' => 'assessee'])->One();
                    if (null !== $activity_assessee_model) {
                    $assessee_model = Profile::findOne($activity_assessee_model->value);
                    $latest = ProfileMeta::find()
                    ->andWhere(['profile_id' => $activity_assessee_model->value])
                    ->andWhere(['type' => 'work'])
                    ->andWhere(['key' => 'satuan_kerja'])->One();
                    //$birthdate = $fmt->asDate($assessee_model->birthdate, 'dd MMMM yyyy');

                    if (null !== $latest){
                        $assessment_report->satuan_kerja = $latest->value;
                    } else {

                    }
                    return $form->field($assessment_report, 'satuan_kerja')->textInput(['readonly'=> $readonly])->label('');
                    } else {
                        return 'no profile set for this assessee';
                    }
                }
            ],          

            [
                'label' => 'Level',
                'value' => function($data) use ($form, $readonly){
                    $activity_assessee_model = ProjectActivityMeta::find()
                    ->andWhere(['project_activity_id' => $data->id])
                    ->andWhere(['type' => 'general'])
                    ->andWhere(['key' => 'assessee'])->One();
                    if (null !== $activity_assessee_model) {
                    $assessee_model = Profile::findOne($activity_assessee_model->value);
                    $level = ProfileMeta::find()
                    ->andWhere(['profile_id' => $activity_assessee_model->value])
                    ->andWhere(['type' => 'work'])
                    ->andWhere(['key' => 'level'])->One();
                            return isset($level->value) ? $level->value : '';
                    } else {
                        return 'no profile set for this assessee';
                    }
                }
            ],
            [
                'label' => 'Pendidikan Terakhir',
                'format' => 'raw',
                'value' => function($data) use ($form, $readonly, $assessment_report){
                    $fmt = Yii::$app->formatter;
                    $activity_assessee_model = ProjectActivityMeta::find()
                    ->andWhere(['project_activity_id' => $data->id])
                    ->andWhere(['type' => 'general'])
                    ->andWhere(['key' => 'assessee'])->One();
                    if (null !== $activity_assessee_model) {
                    $assessee_model = Profile::findOne($activity_assessee_model->value);

             

                    $latest = ProfileMeta::find()
                    ->andWhere(['profile_id' => $activity_assessee_model->value])
                    ->andWhere(['type' => 'education'])
                    ->andWhere(['key' => 'latest'])->One();
                    //$birthdate = $fmt->asDate($assessee_model->birthdate, 'dd MMMM yyyy');

                    if (null !== $latest){
                        $assessment_report->pendidikan_terakhir = $latest->value;
                    } else {

                    }
                    return $form->field($assessment_report, 'pendidikan_terakhir')->textInput(['readonly'=> $readonly])->label('');
                    } else {
                        return 'no profile set for this assessee';
                    }
                }
            ],
            [
                'label' => 'Alamat',
                'format' => 'raw',
                'value' => function($data) use ($form, $readonly, $assessment_report){
                    $activity_assessee_model = ProjectActivityMeta::find()
                    ->andWhere(['project_activity_id' => $data->id])
                    ->andWhere(['type' => 'general'])
                    ->andWhere(['key' => 'assessee'])->One();
                    if (null !== $activity_assessee_model) {
                    $assessee_model = Profile::findOne($activity_assessee_model->value);

                    $address = ProfileMeta::find()
                    ->andWhere(['profile_id' => $activity_assessee_model->value])
                    ->andWhere(['type' => 'address'])
                    ->andWhere(['key' => 'home_address'])->One();

                    if (null !== $address){
                        $assessment_report->alamat = $address->value;
                    } else {

                    }
                    return $form->field($assessment_report, 'alamat')->textInput(['readonly'=> $readonly])->label('');
                    } else {
                        return 'no profile set for this assessee';
                    }


                }
            ],
            [
                'label' => 'Tujuan Pemeriksaan',
                'attribute' => 'name',
                 'value' => function($data) use ($form, $readonly){
                    $project_desc = Project::find()
                    ->andWhere(['id' => $data->project_id])->One();                  
                    return $project_desc->description;

                   

                } 
                
            ],
                    [
                'label' => 'Tempat / Tanggal Test',
                'value' => function($data) use ($form, $readonly){
                    $activity_assessee_model = ProjectActivityMeta::find()
                    ->andWhere(['project_activity_id' => $data->id])
                    ->andWhere(['type' => 'schedule'])
                    ->andWhere(['key' => 'scheduled'])->One();

                    $activity_assessee_model_2 = ProjectActivityMeta::find()
                    ->andWhere(['project_activity_id' => $data->id])
                    ->andWhere(['type' => 'schedule'])
                    ->andWhere(['key' => 'place'])->One();


                    if (null !== $activity_assessee_model) {

                    return $activity_assessee_model->value . ', ' . $activity_assessee_model_2->value;
                    } else {
                        return 'no profile set for this assessee';
                    }
                }
            ],

          //  'status',
        //    'created_at',
         //   'modified_at',
        ],
    ]);



        if ($is_assessor) {
        if ($readonly) {

        } else {

            echo Html::a(Yii::t('app', 'Save'), ['save', 'id' => $_GET['id']], [
            'class' => 'btn btn-warning',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to save this report?'),
                'method' => 'post',
            ],
        ]);
            
        }


        }

                    if(null !== $is_so){

                                if ($readonly) {

        } else {
            echo Html::a(Yii::t('app', 'Temporary Save'), ['sosaved', 'id' => $_GET['id']], [
            'class' => 'btn btn-info',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to finish review this item?'),
                'method' => 'post',
            ],
        ]);
            }
        }


    ?>

</div>
<?php

?>

<hr/>
<?php

if (null !== $catalog_id) {
//echo $catalog_id;
//echo $form->errorSummary($model);
        echo $this->render('/assessment/'.$proj_act->project_id.'/' . $catalog_id, [
            //'searchModel' => $searchModel,
            //'dataProvider' => $dataProvider,
            'kompetensiDataProvider' => $kompetensiDataProvider,
            'kompetensiSQLDataProvider' => $kompetensiSQLDataProvider,
            'psikogramDataProvider' => $psikogramDataProvider,
            'psikogramSQLDataProvider' => $psikogramSQLDataProvider,
            'psikogramSearchModel' => $psikogramSearchModel,
            'kompetensigramSearchModel' => $kompetensigramSearchModel,
            'catalog_id' => $catalog_id,
            'assessment_report' => $assessment_report,
            'form' => $form,
            'readonly' => $readonly,
        ]);
    

} else {
    echo 'NO CATALOG_ID ('.$rumpun->value . ':' . $leveljabatan->value.') FOR THIS USER YET. catalog_id =' . $catalog_id;
}
?>
<hr/>


        <?php
        if ($is_assessor) {
        if ($readonly) {

        } else {
           // echo Html::a(Yii::t('app', 'Save data'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);

            echo Html::a(Yii::t('app', 'Save'), ['save', 'id' => $model->id], [
            'class' => 'btn btn-warning',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to save this report?'),
                'method' => 'post',
            ],
        ]);

            //echo Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-danger']);
            echo Html::a(Yii::t('app', 'Submit (Finalize)'), ['finalize', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to submit this item?'),
                'method' => 'post',
            ],
        ]);
            
        }


        }

                    if(null !== $is_so){
                                if ($readonly) {

        } else {
            echo Html::a(Yii::t('app', 'Temporary Save'), ['sosaved', 'id' => $model->id], [
            'class' => 'btn btn-info',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to finish review this item?'),
                'method' => 'post',
            ],
        ]);

            echo Html::a(Yii::t('app', 'Finish'), ['soreviewed', 'id' => $model->id], [
            'class' => 'btn btn-success',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to finish review this item?'),
                'method' => 'post',
            ],
        ]);


            echo Html::a(Yii::t('app', 'Returned to assessor'), ['soreturned', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to Return this item?'),
                'method' => 'post',
            ],
        ]);       
            }
        }


        ?>



    <p>
        <?php 
        //echo '<div style="display: inline-block;">'. Html::a(Yii::t('app', 'Print PDF'), ['print', 'id' => $model->id], ['class' => 'btn btn-info']).'</div>';
        echo '<div style="display: inline-block;">'. Html::a(Yii::t('app', 'Print'), ['pdf', 'id' => $model->id], ['class' => 'btn btn-info']).'</div>';
        
        //echo ' <div style="display: inline-block;"><a href="https://api.phantomjscloud.com/api/browser/v2/ak-e6rha-y3pt8-t036y-443eq-52eyk/?requestBase64='.base64_encode('{url:"http://projects.ppsdm.com/index.php/projects/activity/pdf?id='.$model->id.'",renderType:"pdf"}').'" target="_blank">PDF</a></div>';

        echo '&nbsp;';
        echo '<div style="display: inline-block;">'. Html::a(Yii::t('app', 'Download PDF'), ['getfile', 'id' => $model->id], ['class' => 'btn btn-info']).'</div>';
        
        

        //echo '<div style="display: inline-block;">'.Html::a(Yii::t('app', 'Blanko PDF'), ['print', 'id' => $model->id], ['class' => 'btn btn-info']).'</div>';

        ?>
    </p>

    <?php ActiveForm::end(); 
/*
    $Pa = ProjectAssessment::find()->andWhere(['activity_id'=> $_GET['id']])->One();
    
    $PArp = ProjectAssessmentResult::find()->andWhere(['type'=>'psikogram'])->andWhere(['project_assessment_id'=>$Pa->id])->Sum('value');
    $PArk = ProjectAssessmentResult::find()->andWhere(['type'=>'kompetensigram'])->andWhere(['project_assessment_id'=>$Pa->id])->Sum('value');

        $sumC =     CatalogMeta::find()->andWhere(['catalog_id'=>$Pa->catalog_id])->andWhere(['type'=>'kompetensigram'])->andWhere(['key'=>'kompetensi'])->Sum('attribute_1');

    echo $PArp/66*100 .'<br/>';
    echo $PArk/$sumC*100 .'<br/>';
*/
   // echo  $sumC.'<br/>';


    //$ids = ArrayHelper::getColumn($PAr, 'id');


    
    ?>