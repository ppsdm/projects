<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\modules\profile\models\Profile;
use app\modules\profile\models\ProfileMeta;
/* @var $this yii\web\View */
/* @var $searchModel vendor\gamantha\pao\project\models\ActivitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Assessor List');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activity-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
               <?= Html::a(Yii::t('app', 'Send all assesor login access'), ['create'], ['class' => 'btn btn-warning']) ?>
               <br/<br/>
        <?= Html::a(Yii::t('app', 'Process ALL ASSESSOR activities status'), ['create'], ['class' => 'btn btn-info']) ?>
        <br/>
        <?= Html::a(Yii::t('app', 'Send ALL ASSESSOR new activities notification'), ['create'], ['class' => 'btn btn-info']) ?>
                <br/>
        <?= Html::a(Yii::t('app', 'Send ALL ASSESSOR expiring activities notification'), ['create'], ['class' => 'btn btn-info']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $assessorDataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'label' => 'nama',
                'format' => 'raw',
                'value' => function($data) {
                      return  Html::a(Yii::t('app',  $data->first_name . ' ' . $data->last_name), ['activities', 'profile_id' => $data->id, 'project_id' => $_GET['id']], ['class' => '']);
                 
                }
            ],

            [
                'label' => '# Peringatan',
                'value' => function($data) {
                    $warning_model = ProfileMeta::find()->andWhere(['type' => 'global'])
                    ->andWhere(['key' => 'warning'])->One();
                    return isset($warning_model->value) ? $warning_model->value : '0';

                }
            ],
            //'project_id',
            //'name',
            //'status',
            //'created_at',
            // 'modified_at',
            [
                'label' => 'Action',
                'format' => 'raw',
                'value' => function($data) {
//$actions =  Html::a(Yii::t('app', 'new activity notification'), ['projects/project/select'], ['class' => 'btn btn-success']);
$actions =  Html::a(Yii::t('app', 'Give SP'), ['projects/project/select'], ['class' => 'btn btn-danger']);
$actions = $actions . ' ' .  Html::a(Yii::t('app', 'send expire warning'), ['projects/project/select'], ['class' => 'btn btn-warning']);
$actions = $actions . ' ' .  Html::a(Yii::t('app', 'send activities notification'), ['assessor/activities', 'profile_id' => $data->id,'project_id' => $_GET['id']], ['class' => 'btn btn-info']);
                    return $actions;
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
