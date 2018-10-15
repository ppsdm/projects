<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\redactor\widgets\Redactor as Redactor;
use yii\helpers\HtmlPurifier;
/* @var $this yii\web\View */
/* @var $model frontend\models\SetkabActivity */

$this->title = Yii::t('app', 'Saran {modelClass}: ', [
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

	echo $form->field($model, 'saran')->widget(\yii\redactor\widgets\Redactor::className(), [
    'clientOptions' => [
        'plugins' => ['clips', 'fontcolor','fullscreen', 'counter']
    ]
]);

$dom = new DOMDocument;
$li_count = 0;
$word_count = 0;

if (!empty($model->saran)) {
$dom->loadHTML(HtmlPurifier::process($model->saran));

$new_element = $dom->createElement('test', ' ');
    foreach($dom->getElementsByTagName('li') as $li) {
        $li_count = $li_count + str_word_count(strip_tags($li->textContent));
    }
/*
        foreach($dom->getElementsByTagName('ul') as $ul) {
            $ul->parentNode->replaceChild($new_element,$ul);
            $dom->saveHTML();
    
        }
        foreach($dom->getElementsByTagName('ol') as $ol) {
            $ol->parentNode->replaceChild($new_element,$ol);
            $dom->saveHTML();
    
        }
*/

       $replaced_dom = preg_replace('#\<(.+?)\>#', ' ', $dom->saveHTML());
        $word_count = str_word_count(strip_tags($replaced_dom));
	}
	
		$total_count = $word_count;
		
echo $hint_text = 'words : ' . $total_count . ' , characters : ' . strlen(str_replace(' ','',strip_tags($model->saran)));
?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
