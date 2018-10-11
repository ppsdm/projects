<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\redactor\widgets\Redactor as Redactor;
use app\modules\projects\models\AssessmentReport;


$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>


    <div class="row">

            <?php $form = ActiveForm::begin(['id' => 'exsum-form']); ?>

			

<?php			
//Html::label('Executive Summary', 'executive_summary')
//Html::textArea('executive_summary', '', ['class' => 'form-control'])

echo $form->field($assessment_report, 'executive_summary')->widget(\yii\redactor\widgets\Redactor::className(), [
    'clientOptions' => [
        'plugins' => ['clips', 'fontcolor','fullscreen', 'counter']
    ]
]);

?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-primary']) ?>
    </div>

            <?php ActiveForm::end(); ?>
    
    </div>
</div>
