<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\redactor\widgets\Redactor as Redactor;

/* @var $this yii\web\View */
/* @var $model frontend\models\SetkabActivity */

$this->title = Yii::t('app', 'Kekuatan {modelClass}: ', [
    'modelClass' => 'Setkab Activity',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Setkab Activities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="setkab-activity-update">


    <?php $form = ActiveForm::begin(); ?>
<?php
echo $form->field($model, 'nama_lengkap')->textInput();
echo $form->field($model, 'tanggal_lahir')->textInput();
echo $form->field($model, 'tempat_lahir')->textInput();
echo $form->field($model, 'jabatan_saat_ini')->textInput();
//echo $form->field($model, 'prospek_jabatan')->textInput();
echo $form->field($model, 'golongan')->textInput();
echo $form->field($model, 'jabatan')->textInput();
echo $form->field($model, 'level')->textInput();
echo $form->field($model, 'nip')->textInput();
echo $form->field($model, 'pendidikan_terakhir')->textInput();
echo $form->field($model, 'alamat')->textArea(['maxlength' => true]);
echo $form->field($model, 'facebook')->textInput();
echo $form->field($model, 'twitter')->textInput();
echo $form->field($model, 'instagram')->textInput();

?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
