<?php

namespace frontend\controllers;

use Yii;
use frontend\models\SetkabActivity;
use frontend\models\SetkabAssessee;
use frontend\models\SetkabLkj;
use frontend\models\SetkabActivitySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\helpers\VarDumper;
use yii\data\SqlDataProvider;
use app\modules\projects\models\ProjectAssessment;
/**
 * SetkabActivityController implements the CRUD actions for SetkabActivity model.
 */
class SetkabActivityController extends Controller
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
     * Lists all SetkabActivity models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SetkabActivitySearch();
		$params = Yii::$app->request->queryParams;
		$params['SetkabActivitySearch']['assessor_id'] = '127';
        $dataProvider = $searchModel->search($params);

	
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
		
		
		//echo Yii::$app->user->id;
		//echo '<pre>';
		//print_r($params);
		
    }

    /**
     * Displays a single SetkabActivity model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {

        $kompetensi_min = 200;
        $kompetensi_max = 335;
		$saran_min = 200;
		$saran_max = 335;
		$exsum_min = 200;
        $exsum_max = 400;
        
        return $this->render('view', [
            'model' => $this->findModel($id),
            'min' => $kompetensi_min,
            'max' => $kompetensi_max,
            'saran_min' => $saran_min,
            'saran_max' => $saran_max,
            'exsum_min' => $exsum_min,
            'exsum_max' => $exsum_max
        ]);
    }

    /**
     * Creates a new SetkabActivity model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SetkabActivity();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SetkabActivity model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
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
     * Deletes an existing SetkabActivity model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SetkabActivity model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return SetkabActivity the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SetkabActivity::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }





	public function actionDebug($id)
	{




	}


    function submitValidation($id)
    {
        //echo 'validasi data laporan. kalua belum maka ditolak';
		
        $kompetensi_min = 200;
        $kompetensi_max = 335;
		$saran_min = 200;
		$saran_max = 335;
		$exsum_min = 200;
		$exsum_max = 400;
        //cek jumlah karakter tiap uraian
        $model = $this->findModel($id);
         $integritas_uraian = str_word_count(strip_tags($model->integritas_uraian));
         $kerjasama_uraian = str_word_count(strip_tags($model->kerjasama_uraian));
         $komunikasi_uraian = str_word_count(strip_tags($model->komunikasi_uraian));
         $orientasihasil_uraian = str_word_count(strip_tags($model->orientasihasil_uraian));
         $pelayananpublik_uraian = str_word_count(strip_tags($model->pelayananpublik_uraian));
         $pengembangandiri_uraian = str_word_count(strip_tags($model->pengembangandiri_uraian));
         $pengelolaanperubahan_uraian = str_word_count(strip_tags($model->pengelolaanperubahan_uraian));
         $pengambilankeputusan_uraian = str_word_count(strip_tags($model->pengambilankeputusan_uraian));
         $perekatbangsa_uraian = str_word_count(strip_tags($model->perekatbangsa_uraian));
         $kekuatan = str_word_count(strip_tags($model->kekuatan));
         $kelemahan = str_word_count(strip_tags($model->kelemahan));
         $exsum = str_word_count(strip_tags($model->executive_summary));
         $saran = str_word_count(strip_tags($model->saran));

        $message = '';
        $valid = true;

        if($kekuatan >= $saran_max) {
            $message = $message . ' uraian kekuatan diatas MAX; <br/>';
            $valid = false;
        }
        if($kekuatan < $saran_min) {
            $message = $message . ' uraian kekuatan dibawah MIN; <br/>';
            $valid = false;
        }
        if($kelemahan >= $saran_max) {
            $message = $message . ' uraian kelemahan diatas MAX; <br/>';
            $valid = false;
        }
        if($kelemahan < $saran_min) {
            $message = $message . ' uraian kelemahan dibawah MIN; <br/>';
            $valid = false;
        }
        if($saran >= $saran_max) {
            $message = $message . ' uraian saran diatas MAX; <br/>';
            $valid = false;
        }
        if($saran < $saran_min) {
            $message = $message . ' uraian saran dibawah MIN; <br/>';
            $valid = false;
        }
        if($exsum >= $exsum_max) {
            $message = $message . ' uraian executive summary diatas MAX; <br/>';
            $valid = false;
        }
        if($exsum < $exsum_min) {
            $message = $message . ' uraian executive summary dibawah MIN; <br/>';
            $valid = false;
        }

            if($integritas_uraian >= $kompetensi_max) {
                $message = $message . ' uraian integritas diatas MAX; <br/>';
                $valid = false;
            }
            if($integritas_uraian < $kompetensi_min) {
                $message = $message . ' uraian integritas dibawah MIN; <br/>';
                $valid = false;
            }

            if($kerjasama_uraian >= $kompetensi_max) {
                $message = $message . ' uraian kerjasama diatas MAX; <br/>';
                $valid = false;
            }
            if($kerjasama_uraian < $kompetensi_min) {
                $message = $message . ' uraian kerjasama dibawah MIN; <br/>';
                $valid = false;
            }

            if($komunikasi_uraian >= $kompetensi_max) {
                $message = $message . ' uraian komunikasi diatas MAX; <br/>';
                $valid = false;
            }
            if($komunikasi_uraian < $kompetensi_min) {
                $message = $message . ' uraian komunikasi dibawah MIN; <br/>';
                $valid = false;
            }
            if($orientasihasil_uraian >= $kompetensi_max) {
                $message = $message . ' uraian orientasi hasil diatas MAX; <br/>';
                $valid = false;
            }
            if($orientasihasil_uraian < $kompetensi_min) {
                $message = $message . ' uraian orientasi hasil dibawah MIN; <br/>';
                $valid = false;
            }

            if($pelayananpublik_uraian >= $kompetensi_max) {
                $message = $message . ' uraian pelayanan publik diatas MAX; <br/>';
                $valid = false;
            }
            if($pelayananpublik_uraian < $kompetensi_min) {
                $message = $message . ' uraian pelayanan publik dibawah MIN; <br/>';
                $valid = false;
            }

            if($pengembangandiri_uraian >= $kompetensi_max) {
                $message = $message . ' uraian pengembangan diri diatas MAX; <br/>';
                $valid = false;
            }
            if($pengembangandiri_uraian < $kompetensi_min) {
                $message = $message . ' uraian pengembangan diri dibawah MIN; <br/>';
                $valid = false;
            }
            if($pengelolaanperubahan_uraian >= $kompetensi_max) {
                $message = $message . ' uraian pengelolaan perubahan diatas MAX; <br/>';
                $valid = false;
            }
            if($pengelolaanperubahan_uraian < $kompetensi_min) {
                $message = $message . ' uraian pengelolaan perubahan dibawah MIN; <br/>';
                $valid = false;
            }

            if($pengambilankeputusan_uraian >= $kompetensi_max) {
                $message = $message . ' uraian pengambilan keputusan diatas MAX; <br/>';
                $valid = false;
            }
            if($pengambilankeputusan_uraian < $kompetensi_min) {
                $message = $message . ' uraian pengambilan keputusan dibawah MIN; <br/>';
                $valid = false;
            }

            if($perekatbangsa_uraian >= $kompetensi_max) {
                $message = $message . ' uraian perekat bangsa diatas MAX; <br/>';
                $valid = false;
            }
            if($perekatbangsa_uraian < $kompetensi_min) {
                $message = $message . ' uraian perekat bangsa dibawah MIN; <br/>';
                $valid = false;
            }

            if ($valid) {
                //echo 'ye';
                return ($valid);
            }
            else {
               // echo 'err';
                return ($message);
            }
    }

	public function actionSubmit($id)
	{

    if ($result = $this->submitValidation($id))
    {
        $model = $this->findModel($id);
        $model->status = 'submitted';
        $model->save();
        Yii::$app->session->setFlash('success', "Submit Success"); 
    } else {
        Yii::$app->session->setFlash('error', "ada yang belum komplit");
    }

    return $this->redirect(['view', 'id' => $id]);



	}
	




	public function actionPdf($id)
	{

    $activityAssesse= $this->findModel($id);

    $profile = SetkabAssessee::find(["id" => $id])->one();

    $idAssessor = $activityAssesse['assessor_id'];

    $profileAssessor = SetkabAssessee::find(["id" => $idAssessor])->one();

    $project_assessment_model = ProjectAssessment::find()
                                    ->andWhere(['activity_id' => $id])
                                    ->andWhere(['status' => 'active'])
                                    ->One();

    $kompetensiSQLDataProvider = new SqlDataProvider([
        'sql' => 'select * from (select table1.id,table1.project_assessment_id,
      table1.type,table1.key,table1.value,table1.attribute_1,table1.attribute_2,table1.attribute_3,
       table1.catalog_id, catalog_meta.attribute_3 * 1 as ordering,
       catalog_meta.attribute_1 as standar
       from (SELECT project_assessment_result.id, project_assessment_result.project_assessment_id,
        project_assessment_result.type, project_assessment_result.key, project_assessment_result.value,
        project_assessment_result.attribute_1, project_assessment_result.attribute_2,
        project_assessment_result.attribute_3, project_assessment.catalog_id FROM `project_assessment_result`
         join project_assessment on project_assessment_result.project_assessment_id = project_assessment.id
         where project_assessment_result.project_assessment_id = :project_assessment_id  AND project_assessment_result.type ="kompetensigram") as table1
    join catalog_meta
    on
    table1.catalog_id = catalog_meta.catalog_id
    and table1.type = catalog_meta.type
    and table1.key = catalog_meta.value) as table2 ORDER BY table2.type, table2.ordering',
        'params' => [':project_assessment_id' => $project_assessment_model['id']],
        //'totalCount' => $count,
        'sort' => [
            'attributes' => [
               // 'age',
                /*'name' => [
                    'asc' => ['first_name' => SORT_ASC, 'last_name' => SORT_ASC],
                    'desc' => ['first_name' => SORT_DESC, 'last_name' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'Name',
                ],
                */
            ],
        ],
        'pagination' => [
            'pageSize' => 20,
        ],
    ]);

		return $this->renderPartial('pdf',['activity'=>$activityAssesse, 'profile' => $profile,'assessor' => $profileAssessor, 'kompetensi' => $kompetensiSQLDataProvider ]);
		// VarDumper::dump($profile);

	}




    public function actionExsum($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('exsum', [
                'model' => $model,
            ]);
        }
    }

    public function actionDatadiri($id)
    {
        $model = $this->findModel($id);
		$assessee_model = SetkabAssessee::findOne($model->assessee_id);
        if ($assessee_model->load(Yii::$app->request->post()) && $assessee_model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('datadiri', [
                'model' => $assessee_model,
            ]);
        }
    }
    public function actionPsikogram($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('psikogram', [
                'model' => $model,
            ]);
        }
    }
    public function actionKelemahan($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('kelemahan', [
                'model' => $model,
            ]);
        }
    }
    public function actionKekuatan($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('kekuatan', [
                'model' => $model,
            ]);
        }
    }
    public function actionSaran($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('saran', [
                'model' => $model,
            ]);
        }
    }






    public function actionIntegritas($id)
    {


        $model = $this->findModel($id);
		$assessee_model = SetkabAssessee::findOne($model->assessee_id);
		$lkj = SetkabLkj::find()->andWhere(['level' => strtolower($assessee_model->level)])->One();
		if (sizeof($lkj) == 0) {
			$lkj = new SetkabLkj;
		}
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			if (Yii::$app->request->post('submit2') == 'refresh') {
				            return $this->render('integritas', [
                                'lkj' => $lkj,
                'model' => $model,
            ]);
			} else {

            return $this->redirect(['view', 'id' => $model->id]);
			}
        } else {
            return $this->render('integritas', [
                'lkj' => $lkj,
                'model' => $model,
            ]);
        }

    }






    public function actionKerjasama($id)
    {


        $model = $this->findModel($id);
		$assessee_model = SetkabAssessee::findOne($model->assessee_id);
		$lkj = SetkabLkj::find()->andWhere(['level' => strtolower($assessee_model->level)])->One();
		if (sizeof($lkj) == 0) {
			$lkj = new SetkabLkj;
		}
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			if (Yii::$app->request->post('submit2') == 'refresh') {
				            return $this->render('kerjasama', [
                                'lkj' => $lkj,
                'model' => $model,
            ]);
			} else {

            return $this->redirect(['view', 'id' => $model->id]);
			}
        } else {
            return $this->render('kerjasama', [
                'lkj' => $lkj,
                'model' => $model,
            ]);
        }

    }



    public function actionKomunikasi($id)
    {


        $model = $this->findModel($id);
		$assessee_model = SetkabAssessee::findOne($model->assessee_id);
		$lkj = SetkabLkj::find()->andWhere(['level' => strtolower($assessee_model->level)])->One();
		if (sizeof($lkj) == 0) {
			$lkj = new SetkabLkj;
		}
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			if (Yii::$app->request->post('submit2') == 'refresh') {
				            return $this->render('komunikasi', [
                                'lkj' => $lkj,
                'model' => $model,
            ]);
			} else {

            return $this->redirect(['view', 'id' => $model->id]);
			}
        } else {
            return $this->render('komunikasi', [
                'lkj' => $lkj,
                'model' => $model,
            ]);
        }

    }

    public function actionOrientasihasil($id)
    {


        $model = $this->findModel($id);
		$assessee_model = SetkabAssessee::findOne($model->assessee_id);
		$lkj = SetkabLkj::find()->andWhere(['level' => strtolower($assessee_model->level)])->One();
		if (sizeof($lkj) == 0) {
			$lkj = new SetkabLkj;
		}
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			if (Yii::$app->request->post('submit2') == 'refresh') {
				            return $this->render('orientasihasil', [
                                'lkj' => $lkj,
                'model' => $model,
            ]);
			} else {

            return $this->redirect(['view', 'id' => $model->id]);
			}
        } else {
            return $this->render('orientasihasil', [
                'lkj' => $lkj,
                'model' => $model,
            ]);
        }

    }

    public function actionPelayananpublik($id)
    {


        $model = $this->findModel($id);
		$assessee_model = SetkabAssessee::findOne($model->assessee_id);
		$lkj = SetkabLkj::find()->andWhere(['level' => strtolower($assessee_model->level)])->One();
		if (sizeof($lkj) == 0) {
			$lkj = new SetkabLkj;
		}
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			if (Yii::$app->request->post('submit2') == 'refresh') {
				            return $this->render('pelayananpublik', [
                                'lkj' => $lkj,
                'model' => $model,
            ]);
			} else {

            return $this->redirect(['view', 'id' => $model->id]);
			}
        } else {
            return $this->render('pelayananpublik', [
                'lkj' => $lkj,
                'model' => $model,
            ]);
        }

    }


    public function actionPengembangandiri($id)
    {


        $model = $this->findModel($id);
		$assessee_model = SetkabAssessee::findOne($model->assessee_id);
		$lkj = SetkabLkj::find()->andWhere(['level' => strtolower($assessee_model->level)])->One();
		if (sizeof($lkj) == 0) {
			$lkj = new SetkabLkj;
		}
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			if (Yii::$app->request->post('submit2') == 'refresh') {
				            return $this->render('pengembangandiri', [
                                'lkj' => $lkj,
                'model' => $model,
            ]);
			} else {

            return $this->redirect(['view', 'id' => $model->id]);
			}
        } else {
            return $this->render('pengembangandiri', [
                'lkj' => $lkj,
                'model' => $model,
            ]);
        }

    }

    public function actionPerubahan($id)
    {


        $model = $this->findModel($id);
		$assessee_model = SetkabAssessee::findOne($model->assessee_id);
		$lkj = SetkabLkj::find()->andWhere(['level' => strtolower($assessee_model->level)])->One();
		if (sizeof($lkj) == 0) {
			$lkj = new SetkabLkj;
		}
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			if (Yii::$app->request->post('submit2') == 'refresh') {
				            return $this->render('perubahan', [
                                'lkj' => $lkj,
                'model' => $model,
            ]);
			} else {

            return $this->redirect(['view', 'id' => $model->id]);
			}
        } else {
            return $this->render('perubahan', [
                'lkj' => $lkj,
                'model' => $model,
            ]);
        }

    }


    public function actionPengambilankeputusan($id)
    {


        $model = $this->findModel($id);
		$assessee_model = SetkabAssessee::findOne($model->assessee_id);
		$lkj = SetkabLkj::find()->andWhere(['level' => strtolower($assessee_model->level)])->One();
		if (sizeof($lkj) == 0) {
			$lkj = new SetkabLkj;
		}
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			if (Yii::$app->request->post('submit2') == 'refresh') {
				            return $this->render('pengambilankeputusan', [
                                'lkj' => $lkj,
                'model' => $model,
            ]);
			} else {

            return $this->redirect(['view', 'id' => $model->id]);
			}
        } else {
            return $this->render('pengambilankeputusan', [
                'lkj' => $lkj,
                'model' => $model,
            ]);
        }

    }

    public function actionPerekatbangsa($id)
    {


        $model = $this->findModel($id);
		$assessee_model = SetkabAssessee::findOne($model->assessee_id);
		$lkj = SetkabLkj::find()->andWhere(['level' => strtolower($assessee_model->level)])->One();
		if (sizeof($lkj) == 0) {
			$lkj = new SetkabLkj;
		}
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			if (Yii::$app->request->post('submit2') == 'refresh') {
				            return $this->render('perekatbangsa', [
                                'lkj' => $lkj,
                'model' => $model,
            ]);
			} else {

            return $this->redirect(['view', 'id' => $model->id]);
			}
        } else {
            return $this->render('perekatbangsa', [
                'lkj' => $lkj,
                'model' => $model,
            ]);
        }

    }



}
