<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\SetkabActivitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Kemenkes Activities');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kemenkes-activity-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>    <h1>Per batch</h1>
		<?php
        echo Html::a(Yii::t('app', 'Batch 1'), ['index1'], ['class' => 'btn btn-primary']);
        echo Html::a(Yii::t('app', 'Batch 2'), ['index2'], ['class' => 'btn btn-primary']);
        /*echo Html::a(Yii::t('app', 'Batch 3'), ['index3'], ['class' => 'btn btn-primary']);
        echo Html::a(Yii::t('app', 'Batch 4'), ['index4'], ['class' => 'btn btn-primary']);
        echo Html::a(Yii::t('app', 'Batch 5'), ['index5'], ['class' => 'btn btn-primary']);
        echo Html::a(Yii::t('app', 'Batch 6'), ['index6'], ['class' => 'btn btn-primary']);
        echo Html::a(Yii::t('app', 'Batch 7'), ['index7'], ['class' => 'btn btn-primary']);
        echo Html::a(Yii::t('app', 'Batch 8'), ['index8'], ['class' => 'btn btn-primary']);
        echo Html::a(Yii::t('app', 'Batch 9'), ['index9'], ['class' => 'btn btn-primary']);
        echo Html::a(Yii::t('app', 'Batch 10'), ['index10'], ['class' => 'btn btn-primary']);
        echo Html::a(Yii::t('app', 'Batch 11'), ['index11'], ['class' => 'btn btn-primary']);
        echo Html::a(Yii::t('app', 'Batch 12'), ['index12'], ['class' => 'btn btn-primary']);
        echo Html::a(Yii::t('app', 'Batch 13'), ['index13'], ['class' => 'btn btn-primary']);   
        */  
		?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model, $key, $index, $grid) {
            return ['data-id' => $model->id];
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'assessee_id',
			[
				'label' => 'Nama Lengkap',
				'format' => 'raw',
				           'content'=>function($data){
							   //$setkab_assessment = SetkabAssessment::find()->andWhere(['activity_id' => $data->id])->One();
                return $data->assessee->nama_lengkap;
                //return $data->assessee_id;
				//        return Html::a(Yii::t('app', $data->id), ['view', 'id' => $data->id], ['class' => '']);
            }
			],
			
			[
				'label' => 'Assessor',
				           'content'=>function($data){
							   //$setkab_assessment = SetkabAssessment::find()->andWhere(['activity_id' => $data->id])->One();
							  $nama = '';
                if (isset($data->assessor->first_name)) {
					$nama = $data->assessor->first_name;
				} else {
					$nama = '';
				}
				return $nama;
            }
            ],
			[
				'label' => 'Second Opinion',
				           'content'=>function($data){
							   //$setkab_assessment = SetkabAssessment::find()->andWhere(['activity_id' => $data->id])->One();
							  $nama = '';
                if (isset($data->secondopinion->first_name)) {
					$nama = $data->secondopinion->first_name;
				} else {
					$nama = '';
				}
				return $nama;
            }
            ],
            
          //  'second_opinion_id',
            'tanggal_test',
             'status',
            // 'tujuan_pemeriksaan',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
<?php
$this->registerJs("

    $('td').hover(function() {
        $(this).css('cursor','pointer');
    }).click(function (e) {
        var id = $(this).closest('tr').data('id');
        if(e.target == this)
            location.href = 'http://projects.ppsdm.com/index.php/kemenkes-activity/view?id=' + id;
    });

");
?>
