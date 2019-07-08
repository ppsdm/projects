<?php

use Yii;
use app\modules\profile\models\UserCredit;
use app\modules\accounting\models\Accounting;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;



$usercredit = UserCredit::find()->andWhere(['user_id' => Yii::$app->user->id])->andWhere(['credit_type' => 'credit'])->andWhere(['status' => 'active'])->One();

if (is_null($usercredit))
{
    $credit = 0;
} else {
    $credit = $usercredit->credit_point;
}
/* @var $this yii\web\View */
?>
<h1>User credit</h1>

<?php
echo '<h2>'; 
echo 'Your eduPoin is <strong>'  . $credit;
echo '</strong></h2>';

//echo '<hr/>';
//echo '<h1>Latest transaction</h1>';


$transactionsquery = Accounting::find()->andWhere(['user_id' => Yii::$app->user->id]);
$provider = new ActiveDataProvider([
    'query' => $transactionsquery,
    'pagination' => [
        //'pageSize' => 10,
    ],
    'sort' => [
        'defaultOrder' => [
          //  'created_at' => SORT_DESC,
            //'id' => SORT_ASC, 
        ]
    ],
]);
/*
echo GridView::widget([
        'dataProvider' => $provider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'catalog_id',
         //   'user_id',
           // 'credit_type',
            'point_used',
            'timestamp',
            //'name',
            //'description:ntext',
            //'imageUrl:url',
            //'status',

        //    ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); 
*/

?>