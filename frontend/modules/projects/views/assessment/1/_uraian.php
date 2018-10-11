<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use common\modules\catalog\models\RefAssessmentDictionary;
use common\modules\catalog\models\CatalogMeta;
use common\modules\catalog\models\Catalog;
use app\modules\projects\models\ProjectActivityMeta;
use app\modules\projects\models\ProjectAssessmentResult;
use kartik\editable\Editable;

use common\modules\profile\models\ProfileMeta;
use common\modules\profile\models\Profile;


use kartik\detail\DetailView;
use yii\redactor\widgets\Redactor as Redactor;
?>
<div class="uraian">

    <?php

$model = ProjectAssessmentResult::findOne($model['id']);

$user_profile = Profile::find()->andWhere(['user_id' => Yii::$app->user->id])->One();

$is_so = ProjectActivityMeta::find()
->andWhere(['project_activity_id' => $_GET['id']])
->andWhere(['type' => 'general'])
->andWhere(['key' => 'second_opinion'])
->andWhere(['value'=> $user_profile->id])
->One();

$is_assessor = ProjectActivityMeta::find()
->andWhere(['project_activity_id' => $_GET['id']])
->andWhere(['type' => 'general'])
->andWhere(['key' => 'assessor'])
->andWhere(['value'=> $user_profile->id])
->One();


 		$x = RefAssessmentDictionary::find()
 		->andWhere(['type' => $model->type])
 		->andWhere(['value' => $model->key])->One();


 		$y = CatalogMeta::find()->andWhere(['catalog_id' => $catalog_id])
 		->andWhere(['type' => $model->type])->andWhere(['value' => $model->key])->One();

 		//$val = $model->textvalue;
// 			echo 'model type : ' . $model->value;
 		$randomizer = '1';

 			if (isset($model->attribute_1)) {
 					$randomizer = $model->attribute_1;
 			} else {


 			$maxmodel = RefAssessmentDictionary::find()
 			->andWhere(['type' => 'uraian_kompetensigram'])
			->andWhere(['key' => $model->key . $model->value])
			->All();
			$size = sizeof($maxmodel);
			
			if ($size > 0) {
			$random =  rand();
			$randomizer = $random % $size;
			$randomizer++;
			//echo 'randomizer : ' . $randomizer;
		} else {
			echo 'size : ' . $size;
		}

 			$model->attribute_1 = $randomizer;
 			$model->save();
}

 			$z = RefAssessmentDictionary::find()
 			->andWhere(['type' => 'uraian_kompetensigram'])
			->andWhere(['key' => trim($model->key) . trim($model->value)])
			->andWhere(['value' => $randomizer])
			->One();
			if (null!== $z) {
 			$val = $z->textvalue;

 			} else {
 				$val = '===belum ada uraian===';
 			};

  
	
    //->label($x->attribute_1 . ' - LKI(' . $model->value . ') LKJ(' . $y->attribute_1.') GAP('.($y->attribute_1 - $model->value).')');

    ?>

<table  class="cluster">
 <tr>
	 <td class="cluster1" rowspan="3" ><b><?php echo strtoupper($x->attribute_1  . ' ('.$y->value.')'); ?></b></td>
	 <td class="cluster3" rowspan="3" ><?php echo isset($x->textvalue) ? $x->textvalue : 'no description'; ?>
</td>
	 <td class="cluster4" >Standar</td>
	 <td class="cluster4" ><?php echo $y->attribute_1;?></td>
 </tr>
 <tr>
	 <td class="cluster4" >Individu</td>
	 <td class="cluster4" ><?php echo $model->value;?></td>
 </tr>
 <tr>
	 <td class="cluster4" >Fit %</td>
	 <td class="cluster4" ><?php echo round($model->value / $y->attribute_1 *100);?> %</td>
 </tr>
 <tr>
	 <td class="cluster5" colspan="4">
	 <?php

if ($readonly) {
/*	 echo $form->field($model, 'textvalue')
	 ->textArea(['rows' => 8, 'readonly'=> $readonly, 'id' =>'uraiankompetensigram_'.$model->key, 
	 	'name' =>'uraiankompetensigram_'.$model->key
	 	])
	 ->label('')
	 ->hint('');
*/
	     echo $model->textvalue;
	     echo '<br/><br/>';


} else {
echo $form->field($model, 'textvalue')->label('')->widget(\yii\redactor\widgets\Redactor::className(), [
	'options' => [
	    'id' =>'uraiankompetensigram_'.$model->key, 
	 	'name' =>'uraiankompetensigram_'.$model->key,
	],

    'clientOptions' => [
    'minHeight' => 300,
        'plugins' => ['clips', 'fontcolor','fullscreen', 'counter'],
            'counterCallback' => new \yii\web\JsExpression("
                function(data) {
                    console.log('Words: ' + data.words);
                    console.log('Characters: ' + data.characters);
                    console.log('Characters w/o spaces: ' + (data.characters - data.spaces));
                   	console.log(this);
                   	console.log(this.core.getElement().context.id);
                   	$('#hint_' + this.core.getElement().context.id).html('<i>words : ' + data.words + ', characters : ' + (data.characters - data.spaces) + '</i>');

                }
            "),
    ]
]);

}

$hint_text = 'words : ' . str_word_count(strip_tags($model->textvalue)) . ' , characters : ' . strlen(str_replace(' ','',strip_tags($model->textvalue)));
	 echo '<div id="hint_uraiankompetensigram_'.$model->key.'"><i>'.$hint_text.'</i></div>';
        if ($is_assessor) {
        if ($readonly) {

        } else {
           // echo Html::a(Yii::t('app', 'Save data'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);

            echo Html::a(Yii::t('app', 'Save'), ['save', 'id' => $_GET['id']], [
            'class' => 'btn btn-warning',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to save this report?'),
                'method' => 'post',
            ],
        ]);


            
        }


        }

                    if(null !== $is_so){
                    	        if ($readonly) {

        } else {
            echo Html::a(Yii::t('app', 'Temporary Save'), ['sosaved', 'id' => $_GET['id']], [
            'class' => 'btn btn-info',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to finish review this item?'),
                'method' => 'post',
            ],
        ]);
            }
        }

	 




	 ?>	 
 </tr>
  <tr>
	 <td class="cluster6" ><h3><b>Uraian Sistem</h3></b>
	 <td class="cluster6" ><?php echo $val;?></td>
 </tr>
</table>	
</div>
<hr/>