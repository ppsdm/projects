<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\redactor\widgets\Redactor as Redactor;

/* @var $this yii\web\View */
/* @var $model frontend\models\SetkabActivity */

$this->title = Yii::t('app', 'Executive Summary {modelClass}: ', [
    'modelClass' => 'Setkab Activity',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Setkab Activities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="setkab-activity-update">


    <?php $form = ActiveForm::begin(); ?>
<?php
//echo    $form->field($model, 'saran')->textArea(['maxlength' => true]);

	echo $form->field($model, 'executive_summary')->widget(\yii\redactor\widgets\Redactor::className(), [
    'clientOptions' => [
        'plugins' => ['clips', 'fontcolor','fullscreen', 'counter']
    ]
]);
echo $hint_text = 'words : ' . str_word_count(strip_tags($model->executive_summary)) . ' , characters : ' . strlen(str_replace(' ','',strip_tags($model->executive_summary)));
?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
