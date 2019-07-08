<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Organization;
use app\modules\admin\models\OrganizationAdminuser;
use app\modules\cats\models\JobCandidate;
use app\modules\cats\models\JobLog;
use common\modules\profile\models\ProfileGeneral;
use yii\helpers\Url;
use yii\jui\DatePicker;
use yii\helpers\ArrayHelper;

use dosamigos\ckeditor\CKEditor;
use dosamigos\ckeditor\CKEditorInline;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;


//echo $model->description;

    //  echo Html::a(Yii::t('app', 'Apply job'), ['/admin/jobs/create'], ['class' => 'btn btn-primary']);

echo Html::a(Yii::t('app', 'Preview'), ['preview','id' => $model->id ], ['class' => 'btn btn-primary']);
?>

<h2>
Pelamar
	</h2>

	<?php


$candidates_query = JobCandidate::find()->andWhere(['job_id' => $model->id]);

    		$provider = new ActiveDataProvider([
    'query' => $candidates_query,

]);

echo GridView::widget([
    'dataProvider' => $provider,
    //'filterModel' => $searchModel,
    'columns' => [
        //['class' => 'yii\grid\SerialColumn'],
        //'user_id',
        [
          'label' => 'Nama',
          'format' => 'raw',
          //'attribute' => 'organization_id',
         // 'filter' => Html::activeDropDownList($searchModel, 'organization_id', ArrayHelper::map(Organization::find()->asArray()->all(), 'id', 'name'),['class'=>'form-control','prompt' => 'Select Organization']),
          'value' => function($data) {
          	$userprofile = ProfileGeneral::findOne($data->user_id);
            if(isset($userprofile->user_id)) {
          	$url = '../profile/general?id=' . $userprofile->user_id;

              return Html::a('<span class="">' . $userprofile->first_name . ' ' . $userprofile->last_name . '</span>', $url, [
                                        'title' => Yii::t('yii', 'Register'),]);
            } else {
              return '';
            }
          },
        ],
        
        //'status',
        [
          'label' => 'status',
          'format' => 'raw',
          //'attribute' => 'organization_id',
          //'filter' => Html::activeDropDownList($searchModel, 'organization_id', ArrayHelper::map(Organization::find()->asArray()->all(), 'id', 'name'),['class'=>'form-control','prompt' => 'Select Organization']),
          'value' => function($data) {
            $url2 = '../applications/view?id=' . $data->id;
              return Html::a('<span class="">' . $data->status . '</span>', $url2, [
                                        'title' => Yii::t('yii', 'Register'),]);
          },
        ],

                [
        'label' => 'assessment result',
        'value' => function($data) {
          return '100';
        }
        ],
        

        /*'name',
        'status',
                                     ['class' => 'yii\grid\ActionColumn',
                          'template'=>'{preview} {view} {update}',
                          'header' => 'View',
                            'buttons'=>[
                              'register' => function ($url, $model) {     
                                return Html::a('<span class="glyphicon glyphicon-plus"></span>', $url, [
                                        'title' => Yii::t('yii', 'Register'),
                                ]);                                
            
                              }
                          ]                            
                            ],
                            */
    ],
]);

echo Html::img('@web/images/contoh_hasil_filtering.png',[ 'width'=> '50%', 'class' => 'img-responsive']);
	?>