<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Organization;
use app\modules\cats\models\JobExtNote;


/* @var $this yii\web\View */
/* @var $model app\modules\profile\models\ProfileGeneral */

$this->title = Yii::t('app', 'Create Profile General');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Profile Generals'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-general-create">

    <h1><?= Html::encode($this->title) ?></h1>


<div class="profile-general-form">

    <?php $form = ActiveForm::begin(); ?>


    <?php

echo  $form->field($model, 'user_id')->textInput(['maxlength' => true, 'readonly' => true]);
    //$form->field($model, 'user_id')->textInput();

    ?>

    <?= $form->field($model, 'job_id')->textInput(['maxlength' => true, 'readonly' => true]) ?>


                <?= $form->field($model, 'status')->dropdownList(['applied'=>'applied', 'rejected'=>'rejected' ,'accepted'=>'accepted', 'saved'=>'saved'],['prompt'=>'Select Status']) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
<?php

$blacklisted = JobExtNote::find()->andWhere(['user_id' => $model->user_id])
->andWhere(['type' => 'blacklist'])
->andWhere(['organization_id' => $model->job->organization_id])
->andWhere(['notes' => 'true'])
->One();
echo Html::a(Yii::t('app', 'Send Message to candidate'), ['message', 'id' => $model->id], ['class' => 'btn btn-info']);
echo Html::a(Yii::t('app', 'Take Notes about candidate'), ['notes', 'id' => $model->id], ['class' => 'btn btn-info']);
echo Html::a(


   (null == $blacklisted) ? Yii::t('app', 'Blacklist Candidate') : Yii::t('app', 'un-Blacklist Candidate')



    , [


    (null == $blacklisted) ?   'blacklist' :  'unblacklist'



    , 'id' => $model->id], [
'class' =>

    (null == $blacklisted) ?   'btn btn-danger' :  'btn btn-success'



    , 'data-confirm' =>'are you sure?']);
?>
</div>


</div>
