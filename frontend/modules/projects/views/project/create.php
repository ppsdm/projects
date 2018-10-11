<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\projects\models\ProjectAssessmentResult */

$this->title = Yii::t('app', 'Create Project Assessment Result');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Project Assessment Results'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-assessment-result-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
