<?php

namespace app\modules\projects\controllers;
use app\modules\projects\models\ProjectAssessment;
use app\modules\projects\models\Project;
use app\modules\projects\models\ProjectMeta;
use app\modules\projects\models\ProjectActivity;
use app\modules\projects\models\ProjectActivityMeta;
use common\modules\profile\models\Profile;
use common\modules\profile\models\ProfileMeta;
use app\modules\projects\models\ProjectAssessmentResult;
use app\modules\projects\models\ProjectAssessmentResultSearch;
use yii\helpers\Html;
use common\modules\catalog\models\CatalogMeta;
use common\modules\catalog\models\Catalog;
use common\modules\catalog\models\RefAssessmentDictionary;
use Yii;
use Yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use app\modules\projects\models\AssessmentReport;

class AssessmentController extends \yii\web\Controller
{
	


    public function actionViewkamus()
    {

            return $this->renderAjax('5/viewkamus', [
                //'model' => $model,
            ]);
 
    }
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

    public function actionPrintblankreport($id)
    {
    	
    }

    public function actionPrintdisc($id)
    {

    }

    public function actionPrintprestatif($id)
    {

    }

	public function actionDatapeserta($id)
	{
		echo 'data pesrrta';
	}


	public function actionPsikogram($id)
	{
		$colorPluginOptions =  [
    'showPalette' => true,
    'showPaletteOnly' => true,
    'showSelectionPalette' => true,
    'showAlpha' => false,
    'allowEmpty' => false,
    'preferredFormat' => 'name',
    'palette' => [
        [
            "white", "black", "grey", "silver", "gold", "brown", 
        ],
        [
            "red", "orange", "yellow", "indigo", "maroon", "pink"
        ],
        [
            "blue", "green", "violet", "cyan", "magenta", "purple", 
        ],
    ]
];


		$catalog_id = 29;
		$readonly = false;
		$psikogramSearchModel = new ProjectAssessmentResultSearch();
$psikogram_params = Yii::$app->request->queryParams;

          $psikogramDataProvider = $psikogramSearchModel->search($psikogram_params);
$psikogramDataProvider->query->andWhere(['project_assessment_id' => $id])
                    ->andWhere(['project_assessment_result.type' => 'psikogram']);
					
					$psikogramGridColumns = [
[
        'class'=>'kartik\grid\EditableColumn',
            'contentOptions' => ['style' => 'max-width:0px;'],
      'attribute' => 'id',
      'header' => '&nbsp;',
        'width'=>'0px',
      'hidden' => true,
      'content' => function($data){
        return '&nbsp;';
      },
      'editableOptions'=>['header'=>'Name', 'size'=>'sm' ,'class' => 'hidden']
    ],
    [
    'label' => 'Kategori',
    'value' => function($data) use ($catalog_id){
      $lkj = CatalogMeta::find()
      ->andWhere(['catalog_id' => $catalog_id])
        ->andWhere(['type' => 'psikogram'])
        ->andWhere(['key' => 'aspek'])
        ->andWhere(['value' => $data->key])->One();
      return $lkj->attribute_2;
    },
    'contentOptions' => ['style'=>' white-space: normal;'],
  ],
  [
    'label' => 'Aspek psikologis',
    'value' => function($data){
        $deskripsi = RefAssessmentDictionary::find()
        ->andWhere(['type' => 'psikogram'])
        ->andWhere(['key' => 'aspek'])
        ->andWhere(['value' => $data->key])->One();
        return $deskripsi->attribute_1;
    },
    'contentOptions' => ['style'=>'white-space: normal;'],
  ],
  [
    'label' => 'Keterangan',
    'value' => function($data){
        $deskripsi = RefAssessmentDictionary::find()
        ->andWhere(['type' => 'psikogram'])
        ->andWhere(['key' => 'aspek'])
        ->andWhere(['value' => $data->key])->One();
        return $deskripsi->attribute_2;
    },
    'contentOptions' => ['style'=>'width:350px; white-space: normal;'],

  ],

      [
        'label' => 'Skor',
           'pageSummary' => true,
           'attribute' => 'value',
    ],
    'type',

  [
    'class'=>'kartik\grid\EditableColumn',
    'label' => 'Penilaian',
    'attribute'=>'value',
    'format' => 'raw',
    'value' => function($data) use ($catalog_id, $readonly){

$radiolistoptions = [1 => '1',2 => '2',3=>'3',4=>'4',5=>'5',6=>'6',7 =>'7'];
      $assessmentmodel = ProjectAssessment::find()
      ->andWhere(['id' => $_GET['id']])
        ->andWhere(['status' => 'active'])->One();
        $resultmodel = ProjectAssessmentResult::find()
                ->andWhere(['project_assessment_id' => $assessmentmodel->id])
                ->andWhere(['type' => 'psikogram'])
                ->andWhere(['key' => $data->key])->One();
return Html::RadioList($data->key, $resultmodel->value, $radiolistoptions, [
    'item' => function($index, $label, $name, $checked, $value) use ($readonly)
              {
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
    },
  
    'vAlign'=>'middle',
    'width'=>'100px',
    /*'readonly'=>function($model, $key, $index, $widget) {
      //  return (!$mail(to, subject, message)odel->status); // do not allow editing of inactive records
        return;
    },
    */
    'readonly'=> $readonly,
    'editableOptions'=> function ($model, $key, $index) use ($colorPluginOptions) {
        return [
          'formOptions'=>['action' => ['/projects/activity/editpsikogram']], // point to the new action
          'id' => 'psikogram_' . $model->key . '_form_name',
            'header'=>'Result', 
            'size'=>'md',
          'placement' => 'left',
            'inputType'=>\kartik\editable\Editable::INPUT_RANGE,
             //'data' => [0 => 'pass', 1 => 'fail', 2 => 'waived', 3 => 'todo'],
            'options'=>[
                    'html5Options' => ['min' => 1, 'max' => 7],
                    'id' => 'psikogram_' . $model->key . '_form_name',
            ],

        'beforeInput' => function ($form, $widget) use ($model, $index) {
          /*  echo $form->field($model, "publish_date")->widget(\kartik\widgets\DatePicker::classname(), [
                'options' => ['id' => "publish_date_{$index}"]
            ]);
            */
                echo 'Masukkan rating';
        },


            'afterInput'=>function ($form, $widget) use ($model, $index, $colorPluginOptions) {
                /*return $form->field($model, "color")->widget(\kartik\widgets\ColorInput::classname(), [
                    'showDefaultPalette'=>false,
                    'options'=>['id'=>"color-{$index}"],
                    'pluginOptions'=>$colorPluginOptions,
                ]);
                */

return '';
            }
            
        ];
    }
],

];


echo Yii::$app->controller->render('../assessment/1/_psikogram', [


    'psikogramDataProvider'=> $psikogramDataProvider,
    'psikogramSearchModel' => $psikogramSearchModel,
    'psikogramGridColumns' => $psikogramGridColumns,

]);
	}

	public function actionKekuatan($id)
	{
		echo 'kekuatan';
	}

	public function actionKelemahan($id)
	{
		echo 'kelemahan';
	}

	public function actionSaran($id)
	{
		echo 'saran';
	}

	
	public function actionExsum($id)
	{
        //$model = $this->findModel($id);
		
		 $assessment_report = new AssessmentReport();
		 
		        $model = ProjectAssessment::find()
                                        ->andWhere(['activity_id' => $id])
                                        ->andWhere(['status' => 'active'])
                                        ->One();
										

										
		echo sizeof($model);
if (sizeof($model) == 0) {
	$model = new ProjectAssessment;
	$model->activity_id = $id;
} else {
	
	
}
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->id]);
			echo 'seharusnya back disini';
        } else {
            return $this->render('5/exsum', [
                'model' => $model,
				'assessment_report' => $assessment_report
            ]);
        }
		
	}
	
	
	
	
		public function actionIntegritas($id, $lki)
	{
        //$model = $this->findModel($id);
		
		 $assessment_report = new AssessmentReport();
		 
		        $model = ProjectAssessment::find()
                                        ->andWhere(['activity_id' => $id])
                                        ->andWhere(['status' => 'active'])
                                        ->One();
										

										
		echo sizeof($model);
if (sizeof($model) == 0) {
	$model = new ProjectAssessment;
	$model->activity_id = $id;
} else {
	
	
}

$assessment_report->integritas_lki = $lki;
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->id]);
			echo 'seharusnya back disini';
        } else {
            return $this->render('5/integritas', [
                'model' => $model,
				'assessment_report' => $assessment_report
            ]);
        }
		
	}

}
