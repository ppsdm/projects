<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\KemenkesActivity */

$this->title = Yii::t('app', 'Create Kemenkes Activity');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Kemenkes Activities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kemenkes-activity-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
