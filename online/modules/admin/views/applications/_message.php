<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>
<div class="note">

	<?php

if($model->type == 'message-admin') {
	$sender = 'Admin';
} else if($model->type == 'message-candidate') {
$sender = $model->candidate->user->username;
}

	?>
    <h2><?= Html::a(Yii::t('app', Html::encode($sender . ' ' . $model->datetime)), ['deletemessage', 'id' => $model->id], ['class' => '','data-confirm' => 'delete message. are you sure?']) ?></h2>


<?php



?>

    <?= HtmlPurifier::process($model->value) ?>    
</div>