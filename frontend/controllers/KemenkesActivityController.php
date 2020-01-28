<?php

namespace frontend\controllers;

use Yii;
use frontend\models\KemenkesActivity;
use frontend\models\KemenkesAssessee;
use frontend\models\KemenkesActivitySearch;
use frontend\models\KemenkesLkj;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\helpers\HtmlPurifier;
use Mpdf\Mpdf;



/**
 * KemenkesActivityController implements the CRUD actions for KemenkesActivity model.
 */
class KemenkesActivityController extends Controller
{






    public function getMinMax($id)
    {
/*
        if (strtolower($assesseeModel->level) == 'pelaksana')
        {
            $kompetensi_min = 100;
            $kompetensi_max = 200;
            $saran_min = 100;
            $saran_max = 700;
            $exsum_min = 550;
            $exsum_max = 700;
        }*/

        $return[] = [];
        $return['kompetensi_min'] = 50;
        $return['kompetensi_max'] = 200;
        $return['saran_min'] = 50;
        $return['saran_max'] = 500;
        $return['exsum_min'] = 350;
        $return['exsum_max'] = 700;

        return $return;
    }

    /**
     * {@inheritdoc}
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
     * Lists all KemenkesActivity models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new KemenkesActivitySearch();
		$params = Yii::$app->request->queryParams;
		$params['KemenkesActivitySearch']['assessor_id'] = Yii::$app->user->id;
        $dataProvider = $searchModel->search($params);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }

    public function actionSoindex()
    {
        $searchModel = new KemenkesActivitySearch();
		$params = Yii::$app->request->queryParams;
		$params['KemenkesActivitySearch']['second_opinion_id'] = Yii::$app->user->id;
        $dataProvider = $searchModel->search($params);

        $dataProvider->pagination = ['pageSize' => 200,];

        return $this->render('soindex', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);


		//echo Yii::$app->user->id;
		//echo '<pre>';
		//print_r($params);

    }

    public function actionHelp()
    {
    
        return $this->render('help');
    }

    /**
     * Displays a single KemenkesActivity model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $minmax = $this->getMinMax($id);
        if ($role = $this->checkRole($id)) {


            $allowedit = true;
                    //readonlyview
                    $model = $this->findModel($id);
                    $assesseeModel = KemenkesAssessee::findOne($model->assessee_id);

            
                    if ($role == 'secondopinion')
                    {
                        if ($model->status == 'reviewed'){
                        $allowedit = false;
                        }
                    } elseif ($role == 'assessor'){
                        if ($model->status == 'reviewed'){
                            $allowedit = false;
                            } elseif ($model->status == 'submitted'){
                                $allowedit = false;
                            }
                    }
                    if ($allowedit) {
            
            
                    return $this->render('view', [
                        'model' => $this->findModel($id),
                        'min' => $minmax['kompetensi_min'],
                        'max' => $minmax['kompetensi_max'],
                        'saran_min' => $minmax['saran_min'],
                        'saran_max' => $minmax['saran_max'],
                        'exsum_min' => $minmax['exsum_min'],
                        'exsum_max' => $minmax['exsum_max'],
                        'role' => $role
                    ]);
            
                    } else {
                        return $this->render('readonlyview', [
                            'model' => $this->findModel($id),
                            'min' => $minmax['kompetensi_min'],
                            'max' => $minmax['kompetensi_max'],
                            'saran_min' => $minmax['saran_min'],
                            'saran_max' => $minmax['saran_max'],
                            'exsum_min' => $minmax['exsum_min'],
                            'exsum_max' => $minmax['exsum_max'],
                            'role' => $role
                        ]);
                    }
            
            
                } else {
                        echo 'not allowed';
                    }
    }

    /**
     * Creates a new KemenkesActivity model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new KemenkesActivity();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing KemenkesActivity model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing KemenkesActivity model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the KemenkesActivity model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return KemenkesActivity the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = KemenkesActivity::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }














    public function actionIndex1()
    {
        //untuk batch 1

        $searchModel = new KemenkesActivitySearch();
        $params = Yii::$app->request->queryParams;
        if (Yii::$app->user->id != 1) { // IF NON ADMIN
        $params['KemenkesActivitySearch']['assessor_id'] = Yii::$app->user->id;
        }
        $dataProvider = $searchModel->search($params);
        $dataProvider->query->andWhere('id >= 2')->andWhere('id <= 18')->orderBy(['id' => SORT_ASC]);
        $dataProvider->pagination = ['pageSize' => 50,];

        $batchNumber = 'B-1';
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'batchNumber' => $batchNumber
        ]);
    }

    public function actionIndex2()
    {
        //untuk batch 2

        $searchModel = new KemenkesActivitySearch();
        $params = Yii::$app->request->queryParams;
        if (Yii::$app->user->id != 1) { // IF NON ADMIN
        $params['KemenkesActivitySearch']['assessor_id'] = Yii::$app->user->id;
        }
        $dataProvider = $searchModel->search($params);
        $dataProvider->query->andWhere('id >= 19')->andWhere('id <= 39')->orderBy(['id' => SORT_ASC]);
        $dataProvider->pagination = ['pageSize' => 50,];

        $batchNumber = 'B-2';
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'batchNumber' => $batchNumber
        ]);
    }

    public function actionIndex3()
    {
        //untuk batch 3

        $searchModel = new KemenkesActivitySearch();
        $params = Yii::$app->request->queryParams;
        if (Yii::$app->user->id != 1) { // IF NON ADMIN
        $params['KemenkesActivitySearch']['assessor_id'] = Yii::$app->user->id;
        }
        $dataProvider = $searchModel->search($params);
        $dataProvider->query->andWhere('id >= 40')->andWhere('id <= 50')->orderBy(['id' => SORT_ASC]);
        $dataProvider->pagination = ['pageSize' => 50,];

        $batchNumber = 'B-2';
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'batchNumber' => $batchNumber
        ]);
    }



    function checkRole($id)
    {
        $hasright = false;
        $model = $this->findModel($id);
        $userid = Yii::$app->user->id;
        if(!Yii::$app->user->isGuest){
            if($model->second_opinion_id == $userid) {
                $hasright = 'secondopinion';
            } elseif ($model->assessor_id == $userid) {
                $hasright = 'assessor';
            } elseif ($userid == '1') {
                $hasright = 'admin';
            }
        }


        return $hasright;
    }




    public function beforeAction($action) {

        Yii::$app->params['projectName'] = 'Kemenkes';
       
           return parent::beforeAction($action);
       }










































































    public function actionDatadiri($id)
    {
        if ($role = $this->checkRole($id)) {
        $model = $this->findModel($id);
		$assessee_model = KemenkesAssessee::findOne($model->assessee_id);
        if ($assessee_model->load(Yii::$app->request->post()) && $assessee_model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('datadiri', [
                'model' => $assessee_model,  'role' => $role,
            ]);
        }
    } else {
        echo 'not allowed';
    }
    }

    public function actionExsum($id)
    {
        if ($role = $this->checkRole($id)) {
        $model = $this->findModel($id);

        $lkjmodel = KemenkesLkj::find()->andWhere(['golongan' => $model->assessee->golongan])->One();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('exsum', [
                'model' => $model,  'role' => $role,'lkjmodel' => $lkjmodel,
            ]);
        }
    } else {
        echo 'not allowed';
    }
    }

    public function actionKekuatan($id)
    {
        if ($role = $this->checkRole($id)) {

        $model = $this->findModel($id);
        $lkjmodel = KemenkesLkj::find()->andWhere(['golongan' => $model->assessee->golongan])->One();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('kekuatan', [
                'model' => $model,  'role' => $role,'lkjmodel' => $lkjmodel,
            ]);
        }


    } else {
        echo 'not allowed';
    }
    }

    public function actionKelemahan($id)
    {
        if ($role = $this->checkRole($id)) {
        $model = $this->findModel($id);
        $lkjmodel = KemenkesLkj::find()->andWhere(['golongan' => $model->assessee->golongan])->One();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('kelemahan', [
                'model' => $model,  'role' => $role,'lkjmodel' => $lkjmodel,
            ]);
        }    } else {
            echo 'not allowed';
        }
    }


    public function actionSaran($id)
    {
        if ($role = $this->checkRole($id)) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('saran', [
                'model' => $model,  'role' => $role,
            ]);
        }    } else {
            echo 'not allowed';
        }
    }


    public function actionPsikogram($id)
    {
        if ($role = $this->checkRole($id)) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('psikogram', [
                'model' => $model,  'role' => $role,
            ]);
        }    } else {
            echo 'not allowed';
        }
    }




















































    public function actionIntegritas($id)
    {

        if ($role = $this->checkRole($id)) {
        $model = $this->findModel($id);
		$assessee_model = KemenkesAssessee::findOne($model->assessee_id);
		$lkj = KemenkesLkj::find()->andWhere(['golongan' => strtolower($assessee_model->golongan)])->One();
		if (is_null($lkj)) {
            $lkj = new KemenkesLkj;
            //echo 'sa';
		}
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			if (Yii::$app->request->post('submit2') == 'refresh') {
				            return $this->render('integritas', [
                                'lkj' => $lkj,
                'model' => $model,  'role' => $role,
            ]);
			} else {

            return $this->redirect(['view', 'id' => $model->id]);
			}
        } else {
            return $this->render('integritas', [
                'lkj' => $lkj,
                'model' => $model,  'role' => $role,
            ]);
        }   
     } else {
            echo 'not allowed';
        }

    }

    public function actionKerjasama($id)
    {
        if ($role = $this->checkRole($id)) {
        $model = $this->findModel($id);
		$assessee_model = KemenkesAssessee::findOne($model->assessee_id);
		$lkj = KemenkesLkj::find()->andWhere(['golongan' => strtolower($assessee_model->golongan)])->One();
		if (is_null($lkj)) {
            //echo 'nada';
			$lkj = new KemenkesLkj;
		}
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			if (Yii::$app->request->post('submit2') == 'refresh') {
				            return $this->render('kerjasama', [
                                'lkj' => $lkj,
                'model' => $model,  'role' => $role,
            ]);
			} else {

            return $this->redirect(['view', 'id' => $model->id]);
			}
        } else {
            return $this->render('kerjasama', [
                'lkj' => $lkj,
                'model' => $model,  'role' => $role,
            ]);
            
            //echo $assessee_model->level;
        }    } else {
            echo 'not allowed';
        }

    }



    public function actionKomunikasi($id)
    {

        if ($role = $this->checkRole($id)) {
        $model = $this->findModel($id);
		$assessee_model = KemenkesAssessee::findOne($model->assessee_id);
		$lkj = KemenkesLkj::find()->andWhere(['golongan' => strtolower($assessee_model->golongan)])->One();
		if (is_null($lkj)) {
			$lkj = new KemenkesLkj;
		}
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			if (Yii::$app->request->post('submit2') == 'refresh') {
				            return $this->render('komunikasi', [
                                'lkj' => $lkj,
                'model' => $model,  'role' => $role,
            ]);
			} else {

            return $this->redirect(['view', 'id' => $model->id]);
			}
        } else {
            return $this->render('komunikasi', [
                'lkj' => $lkj,
                'model' => $model,  'role' => $role,
            ]);
        }    } else {
            echo 'not allowed';
        }

    }

    
    public function actionOrientasihasil($id)
    {
        if ($role = $this->checkRole($id)) {

        $model = $this->findModel($id);
		$assessee_model = KemenkesAssessee::findOne($model->assessee_id);
		$lkj = KemenkesLkj::find()->andWhere(['golongan' => strtolower($assessee_model->golongan)])->One();
		if (is_null($lkj)) {
			$lkj = new KemenkesLkj;
		}
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			if (Yii::$app->request->post('submit2') == 'refresh') {
				            return $this->render('orientasihasil', [
                                'lkj' => $lkj,
                'model' => $model,  'role' => $role,
            ]);
			} else {

            return $this->redirect(['view', 'id' => $model->id]);
			}
        } else {
            return $this->render('orientasihasil', [
                'lkj' => $lkj,
                'model' => $model,  'role' => $role,
            ]);
        }    } else {
            echo 'not allowed';
        }

    }

    public function actionPelayananpublik($id)
    {
        if ($role = $this->checkRole($id)) {

        $model = $this->findModel($id);
		$assessee_model = KemenkesAssessee::findOne($model->assessee_id);
		$lkj = KemenkesLkj::find()->andWhere(['golongan' => strtolower($assessee_model->golongan)])->One();
		if (is_null($lkj)) {
			$lkj = new KemenkesLkj;
		}
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			if (Yii::$app->request->post('submit2') == 'refresh') {
				            return $this->render('pelayananpublik', [
                                'lkj' => $lkj,
                'model' => $model,  'role' => $role,
            ]);
			} else {

            return $this->redirect(['view', 'id' => $model->id]);
			}
        } else {
            return $this->render('pelayananpublik', [
                'lkj' => $lkj,
                'model' => $model,  'role' => $role,
            ]);
        }
    } else {
        echo 'not allowed';
    }
    }


    public function actionPengembangandiri($id)
    {
        if ($role = $this->checkRole($id)) {

        $model = $this->findModel($id);
		$assessee_model = KemenkesAssessee::findOne($model->assessee_id);
		$lkj = KemenkesLkj::find()->andWhere(['golongan' => strtolower($assessee_model->golongan)])->One();
		if (is_null($lkj)) {
			$lkj = new KemenkesLkj;
		}
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			if (Yii::$app->request->post('submit2') == 'refresh') {
				            return $this->render('pengembangandiri', [
                                'lkj' => $lkj,
                'model' => $model,  'role' => $role,
            ]);
			} else {

            return $this->redirect(['view', 'id' => $model->id]);
			}
        } else {
            return $this->render('pengembangandiri', [
                'lkj' => $lkj,
                'model' => $model,  'role' => $role,
            ]);
        }
    } else {
        echo 'not allowed';
    }
    }

    public function actionPerubahan($id)
    {
        if ($role = $this->checkRole($id)) {

        $model = $this->findModel($id);
		$assessee_model = KemenkesAssessee::findOne($model->assessee_id);
		$lkj = KemenkesLkj::find()->andWhere(['golongan' => strtolower($assessee_model->golongan)])->One();
		if (is_null($lkj)) {
			$lkj = new KemenkesLkj;
		}
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			if (Yii::$app->request->post('submit2') == 'refresh') {
				            return $this->render('perubahan', [
                                'lkj' => $lkj,
                'model' => $model,  'role' => $role,
            ]);
			} else {

            return $this->redirect(['view', 'id' => $model->id]);
			}
        } else {
            return $this->render('perubahan', [
                'lkj' => $lkj,
                'model' => $model,  'role' => $role,
            ]);
        }
    } else {
        echo 'not allowed';
    }
    }


    public function actionPengambilankeputusan($id)
    {
        if ($role = $this->checkRole($id)) {

        $model = $this->findModel($id);
		$assessee_model = KemenkesAssessee::findOne($model->assessee_id);
		$lkj = KemenkesLkj::find()->andWhere(['golongan' => strtolower($assessee_model->golongan)])->One();
		if (is_null($lkj)) {
			$lkj = new KemenkesLkj;
		}
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			if (Yii::$app->request->post('submit2') == 'refresh') {
				            return $this->render('pengambilankeputusan', [
                                'lkj' => $lkj,
                'model' => $model,  'role' => $role,
            ]);
			} else {

            return $this->redirect(['view', 'id' => $model->id]);
			}
        } else {
            return $this->render('pengambilankeputusan', [
                'lkj' => $lkj,
                'model' => $model,  'role' => $role,
            ]);
        }
    } else {
        echo 'not allowed';
    }
    }

    public function actionPerekatbangsa($id)
    {
        if ($role = $this->checkRole($id)) {

        $model = $this->findModel($id);
		$assessee_model = KemenkesAssessee::findOne($model->assessee_id);
		$lkj = KemenkesLkj::find()->andWhere(['golongan' => strtolower($assessee_model->golongan)])->One();
		if (is_null($lkj)) {
			$lkj = new KemenkesLkj;
		}
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			if (Yii::$app->request->post('submit2') == 'refresh') {
				            return $this->render('perekatbangsa', [
                                'lkj' => $lkj,
                'model' => $model,  'role' => $role,
            ]);
			} else {

            return $this->redirect(['view', 'id' => $model->id]);
			}
        } else {
            return $this->render('perekatbangsa', [
                'lkj' => $lkj,
                'model' => $model,  'role' => $role,
            ]);
        }
    } else {
        echo 'not allowed';
    }
    }











    public function actionSubmit($id)
	{
        $result = $this->submitValidation($id);

        //echo '<pre>';
        //print_r($result);
    if ($result == '')
    {
        $model = $this->findModel($id);
        $model->status = 'submitted';
        $model->save();
        Yii::$app->session->setFlash('success', "Submit Success");
    } else {
        Yii::$app->session->setFlash('error', "ada yang belum komplit");
        Yii::$app->session->addFlash('error', $result);
    }

    return $this->redirect(['view', 'id' => $id]);




    }









    public function actionReturned($id)
	{


        $model = $this->findModel($id);
        $model->status = 'returned';
        $model->save();
        Yii::$app->session->setFlash('success', "Return Success");


    return $this->redirect(['view', 'id' => $id]);



	}

    public function actionReviewed($id)
	{

        $model = $this->findModel($id);
        $model->status = 'reviewed';
        $model->save();
        Yii::$app->session->setFlash('success', "Review Success");


    return $this->redirect(['view', 'id' => $id]);



	}

















    function submitValidation($id)
    {
        //echo 'validasi data laporan. kalua belum maka ditolak';
        $minmax = $this->getMinMax($id);

        //cek jumlah karakter tiap uraian
        $model = $this->findModel($id);

        $assesseeModel = KemenkesAssessee::findOne($model->assessee_id);



         $integritas_uraian = $this->countWord($model->integritas_uraian);
         $kerjasama_uraian = $this->countWord($model->kerjasama_uraian);
         $komunikasi_uraian = $this->countWord($model->komunikasi_uraian);
         $orientasihasil_uraian = $this->countWord($model->orientasihasil_uraian);
         $pelayananpublik_uraian = $this->countWord($model->pelayananpublik_uraian);
         $pengembangandiri_uraian = $this->countWord($model->pengembangandiri_uraian);
         $pengelolaanperubahan_uraian = $this->countWord($model->pengelolaanperubahan_uraian);
         $pengambilankeputusan_uraian = $this->countWord($model->pengambilankeputusan_uraian);
         $perekatbangsa_uraian = $this->countWord($model->perekatbangsa_uraian);
         $kekuatan = $this->countWord($model->kekuatan);
         $kelemahan = $this->countWord($model->kelemahan);
         $exsum = $this->countWord($model->executive_summary);
         $saran = $this->countWord($model->saran);

        $psikogram_kemampuananalisa = $model->psikogram_kemampuananalisa;
        $psikogram_empati = $model->psikogram_empati;
        $psikogram_kemampuanumum = $model->psikogram_kemampuanumum;
        $psikogram_kemampuanbelajar = $model->psikogram_kemampuanbelajar;
        $psikogram_ketekunan = $model->psikogram_ketekunan;
        $psikogram_ketelitian = $model->psikogram_ketelitian;
        $psikogram_komunikasiefektif = $model->psikogram_komunikasiefektif;
        $psikogram_konsepdiri = $model->psikogram_konsepdiri;
        $psikogram_logikaberpikir = $model->psikogram_logikaberpikir;
        $psikogram_motivasi = $model->psikogram_motivasi;
        $psikogram_pemahamansosial = $model->psikogram_pemahamansosial;
        
        $psikogram_sistematikakerja = $model->psikogram_sistematikakerja;
        $psikogram_tempokerja = $model->psikogram_tempokerja;

        $psikogram_inisiatif = $model->psikogram_inisiatif;
        $psikogram_adaptif = $model->psikogram_adaptif;
        $psikogram_kematanganemosi = $model->psikogram_kematanganemosi;
        

        $message = '';
        $valid = true;

        if (is_null($psikogram_kemampuananalisa)) {
            $message = $message . ' psikogram kemampuan analisa belum diisi; <br/>';
            $valid = false;
        }
        if (is_null($psikogram_empati)) {
            $message = $message . ' psikogram empati belum diisi; <br/>';
            $valid = false;
        }
        if (is_null($psikogram_kemampuanumum)) {
            $message = $message . ' psikogram kemampuan umum belum diisi; <br/>';
            $valid = false;
        }
        if (is_null($psikogram_kemampuanbelajar)) {
            $message = $message . ' psikogram kemampuan belajar belum diisi; <br/>';
            $valid = false;
        }
        if (is_null($psikogram_ketekunan)) {
            $message = $message . ' psikogram ketekunan belum diisi; <br/>';
            $valid = false;
        }
        if (is_null($psikogram_ketelitian)) {
            $message = $message . ' psikogram ketelitian belum diisi; <br/>';
            $valid = false;
        }
        if (is_null($psikogram_komunikasiefektif)) {
            $message = $message . ' psikogram komunikasi efektif belum diisi; <br/>';
            $valid = false;
        }
        if (is_null($psikogram_konsepdiri)) {
            $message = $message . ' psikogram konsep diri belum diisi; <br/>';
            $valid = false;
        }
        if (is_null($psikogram_logikaberpikir)) {
            $message = $message . ' psikogram logika berpikir belum diisi; <br/>';
            $valid = false;
        }
        if (is_null($psikogram_motivasi)) {
            $message = $message . ' psikogram motivasi belum diisi; <br/>';
            $valid = false;
        }
        if (is_null($psikogram_pemahamansosial)) {
            $message = $message . ' psikogram pemahaman sosial belum diisi; <br/>';
            $valid = false;
        }

        if (is_null($psikogram_sistematikakerja)) {
            $message = $message . ' psikogram sistematika kerja belum diisi; <br/>';
            $valid = false;
        }
        if (is_null($psikogram_tempokerja)) {
            $message = $message . ' psikogram tempo kerja belum diisi; <br/>';
            $valid = false;
        }

        if (is_null($psikogram_inisiatif)) {
            $message = $message . ' psikogram inisiatif belum diisi; <br/>';
            $valid = false;
        }
        if (is_null($psikogram_adaptif)) {
            $message = $message . ' psikogram adaptif belum diisi; <br/>';
            $valid = false;
        }
        if (is_null($psikogram_kematanganemosi)) {
            $message = $message . ' psikogram kematangan emosi belum diisi; <br/>';
            $valid = false;
        }


        if($kekuatan > $minmax['saran_max']) {
            $message = $message . ' uraian kekuatan diatas MAX; <br/>';
            $valid = false;
        }
        if($kekuatan < $minmax['saran_min']) {
            $message = $message . ' uraian kekuatan dibawah MIN; <br/>';
            $valid = false;
        }
        if($kelemahan > $minmax['saran_max']) {
            $message = $message . ' uraian kelemahan diatas MAX; <br/>';
            $valid = false;
        }
        if($kelemahan < $minmax['saran_min']) {
            $message = $message . ' uraian kelemahan dibawah MIN; <br/>';
            $valid = false;
        }
        if($saran > $minmax['saran_max']) {
            $message = $message . ' uraian saran diatas MAX; <br/>';
            $valid = false;
        }
        if($saran < $minmax['saran_min']) {
            $message = $message . ' uraian saran dibawah MIN; <br/>';
            $valid = false;
        }
        if($exsum > $minmax['exsum_max']) {
            $message = $message . ' uraian executive summary diatas MAX; <br/>';
            $valid = false;
        }
        if($exsum < $minmax['exsum_min']) {
            $message = $message . ' uraian executive summary dibawah MIN; <br/>';
            $valid = false;
        }

            if($integritas_uraian > $minmax['kompetensi_max']) {
                $message = $message . ' uraian integritas diatas MAX; <br/>';
                $valid = false;
            }
            if($integritas_uraian < $minmax['kompetensi_min']) {
                $message = $message . ' uraian integritas dibawah MIN; <br/>';
                $valid = false;
            }

            if($kerjasama_uraian > $minmax['kompetensi_max']) {
                $message = $message . ' uraian kerjasama diatas MAX; <br/>';
                $valid = false;
            }
            if($kerjasama_uraian < $minmax['kompetensi_min']) {
                $message = $message . ' uraian kerjasama dibawah MIN; <br/>';
                $valid = false;
            }

            if($komunikasi_uraian > $minmax['kompetensi_max']) {
                $message = $message . ' uraian komunikasi diatas MAX; <br/>';
                $valid = false;
            }
            if($komunikasi_uraian < $minmax['kompetensi_min']) {
                $message = $message . ' uraian komunikasi dibawah MIN; <br/>';
                $valid = false;
            }
            if($orientasihasil_uraian > $minmax['kompetensi_max']) {
                $message = $message . ' uraian orientasi hasil diatas MAX; <br/>';
                $valid = false;
            }
            if($orientasihasil_uraian < $minmax['kompetensi_min']) {
                $message = $message . ' uraian orientasi hasil dibawah MIN; <br/>';
                $valid = false;
            }

            if($pelayananpublik_uraian > $minmax['kompetensi_max']) {
                $message = $message . ' uraian pelayanan publik diatas MAX; <br/>';
                $valid = false;
            }
            if($pelayananpublik_uraian < $minmax['kompetensi_min']) {
                $message = $message . ' uraian pelayanan publik dibawah MIN; <br/>';
                $valid = false;
            }

            if($pengembangandiri_uraian > $minmax['kompetensi_max']) {
                $message = $message . ' uraian pengembangan diri diatas MAX; <br/>';
                $valid = false;
            }
            if($pengembangandiri_uraian < $minmax['kompetensi_min']) {
                $message = $message . ' uraian pengembangan diri dibawah MIN; ' .$pengembangandiri_uraian. '<br/>';
                $valid = false;
            }
            if($pengelolaanperubahan_uraian > $minmax['kompetensi_max']) {
                $message = $message . ' uraian pengelolaan perubahan diatas MAX; <br/>';
                $valid = false;
            }
            if($pengelolaanperubahan_uraian < $minmax['kompetensi_min']) {
                $message = $message . ' uraian pengelolaan perubahan dibawah MIN; <br/>';
                $valid = false;
            }

            if($pengambilankeputusan_uraian > $minmax['kompetensi_max']) {
                $message = $message . ' uraian pengambilan keputusan diatas MAX; <br/>';
                $valid = false;
            }
            if($pengambilankeputusan_uraian < $minmax['kompetensi_min']) {
                $message = $message . ' uraian pengambilan keputusan dibawah MIN; <br/>';
                $valid = false;
            }

            if($perekatbangsa_uraian > $minmax['kompetensi_max']) {
                $message = $message . ' uraian perekat bangsa diatas MAX; <br/>';
                $valid = false;
            }
            if($perekatbangsa_uraian < $minmax['kompetensi_min']) {
                $message = $message . ' uraian perekat bangsa dibawah MIN; <br/>';
                $valid = false;
            }

            if ($valid) {
                //echo 'ye';
                return ($message);
                //return ($valid);
            }
            else {
               // echo 'err';
                return ($message);
            }
    }


    function countWord($uraian)
    {
        $dom = new \DOMDocument;
$li_count = 0;
$word_count = 0;

if (!empty($uraian)) {
    $dom->loadHTML(HtmlPurifier::process($uraian));

$new_element = $dom->createElement('test', ' ');
    foreach($dom->getElementsByTagName('li') as $li) {
        $li_count = $li_count + str_word_count(strip_tags($li->textContent));
    }

    foreach($dom->getElementsByTagName('ul') as $ul) {
        //$ul->parentNode->replaceChild($new_element,$ul);
        $ul->textContent = ' ';
        //$dom->saveHTML();

    }
    foreach($dom->getElementsByTagName('ol') as $ol) {
        //$ol->parentNode->replaceChild($new_element,$ol);
        $ol->textContent = ' ';
        //$dom->saveHTML();

    }

       $replaced_dom = preg_replace('#\<(.+?)\>#', ' ', $dom->saveHTML());
       $word_count = preg_match_all("/[\w]+/i", html_entity_decode(strip_tags($replaced_dom), ENT_QUOTES));
        //$word_count = str_word_count(strip_tags($replaced_dom));
}
		$total_count = $word_count + $li_count;

       return $total_count;

    }

























    public function actionPdf($id)
	{
    $activityModel = $this->findModel($id);
    $assesseeModel = KemenkesAssessee::findOne($activityModel->assessee_id);
    $lkjModel = KemenkesLkj::find()->andWhere(['golongan' => $activityModel->assessee->golongan])->One();
    $sumbuY = 0;
    $sumbuY = $sumbuY + $activityModel->integritas_lki; #1
    $sumbuY = $sumbuY + $activityModel->kerjasama_lki; #2
    $sumbuY = $sumbuY + $activityModel->komunikasi_lki; #3
    $sumbuY = $sumbuY + $activityModel->orientasihasil_lki; #4
    $sumbuY = $sumbuY + $activityModel->pelayananpublik_lki; #5
    $sumbuY = $sumbuY + $activityModel->pengembangandiri_lki; #6
    $sumbuY = $sumbuY + $activityModel->pengelolaanperubahan_lki; #7
    $sumbuY = $sumbuY + $activityModel->pengambilankeputusan_lki; #8
    $sumbuY = $sumbuY + $activityModel->perekatbangsa_lki; #9

    $pembagiSumbuY = $lkjModel->kompetensigram_integritas * 9;



    $sumbuX = 0;
    $sumbuX = $sumbuX + $activityModel->psikogram_kemampuananalisa;
    $sumbuX = $sumbuX + $activityModel->psikogram_empati;
    $sumbuX = $sumbuX + $activityModel->psikogram_kemampuanumum;
    $sumbuX = $sumbuX + $activityModel->psikogram_kemampuanbelajar;
    $sumbuX = $sumbuX + $activityModel->psikogram_ketekunan;
    $sumbuX = $sumbuX + $activityModel->psikogram_ketelitian;
    $sumbuX = $sumbuX + $activityModel->psikogram_komunikasiefektif;
    $sumbuX = $sumbuX + $activityModel->psikogram_konsepdiri;
    $sumbuX = $sumbuX + $activityModel->psikogram_logikaberpikir;
    $sumbuX = $sumbuX + $activityModel->psikogram_motivasi;
    $sumbuX = $sumbuX + $activityModel->psikogram_pemahamansosial;
    //$sumbuX = $sumbuX + $activityModel->psikogram_pengaturandiri;
    $sumbuX = $sumbuX + $activityModel->psikogram_sistematikakerja;
    $sumbuX = $sumbuX + $activityModel->psikogram_tempokerja;
    //$sumbuX = $sumbuX + $activityModel->psikogram_fleksibilitasberpikir;
    $sumbuX = $sumbuX + $activityModel->psikogram_kematanganemosi;
    $sumbuX = $sumbuX + $activityModel->psikogram_inisiatif;
    $sumbuX = $sumbuX + $activityModel->psikogram_adaptif;

    $pembagiSumbuX = 54;

    $date =  date_create($activityModel->tanggal_test);

    //echo date_format($date,"Y/m/d H:i:s");
    $month =  date_format($date,"n");
    $day = date_format($date,"j");
    $romawi  = $this->numberToRomawi($month);

    $level_jabatan = '';
    // switch (strtolower($assesseeModel->level)) {
    //     case "iia":
    //     $level_jabatan = 'es 2';;
    //         break;
    //     case "iiia":
    //     $level_jabatan = 'es 3';
    //         break;
    //     case "iva":
    //         $level_jabatan = 'es 4';
    //         break;
    //     case "jft3":
    //         $level_jabatan = 'jft';
    //         break;
    //     case "jft4":
    //         $level_jabatan = 'jft';
    //         break;
    //     case "pelaksana":
    //         $level_jabatan = 'pelaksana';
    //         break;
    //     default:
    //         $level_jabatan = '';
    // }

    $level_jabatan = $assesseeModel->level;
    $notest = $activityModel->no_test . '/EVAL/' . $level_jabatan.'/KEMENKES/'.$romawi.'/20';

    $dateTest =  $day . ' - ' . ($day + 1) . ' ' . date_format($date,"F") . ' ' . date_format($date,"Y");
    $daterep = $date->modify('+13 day');
    //$date->modify('-1 day');
    $dateReport = date_format($daterep,"j") . ' ' . date_format($daterep,"F") . ' ' . date_format($daterep,"Y");

    $batchNumber = 'B-1';
		$content =  $this->renderPartial('pdf',[
            'activityModel' => $activityModel,
            'assesseeModel' => $assesseeModel,
            'lkjModel' => $lkjModel,
            'dataSumbuY' => $sumbuY,
            'pembagiSumbuY' => $pembagiSumbuY ,
            'dataSumbuX' => $sumbuX,
            'pembagiSumbuX' => $pembagiSumbuX ,
            'asessorName' => $activityModel->assessor->first_name,
            'noTest' => $notest,
            'dateTest' => $dateTest,
            'dateReport' => $dateReport,
            'dateSign' => $day . ' ' . date_format($date,"F") . ' ' . date_format($date,"Y"), 
            'batchNumber' => $batchNumber,
            ]);

    return $content;
    // // use kartik\mpdf\Pdf;
    // $pdf = new pdf([
    //   // set to use core fonts only
    //   // 'mode' => Pdf::MODE_CORE,
    //   'mode' => Pdf::MODE_UTF8,
    //   // LETTER paper format
    //   'format' => Pdf::FORMAT_A4,
    //   // portrait orientation
    //   'orientation' => Pdf::ORIENT_PORTRAIT,
    //   // stream to browser inline
    //   'destination' => Pdf::DEST_BROWSER,
    //   // your html content input
    //   'content' => $content,
    //   // format content from your own css file if needed or use the
    //   // enhanced bootstrap css built by Krajee for mPDF formatting
    //   // 'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
    //   'cssFile' => '@web/css/psikogramTable.css',
    //   'cssFile' => '@web/css/paper.css',
    //   'cssFile' => '@web/js/d3.min.js',
    //   'cssFile' => '@web/css/normalize.css',
    //   // any css to be embedded if required
    //   // 'cssInline' => '.kv-heading-1{font-size:18px}',
    //    // set mPDF properties on the fly
    //   'options' => ['title' => $assesseeModel->nama_lengkap],
    //    // call mPDF methods on the fly
    //
    // ]);
    //
    // return $pdf->render();

        // $mpdf = new mPDF();
        // $stylesheet = file_get_contents('@web/css/psikogramTable.css');
        // $stylesheet = file_get_contents('@web/css/paper.css');
        // $stylesheet = file_get_contents('@web/js/d3.min.js');
        // $stylesheet = file_get_contents('@web/css/normalize.cs');
        // $mpdf->WriteHTML($stylesheet, 1);
        // $mpdf->WriteHTML($content, 2);
        // $mpdf->Output();
        // exit;
    }
    


public function findBatch(){
    
    return $batchNumber;
}
    
  public function numberToRomawi($number)
  {
      if($number == 1){
        $romawi = 'I';
      } elseif ($number == 2){
          $romawi = 'II';
      } elseif ($number == 3){
          $romawi = 'III';
      } elseif ($number == 4){
          $romawi = 'IV';
      } elseif ($number == 5){
          $romawi = 'V';
      } elseif ($number == 6){
          $romawi = 'VI';
      } elseif ($number == 7){
          $romawi = 'VII';
      } elseif ($number == 8){
          $romawi = 'VIII';
      } elseif ($number == 9){
          $romawi = 'IX';
      } elseif ($number == 10){
          $romawi = 'X';
      } elseif ($number == 11){
          $romawi = 'XI';
      }else{
        $romawi = 'XII';
      }

      return $romawi;
  }


}
