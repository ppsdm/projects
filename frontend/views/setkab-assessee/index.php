<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\SetkabAssesseeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Setkab Assessees');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="setkab-assessee-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Setkab Assessee'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'profile_id',
            'nama_lengkap',
            'tanggal_lahir',
            'tempat_lahir',
            // 'jabatan_saat_ini',
            // 'prospek_jabatan',
            // 'golongan',
            // 'jabatan',
            // 'level',
            // 'nip',
            // 'pendidikan_terakhir',
            // 'alamat',
            // 'avatar',
            // 'facebook',
            // 'twitter',
            // 'instagram',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
