<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\profile\models\ProfileExtended;
use app\modules\profile\models\ProfileGeneral;
use app\models\ImageUpload;
use kartik\sidenav\SideNav;
use kartik\file\FileInput;
use yii\jui\DatePicker;
use yii\widgets\Pjax;
use yii\grid\GridView;
use common\modules\core\models\File;
use common\modules\core\models\FileMeta;


/* @var $this yii\web\View */
/* @var $model app\modules\profile\models\ProfileGeneral */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="profile-general-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>


<?php 


echo $form->field($spreadsheetuploadmodel, 'spreadsheetFile')->widget(FileInput::classname(), [
   // 'options' => ['accept' => 'image/*'],
]);


    ?>

    <div class="form-group">
    </div>

    <?php ActiveForm::end(); ?>



</div>

<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'path',
            [
                'label' => 'type',
                'value' => function($data){
                    $meta = FileMeta::find()
                    ->andWhere(['file_id' => $data->id])
                    ->andWhere(['key' => 'project'])
                    ->andWhere(['value' => '1'])
                    ->One();
                    return $meta->type;
                }
            ],
            'created_at',
            'modified_at',
            [
                'label' => 'Process',
                'format' => 'raw',
                'value' => function($data)
                {
                    return Html::a('Process the file', ['#', 'id' => $data->id], ['class' => 'btn btn-xs btn-warning']);
                }
            ],
            // 'gender',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
