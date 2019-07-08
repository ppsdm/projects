<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Organization;
use app\models\Requirement;
use yii\data\ActiveDataProvider;
use common\modules\catalog\models\CatalogGeneral;
use common\modules\catalog\models\CatalogPrice;
use common\modules\catalog\models\CatalogGeneralQuery;
use common\modules\assessment\models\Assessment;
use common\modules\assessment\models\AssessmentSearch;
use common\modules\tao\models\TaoUriMapQuery;
use common\modules\tao\models\TaoUriMap;
use yii\grid\GridView;

use yii\data\ArrayDataProvider;

use yii\db\Expression;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model app\modules\profile\models\ProfileGeneral */

$this->title = Yii::t('app', 'Application Status');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Profile Generals'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-general-create">

    <h1><?= Html::encode($this->title) ?></h1>


<div class="profile-general-form">

    <?php $form = ActiveForm::begin(); ?>


    <?php

//echo  $form->field($model, 'user_id')->textInput(['maxlength' => true, 'readonly' => true]);
    //$form->field($model, 'user_id')->textInput();

    ?>

    <?= $form->field($model, 'job_id')->textInput(['maxlength' => true, 'readonly' => true]) ?>


                <?= $form->field($model, 'status')->dropdownList(['applied'=>'applied', 'rejected'=>'rejected' ,'accepted'=>'accepted', 'saved'=>'saved'],['prompt'=>'Select Status', 'readonly' => true]) ?>


<p>
<h1>Requirements</h1>
</p>
<?php






$requirement_query = Requirement::find()
    ->andWhere(['requirement_type' => 'jobcatalog'])
    ->andWhere(['object_id' => $model->job_id]);

$provider = new ActiveDataProvider([
    'query' => $requirement_query,
    'pagination' => [
    //    'pageSize' => 10,
    ],
    'sort' => [
        'defaultOrder' => [
      //      'created_at' => SORT_DESC,
        //    'title' => SORT_ASC, 
        ]
    ],
]);



echo GridView::widget([
    'dataProvider' => $provider,
    'columns' => [
        //['class' => 'yii\grid\SerialColumn'],
        'id',
        [
            'label' => 'Type',
            'value'=> function($data){
                return $data->key;
            }
        ],
        [
            'label' => 'Name',
            'value'=> function($data){

                    $catalog_item = CatalogGeneral::find()
                    ->andWhere(['type' => $data->key])
                    ->andWhere(['id' => $data->value])
                    ->One();
                return $catalog_item->name;
            }
        ],

            [
                'label' => 'Start',
                            'headerOptions' => [
'data-breakpoints'=>'xs sm'
            ],
                'format' => 'raw',
            'value' => function($data){
                return Html::a(Yii::t('app', 'Start'), ['assessment/view', 'id' => $data->value],['class' => 'btn btn-info']);
                /*$deliveryuri = TaoUriMap::find()->andWhere(['type'=>'delivery'])->andWhere(['id'=>$data['id']])->One();
$price = 0;
                $item = CatalogPrice::find()->andWhere(['catalog_id' => $data['id']])->andWhere(['credit_type' => 'credit'])->One();
                if(!is_null($item)) {
                    $price =  $item->required_point;
                } else {
                    $price = 0;
                }


                                        $returl = '';
                        if ($data['status'] == 'open') {
                                        if ($data['resumeurl'] != '' ) {
                                                         $returl = $returl . Html::a(Yii::t('app', 'Resume'), ['/tao/tao/loginredirect?redirect='.urlencode($data['resumeurl'])],['class' => 'btn btn-warning']);
                                        } else {
                                                           if ($data['initurl'] != '' ) {
                                                    $returl = $returl . Html::a(Yii::t('app', 'Start'), ['/tao/tao/loginredirect?redirect='.urlencode($data['initurl'])],['class' => 'btn btn-success']);
                                                     } else {
                                                        //$returl = 'sdadsadsad';
                                                     }
                                    }
                        } else {
                                                         $returl = $returl . Html::a(Yii::t('app', 'Retake (' . $price.' eduPoin)'), ['/catalog/cataloggeneral/register', 'id' => $data['id']], ['class' => 'btn btn-warning',
                                               'data' => [
                                                    'confirm' => Yii::t('app', 'your eduPoin will be used. Are you sure?'),
                                                    'method' => 'post',
                                                ]
                                                            ]);
                        }
                        return $returl;
                        */
            },
            ],




        [
            'label' => 'Result',
                'format' => 'raw',
            'value'=> function($data){
return Html::a(Yii::t('app', 'Result'), ['result/view', 'id' => $data->id],['class' => 'btn btn-info']);
            }
        ],

    ],
]);





?>




    <?php ActiveForm::end(); ?>

</div>


<p>
<h1>Messaging</h1>
</p>
<?php
echo Html::a(Yii::t('app', 'Message'), ['message', 'id' => $model->id], ['class' => 'btn btn-primary']);
?>
</div>
