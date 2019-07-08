<?php

namespace cats\modules\admin\controllers;

use Yii;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use common\modules\catalog\models\CatalogGeneral;
use common\modules\tao\models\TaoUriMap;
class CatalogController extends \yii\web\Controller
{
    public function actionIndex()
    {

    		$query = CatalogGeneral::find();

    		$provider = new ActiveDataProvider([
    'query' => $query,

]);



        return $this->render('index',[
        	'dataProvider' => $provider,
        	]);

    }


    public function actionEdit($id)
    {

    		$group = new TaoUriMap;
	    			$delivery = new TaoUriMap;

    		$group = TaoUriMap::find()->andWhere(['id' => $id])->andWhere(['type' => 'group'])->One();
    		if(null == $group) {
    			$group = new TaoUriMap;
    		}
    		    		$delivery = TaoUriMap::find()->andWhere(['id' => $id])->andWhere(['type' => 'delivery'])->One();
    		if(null == $delivery) {
    			$delivery = new TaoUriMap;
    		}


    if(Yii::$app->request->post()) {
    			echo '<pre>';
    			print_r($_POST);
    			$group->uri = $_POST['group'];
    			$delivery->uri = $_POST['delivery'];
    			$group->id = $id;
    			$group->type = 'group';
    			$delivery->id = $id;
    			$delivery->type = 'delivery';
    			$group->save();
    			$delivery->save();
         Yii::$app->session->addFlash('success','saved');
    			return $this->redirect('index');
    } else {

}

        return $this->render('edit',[
        //	'model' => $model,
        	'group' => $group->uri,
        	'delivery' => $delivery->uri,
        	]);
    }

}
