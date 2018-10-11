<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\modules\projects\models\ProjectActivity;
use app\modules\profile\models\Profile;
use app\modules\projects\models\AssessmentReport;
use app\modules\projects\models\ProjectActivityMeta;


/* @var $this yii\web\View */
/* @var $searchModel vendor\gamantha\pao\project\models\ActivitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Activities for profile = ' . $_GET['profile_id']);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activity-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Send new activities notification'), ['create'], ['class' => 'btn btn-info']) ?>
        <?= Html::a(Yii::t('app', 'Send expiring activities notification'), ['create'], ['class' => 'btn btn-info']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
          //  ['class' => 'yii\grid\SerialColumn'],

            'id',
            'project_id',
            //'name',
            [
                'label' => 'assessee',
                'value' => function($data){
                    $meta = ProjectActivityMeta::find()->andWhere(['project_activity_id' => $data->id])
                        ->andWhere(['type' => 'general'])
                        ->andWhere(['key' => 'assessee'])->One();
                        if (null !== $meta) {
                        $profile = Profile::findOne($meta->value);
                    return $profile->first_name .' '  . $profile->last_name;
                } else {
                    return '-';
                }
                }
            ],
            [
                'label' => 'assessor',
                'value' => function($data){
                    $meta = ProjectActivityMeta::find()->andWhere(['project_activity_id' => $data->id])
                        ->andWhere(['type' => 'general'])
                        ->andWhere(['key' => 'assessor'])->One();
                        if (null !== $meta) {
                        $profile = Profile::findOne($meta->value);
                    return $profile->first_name .' '  . $profile->last_name;
                } else {
                    return '-';
                }
                }
            ],
            'status',
            [
                'label' => 'Action',
                'format' => 'raw',
                'value' => function($data) {
                    if ($data->status == 'new') {
$actions =  Html::a(Yii::t('app', 'Make active'), ['activate'], ['class' => 'btn btn-success']);
//$actions = $actions . ' ' .  Html::a(Yii::t('app', 'Give SP'), ['projects/project/select'], ['class' => 'btn btn-danger']);
//$actions = $actions . ' ' .  Html::a(Yii::t('app', 'send expire warning'), ['projects/project/select'], ['class' => 'btn btn-warning']);
} else {
    $actions =  Html::a(Yii::t('app', 'inactivate'), ['inactivate'], ['class' => 'btn btn-warning']);
}
                    return $actions;
                }
            ],
            //'created_at',
            // 'modified_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
