<?php
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\Organization;

/* @var $this yii\web\View */
?>
<h1>Lowongan</h1>

<p>

</p>

<?php
    //  echo Html::a(Yii::t('app', 'Create Job'), ['/admin/jobs/create'], ['class' => 'btn btn-primary']);

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        //['class' => 'yii\grid\SerialColumn'],
        //'id',
        [
          'label' => 'Organisasi',
          'attribute' => 'organization_id',
          'filter' => Html::activeDropDownList($searchModel, 'organization_id', ArrayHelper::map(Organization::find()->asArray()->all(), 'id', 'name'),['class'=>'form-control','prompt' => 'Select Organization']),
          'value' => function($data) {
                 return isset($data->organization->name) ? $data->organization->name : '';
          },
        ],
        'name',
        //'status',
                                     ['class' => 'yii\grid\ActionColumn',
                          'template'=>'{preview}',
                          'header' => 'preview',
                            'buttons'=>[
                              'preview' => function ($url, $model) {     
                              $url = '../jobs/view?id=' . $model->id;
                                return Html::a('<span class="glyphicon glyphicon-check"></span>', $url, [
                                        'title' => Yii::t('yii', 'preview'),
                                ]);                                
            
                              }
                          ]                            
                            ],
    ],
]);



?>