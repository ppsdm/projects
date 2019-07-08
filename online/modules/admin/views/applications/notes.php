<?php
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;

/* @var $this yii\web\View */
?>
<h1>Notes</h1>

<p>
' '
</p>

<?php




echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_note',
]);


echo Html::a(Yii::t('app', 'Create new note'), ['createnote', 'id' => $id], ['class' => 'btn btn-info']);

?>