<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Organization;
use app\modules\admin\models\OrganizationAdminuser;
use yii\helpers\Url;
use yii\jui\DatePicker;
use yii\helpers\ArrayHelper;

use dosamigos\ckeditor\CKEditor;
use dosamigos\ckeditor\CKEditorInline;


/* @var $this yii\web\View */
/* @var $model app\modules\profile\models\ProfileGeneral */

$this->title = Yii::t('app', 'View Job');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Profile Generals'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-general-create">

    <h1><?= Html::encode($this->title) ?></h1>


<div class="profile-general-form">

    <?php $form = ActiveForm::begin(); ?>


    <?php

$orgs = OrganizationAdminuser::find()->andWhere(['user_id' => Yii::$app->user->id])->andWhere(['status' => 'active'])->All();
$ids = ArrayHelper::getColumn($orgs, 'organization_id');
$orglist =  Organization::find()->andWhere(['in','id', $ids])->All();
$orgsname = ArrayHelper::map($orglist, 'id', 'name');
//echo '<pre>';
//print_r($orglist);
$list = ['applied'=>'applied', 'rejected'=>'rejected' ,'accepted'=>'accepted', 'saved'=>'saved'];

  echo $form->field($model, 'organization_id')->dropdownList($orgsname,['prompt'=>'Select Organization']);
    //$form->field($model, 'user_id')->textInput();
echo     $form->field($model, 'name')->textInput();

echo $form->field($model, 'description')->widget(CKEditor::className(), [ 

        'clientOptions' => [

    'height' => 400,
    'toolbarGroups' => [
        ['name' => 'undo'],
        ['name' => 'basicstyles', 'groups' => ['basicstyles', 'cleanup']],
        ['name' => 'colors'],
        ['name' => 'links', 'groups' => ['links', 'insert']],
        ['name' => 'others', 'groups' => ['others', 'about']],
    ],
    'removeButtons' => 'Subscript,Superscript,Flash,Table,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe',
    'removePlugins' => 'elementspath',
    'resize_enabled' => false,
    'extraPlugins' => 'uploadimage',
'uploadUrl' => '/uploader/upload.php',

    'filebrowserBrowseUrl' => '/browser/browse.php',
    //'filebrowserImageBrowseUrl' => '/browser/browse.php?type=Images',
    'filebrowserUploadUrl' =>  Url::to(['imageupload', 'type' => 'Images']),
    //'filebrowserImageUploadUrl' => Url::to(['imageupload', 'type' => 'Images']),
    'filebrowserWindowHeight' => 100,
    'filebrowserWindowFeatures' => 'resizable=yes',


        ],
    //'preset' => 'full' ,
    //'preset' => 'standard' ,
    //'preset' => 'basic' ,
    ]);
 echo $form->field($model, 'open_date')->widget(DatePicker::classname(), [
    //'language' => 'ru',
    'dateFormat' => 'yyyy-MM-dd',
    'options' =>['class'=>'form-control'],
]);

  echo $form->field($model, 'close_date')->widget(DatePicker::classname(), [
    //'language' => 'ru',
    'dateFormat' => 'yyyy-MM-dd',
    'options' =>['class'=>'form-control'],
]);


    ?>

        <?= $form->field($model, 'notes')->textInput() ?>

        <?= $form->field($model, 'url')->textInput() ?>
            <?= $form->field($model, 'status')->dropdownList(['closed'=>'closed', 'active'=>'active'],['prompt'=>'Select Status']) ?>
           
                    <?= $form->field($model, 'tag')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


</div>
