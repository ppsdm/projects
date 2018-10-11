<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\SetkabAssessee */

$this->title = Yii::t('app', 'Create Setkab Assessee');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Setkab Assessees'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="setkab-assessee-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
