<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\SetkabAssessee */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Setkab Assessees'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="setkab-assessee-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'profile_id',
            'nama_lengkap',
            'tanggal_lahir',
            'tempat_lahir',
            'jabatan_saat_ini',
            'prospek_jabatan',
            'golongan',
            'jabatan',
            'level',
            'nip',
            'pendidikan_terakhir',
            'alamat',
            'avatar',
            'facebook',
            'twitter',
            'instagram',
        ],
    ]) ?>

</div>
