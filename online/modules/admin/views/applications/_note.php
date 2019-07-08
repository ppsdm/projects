<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>
<div class="note">
    <h2><?= Html::a(Yii::t('app', Html::encode($model->datetime)), ['editnote', 'id' => $model->id], ['class' => '']) ?></h2>




    <?= HtmlPurifier::process($model->value) ?>    
</div>