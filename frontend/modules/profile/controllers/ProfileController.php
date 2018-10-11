<?php

namespace app\modules\profile\controllers;

use Yii;
use app\modules\profile\models\Profile;
use app\modules\profile\models\ProfileMeta;
use app\modules\profile\models\ProfileSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

/**
 * ProfileController implements the CRUD actions for Profile model.
 */
class ProfileController extends Controller
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
     * Lists all Profile models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProfileSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    /**
     * Displays a single Profile model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $profile_metas = ProfileMeta::find()
            ->andWhere(['profile_id' => Yii::$app->user->identity->profile->id])
            ->All();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'profile_metas' => $profile_metas,
        ]);
    }

    /**
     * Creates a new Profile model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Profile();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Profile model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);


        $metas['contact']['home_phone'] = '';
        $metas['contact']['work_phone'] = '';
        $metas['contact']['mobile_phone'] = '';

        $metas['address']['home_address'] = '';
        $metas['address']['work_address'] = '';

        $metas['education']['s1']['institution'] = '';
        $metas['education']['s1']['year'] = '';
        $metas['education']['s2']['institution'] = '';
        $metas['education']['s2']['year'] = '';
        $metas['education']['s3']['institution'] = '';
        $metas['education']['s3']['year'] = '';   
        
        $is_assesor = ProfileMeta::find()
        ->andWhere(['type'=>'global'])
        ->andWhere(['key'=>'role'])
        ->andWhere(['value'=>'assessor'])
        ->One();

        if (null !== $is_assesor) {
            $metas['assessor']['nip'] = '';
        } 

        $profile_metas = ProfileMeta::find()
            ->andWhere(['profile_id' => $id])
            ->All();

        foreach ($profile_metas as $key => $value) {
            # code...
            if($value->type == 'contact') {
                $metas['contact'][$value->key] = $value->value;
            } else if ($value->type == 'address') {
                $metas['address'][$value->key] = $value->value;
            }
            else if ($value->type == 'education') {
               $metas['education'][$value->key]['institution'] = $value->value;
               $metas['education'][$value->key]['year']= $value->attribute_1;
                
            }
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //echo '<pre/>';
            foreach (Yii::$app->request->post() as $key => $value) {
                if ($key[0] == ':') {
                    $profile_meta_model = ProfileMeta::find()
                    ->andWhere(['profile_id' => $id])
                    ->andWhere(['type' => explode(':', $key)[1]])
                    ->andWhere(['key' => explode(':', $key)[2]])
                    ->One();
                    if (null !== $profile_meta_model) {

                    } else {
                        $profile_meta_model = new ProfileMeta();
                        $profile_meta_model->type = explode(':', $key)[1];
                        $profile_meta_model->key = explode(':', $key)[2];
                        $profile_meta_model->profile_id = $id;

                    }
                    $profile_meta_model->value = $value;
                    $profile_meta_model->save();



                }
            
            }
                Yii::$app->session->setFlash('success', 'Profile is updated');
                return $this->redirect(Yii::$app->request->referrer);
            //return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            'metas' => $metas,
            ]);
        }


    }

    /**
     * Deletes an existing Profile model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Profile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Profile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Profile::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
