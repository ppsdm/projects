<?php

namespace common\modules\catalog\controllers;

use Yii;
use common\modules\catalog\models\CatalogGeneral;
use common\modules\catalog\models\CatalogPrice;
use common\modules\profile\models\UserCredit;

use common\modules\profile\models\UserTransaction;


use common\modules\catalog\models\CatalogGeneralSearch;
use common\modules\tao\models\TaoUriMap;
use common\modules\assessment\models\Assessment;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Expression;
use common\modules\accounting\models\Accounting;
use common\models\Log;

/**
 * CataloggeneralController implements the CRUD actions for CatalogGeneral model.
 */
class CatalogController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all CatalogGeneral models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CatalogGeneralSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CatalogGeneral model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new CatalogGeneral model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CatalogGeneral();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CatalogGeneral model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing CatalogGeneral model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function insertAccounting($catalog_id, $user_id, $point_used, $credit_type)
    {
        $newaccounting = new Accounting;
        $newaccounting->catalog_id = $catalog_id;
        $newaccounting->user_id = $user_id;
        $newaccounting->point_used = $point_used;
        $newaccounting->credit_type = $credit_type;
        $newaccounting->timestamp = date("Y-m-d h:i:sa");
        $newaccounting->save();
    }


    public function useCredit($catalog_id){
    $priceobject = CatalogPrice::find()->andWhere(['catalog_id' => $catalog_id])
    ->andWhere(['credit_type' => 'credit'])
    ->One();

    if (is_null($priceobject)) {
        $price = 0;
    } else {
        $price = $priceobject->required_point; 
    }

    $usercreditobject = UserCredit::find()->andWhere(['user_id' => Yii::$app->user->id])->andWhere(['credit_type' => 'credit'])
    ->andWhere(['status'=>'active'])->One();

    if (is_null($usercreditobject)) {
        $usercredit = 0;
    } else {
        $usercredit = $usercreditobject->credit_point; 
    }

    if ($usercredit < $price) {
               Yii::$app->session->setFlash('danger', 'You dont have enough points');
               return false;
    } else{
            $usercreditobject->credit_point = $usercredit - $price;
            $usercreditobject->save();
            $this->insertAccounting($catalog_id, Yii::$app->user->id,$price, 'credit');
            Yii::$app->session->setFlash('success', 'purchased');
            return true;
    }

    }







    public function actionOldregister($id)
    {

            $registerassessment = Assessment::find()
            ->andWhere(['catalog_id' => $id])
            ->andWhere(['user_id' => Yii::$app->user->id ])
            //->andWhere(['status' => 'open'])
            ->All();

            if (sizeof($registerassessment) >0 ) {
              if ($registerassessment[0]->status == 'open'){
           //     echo 'cannot re-register';
                Yii::$app->session->setFlash('danger', 'Cannot re-register');
                  $log = new Log();
$log->user_id = Yii::$app->user->id;
$log->type = 'activity';
$log->controller = Yii::$app->controller->id;
$log->action = Yii::$app->controller->action->id;
$log->notes = 're-register failure';
  $log->timestamp = new Expression('NOW()');
  $log->save();
             
              } else {

                  if ($this->useCredit($id)) {


  echo Yii::$app->runAction('tao/tao/addtogroup', ['userid' => Yii::$app->user->id, 'groupid' => $id]);
  
                Yii::$app->session->setFlash('success', 'activated');
                         $registerassessment[0]->status = 'open';
$registerassessment[0]->save();
}
              }
   return $this->redirect(Yii::$app->request->referrer);
            } else {

                if ($this->useCredit($id)) {
                  //echo 'register for ' . $id;
                  $taogroup = TaoUriMap::find()
                  ->andWhere(['id' => $id])
                  ->andWhere(['type' => 'group'])
                  ->One();

                $user = TaoUriMap::find()->andWhere(['type' => 'user'])
                ->andWhere(['id' => Yii::$app->user->id])
                ->One();



                  if(($taogroup == null) or ($user == null)) {
                       // echo 'no group uri information';
                Yii::$app->session->setFlash('danger', 'No group/user uri info');
                        return $this->redirect(Yii::$app->request->referrer);

                  } else {
                  //  echo $taogroup->uri;
                        //echo TaoUriMap::URI;
                     echo Yii::$app->runAction('tao/tao/addtogroup', ['userid' => Yii::$app->user->id, 'groupid' => $id]);

                  $newregistration = new Assessment();
                  $newregistration->user_id = Yii::$app->user->id;
                  $newregistration->catalog_id = $id;
                  $newregistration->status = 'open';
                  $newregistration->timestamp = new Expression('NOW()');
                  $newregistration->save();

                  return $this->redirect(Url::home());
                //Yii::$app->session->setFlash('success', 'Success');
                

                  }
              }
                return $this->redirect(Yii::$app->request->referrer);

            }
          

    }

    /**
     * Finds the CatalogGeneral model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CatalogGeneral the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CatalogGeneral::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

                public function beforeAction($action) {

  Log::add(Yii::$app->controller->id, $action->id,'activity');
    if (Yii::$app->session->has('lang')) {
        Yii::$app->language = Yii::$app->session->get('lang');
    } else {
        //or you may want to set lang session, this is just a sample
        //Yii::$app->language = 'us';
    }
    return parent::beforeAction($action);
}




}
