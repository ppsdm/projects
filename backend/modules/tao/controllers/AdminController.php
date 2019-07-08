<?php

namespace app\modules\tao\controllers;

use Yii;
use frontend\models\RefConfig;
use frontend\models\RefConfigSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AdminController implements the CRUD actions for RefConfig model.
 */
class AdminController extends Controller
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
     * Lists all RefConfig models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RefConfigSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RefConfig model.
     * @param string $type
     * @param string $key
     * @return mixed
     */
    public function actionView($type, $key)
    {
        return $this->render('view', [
            'model' => $this->findModel($type, $key),
        ]);
    }

    /**
     * Creates a new RefConfig model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RefConfig();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'type' => $model->type, 'key' => $model->key]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing RefConfig model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $type
     * @param string $key
     * @return mixed
     */
    public function actionUpdate($type, $key)
    {
        $model = $this->findModel($type, $key);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'type' => $model->type, 'key' => $model->key]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing RefConfig model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $type
     * @param string $key
     * @return mixed
     */
    public function actionDelete($type, $key)
    {
        $this->findModel($type, $key)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the RefConfig model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $type
     * @param string $key
     * @return RefConfig the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($type, $key)
    {
        if (($model = RefConfig::findOne(['type' => $type, 'key' => $key])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
