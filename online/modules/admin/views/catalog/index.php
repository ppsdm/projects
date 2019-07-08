<?php
/* @var $this yii\web\View */

use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use common\modules\tao\models\TaoUriMap;
use yii\helpers\Html;


?>
<h1>catalog/index</h1>

<p>
    You may change the content of this page by modifying
    the file <code><?= __FILE__; ?></code>.
</p>


<?php
      echo Html::a(Yii::t('app', 'Create Catalog item'), ['/admin/catalog/create'], ['class' => 'btn btn-primary']);

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        //['class' => 'yii\grid\SerialColumn'],
        'id',
        'name',
        [
        	'label' => 'group uri',
        	'value' => function($data) {
        		$groupuri = TaoUriMap::find()->andWhere(['id' => $data->id])->andWhere(['type' => 'group'])->One();
        		return isset($groupuri->uri) ? $groupuri->uri : '';
        	}
        ],
        [
        	'label' => 'delivery uri',
        	'value' => function($data) {
        		$groupuri = TaoUriMap::find()->andWhere(['id' => $data->id])->andWhere(['type' => 'delivery'])->One();
        		return isset($groupuri->uri) ? $groupuri->uri : '';
        	}
        ],
    /*
        [
          'label' => 'Organisasi',
          'value' => function($data) {
              return $data->organization->name;
          },
        ],
        'name',
        */
        'status',
                                     ['class' => 'yii\grid\ActionColumn',
                          'template'=>'{edit}',
                          'header' => 'Edit',
                            'buttons'=>[
                              'edit' => function ($url, $model) {     
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                        'title' => Yii::t('yii', 'Edit'),
                                ]);                                
            
                              }
                          ]                            
                            ],

                            
    ],
]);



?>