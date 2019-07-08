<?php
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

/* @var $this yii\web\View */
?>
<h1>Applications/index</h1>

<p>
' '
</p>

<?php


echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'id',
        'status',
        ['label' => 'Interviewed'],
        ['label' => 'assessment result'],






                                     ['class' => 'yii\grid\ActionColumn',
                          'template'=>'{view}',
                          'header' => 'View',
                            'buttons'=>[
                              'register' => function ($url, $model) {     
                                return Html::a('<span class="glyphicon glyphicon-plus"></span>', $url, [
                                        'title' => Yii::t('yii', 'Register'),
                                ]);                                
            
                              }
                          ]
                          ]   






    ],
]);



?>