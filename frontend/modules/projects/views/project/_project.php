<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>
<div class="project">

<?php

echo Html::a($model->name, ['project/dashboard', 'id' => $model->id], ['class' => 'btn btn-lg btn-success']);

?>
</div>