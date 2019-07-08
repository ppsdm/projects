<?php

use yii\helpers\Html;
use yii\grid\GridView;

use app\modules\tao\models\Statement;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\RefConfigSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Ref Configs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-config-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Ref Config'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php


    $subject_folders = Statement::find()
    ->andWhere(['predicate' => 'http://www.w3.org/2000/01/rdf-schema#subClassOf'])
    ->andWhere(['object' => 'http://www.tao.lu/Ontologies/TAOSubject.rdf#Subject'])
    ->AsArray();



echo '<pre>';
print_r($subject_folders);
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'type',
            'key',
            'value',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
