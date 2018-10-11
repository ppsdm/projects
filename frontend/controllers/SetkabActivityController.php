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
use yii2tech\html2pdf\Manager;
use kartik\mpdf\Pdf;
use yii\helpers\HtmlPurifier;
// use mPDF;

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
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                //'only' => ['create', 'update'],
                'rules' => [

                    // allow authenticated users
                    [
                        'actions' => ['pdf', 'pdf2'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    // everything else is denied
                ],
                'denyCallback' => function($rule, $action) {
                    return Yii::$app->response->redirect(['site/login']);
                },
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
		$params['SetkabActivitySearch']['assessor_id'] = Yii::$app->user->id;
        $dataProvider = $searchModel->search($params);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);


    }


    public function actionIndexadmin()
    {
        $searchModel = new SetkabActivitySearch();
		$params = Yii::$app->request->queryParams;
		//$params['SetkabActivitySearch']['assessor_id'] = ;
        $dataProvider = $searchModel->search($params);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);


		//echo Yii::$app->user->id;
		//echo '<pre>';
		//print_r($params);

    }
    public function actionSoindex()
    {
        $searchModel = new SetkabActivitySearch();
		$params = Yii::$app->request->queryParams;
		$params['SetkabActivitySearch']['second_opinion_id'] = Yii::$app->user->id;
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
    public function actionView3($id)
    {
        if ($role = $this->checkRole($id)) {
        $kompetensi_min = 140;
        $kompetensi_max = 200;
		$saran_min = 130;
		$saran_max = 700;
		$exsum_min = 600;
        $exsum_max = 700;

$allowedit = true;
        //readonlyview
        $model = $this->findModel($id);
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


        return $this->render('view3', [
            'model' => $this->findModel($id),
            'min' => $kompetensi_min,
            'max' => $kompetensi_max,
            'saran_min' => $saran_min,
            'saran_max' => $saran_max,
            'exsum_min' => $exsum_min,
            'exsum_max' => $exsum_max,
            'role' => $role
        ]);
        } else {
            return $this->render('readonlyview', [
                'model' => $this->findModel($id),
                'min' => $kompetensi_min,
                'max' => $kompetensi_max,
                'saran_min' => $saran_min,
                'saran_max' => $saran_max,
                'exsum_min' => $exsum_min,
                'exsum_max' => $exsum_max,
                'role' => $role
            ]);
        }

    } else {
            echo 'not allowed';
        }
    }


    public function actionView($id)
    {
        if ($role = $this->checkRole($id)) {
        $kompetensi_min = 140;
        $kompetensi_max = 200;
		$saran_min = 130;
		$saran_max = 700;
		$exsum_min = 600;
        $exsum_max = 700;

$allowedit = true;
        //readonlyview
        $model = $this->findModel($id);
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
            'min' => $kompetensi_min,
            'max' => $kompetensi_max,
            'saran_min' => $saran_min,
            'saran_max' => $saran_max,
            'exsum_min' => $exsum_min,
            'exsum_max' => $exsum_max,
            'role' => $role
        ]);
        } else {
            return $this->render('readonlyview', [
                'model' => $this->findModel($id),
                'min' => $kompetensi_min,
                'max' => $kompetensi_max,
                'saran_min' => $saran_min,
                'saran_max' => $saran_max,
                'exsum_min' => $exsum_min,
                'exsum_max' => $exsum_max,
                'role' => $role
            ]);
        }

    } else {
            echo 'not allowed';
        }
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
        $word_count = str_word_count(strip_tags($replaced_dom));
}
		$total_count = $word_count + $li_count;

       return $total_count;

    }

	public function actionDebug($id)
	{




	}

    function actionVal($id)
    {
        $model = $this->findModel($id);
       $integritas_uraian = $this->countWord($model->integritas_uraian);

    }

    function submitValidation($id)
    {
        //echo 'validasi data laporan. kalua belum maka ditolak';

        $kompetensi_min = 140;
        $kompetensi_max = 200;
		$saran_min = 130;
		$saran_max = 700;
		$exsum_min = 600;
		$exsum_max = 700;
        //cek jumlah karakter tiap uraian
        $model = $this->findModel($id);
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
/*

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
*/

        $psikogram_berpikiranalitis = $model->psikogram_berpikiranalitis;
        $psikogram_empati = $model->psikogram_empati;
        $psikogram_inteligensiumum = $model->psikogram_inteligensiumum;
        $psikogram_kemampuanbelajar = $model->psikogram_kemampuanbelajar;
        $psikogram_ketekunan = $model->psikogram_ketekunan;
        $psikogram_ketelitian = $model->psikogram_ketelitian;
        $psikogram_komunikasiefektif = $model->psikogram_komunikasiefektif;
        $psikogram_konsepdiri = $model->psikogram_konsepdiri;
        $psikogram_logikaberpikir = $model->psikogram_logikaberpikir;
        $psikogram_motivasi = $model->psikogram_motivasi;
        $psikogram_pemahamansosial = $model->psikogram_pemahamansosial;
        $psikogram_pengaturandiri = $model->psikogram_pengaturandiri;
        $psikogram_sistematikakerja = $model->psikogram_sistematikakerja;
        $psikogram_tempokerja = $model->psikogram_tempokerja;
        $psikogram_fleksibilitasberpikir = $model->psikogram_fleksibilitasberpikir;

        $message = '';
        $valid = true;

        if (is_null($psikogram_berpikiranalitis)) {
            $message = $message . ' psikogram berpikiran analitis belum diisi; <br/>';
            $valid = false;
        }
        if (is_null($psikogram_empati)) {
            $message = $message . ' psikogram empati belum diisi; <br/>';
            $valid = false;
        }
        if (is_null($psikogram_inteligensiumum)) {
            $message = $message . ' psikogram inteligensi umum belum diisi; <br/>';
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
        if (is_null($psikogram_pengaturandiri)) {
            $message = $message . ' psikogram pengaturan diri belum diisi; <br/>';
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
        if (is_null($psikogram_fleksibilitasberpikir)) {
            $message = $message . ' psikogram fleksibilitas berpikir belum diisi; <br/>';
            $valid = false;
        }


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
                return ($message);
                //return ($valid);
            }
            else {
               // echo 'err';
                return ($message);
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

    public function actionReviewed($id)
	{

        $model = $this->findModel($id);
        $model->status = 'reviewed';
        $model->save();
        Yii::$app->session->setFlash('success', "Review Success");


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


    public function actionPdf2($id)
    {
        $activityModel = $this->findModel($id);
        $assesseeModel = SetkabAssessee::findOne($activityModel->assessee_id);
        $lkjModel = SetkabLkj::find()->andWhere(['level' => $activityModel->assessee->level])->One();
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
        $sumbuX = $sumbuX + $activityModel->psikogram_berpikiranalitis;
        $sumbuX = $sumbuX + $activityModel->psikogram_empati;
        $sumbuX = $sumbuX + $activityModel->psikogram_inteligensiumum;
        $sumbuX = $sumbuX + $activityModel->psikogram_kemampuanbelajar;
        $sumbuX = $sumbuX + $activityModel->psikogram_ketekunan;
        $sumbuX = $sumbuX + $activityModel->psikogram_ketelitian;
        $sumbuX = $sumbuX + $activityModel->psikogram_komunikasiefektif;
        $sumbuX = $sumbuX + $activityModel->psikogram_konsepdiri;
        $sumbuX = $sumbuX + $activityModel->psikogram_logikaberpikir;
        $sumbuX = $sumbuX + $activityModel->psikogram_motivasi;
        $sumbuX = $sumbuX + $activityModel->psikogram_pemahamansosial;
        $sumbuX = $sumbuX + $activityModel->psikogram_pengaturandiri;
        $sumbuX = $sumbuX + $activityModel->psikogram_sistematikakerja;
        $sumbuX = $sumbuX + $activityModel->psikogram_tempokerja;
        $sumbuX = $sumbuX + $activityModel->psikogram_fleksibilitasberpikir;

        $pembagiSumbuX = 70;

        $date =  date_create($activityModel->tanggal_test);

        //echo date_format($date,"Y/m/d H:i:s");
        $month =  date_format($date,"n");
        $day = date_format($date,"j");
        $romawi  = $this->numberToRomawi($month);

        $level_jabatan = '';
        switch (strtolower($assesseeModel->level)) {
            case "iia":
            $level_jabatan = 'es 2';;
                break;
            case "iiia":
            $level_jabatan = 'es 3';
                break;
            case "iva":
                $level_jabatan = 'es 4';
                break;
            case "jft3":
                $level_jabatan = 'jft';
                break;
            case "jft4":
                $level_jabatan = 'jft';
                break;
            case "pelaksana":
                $level_jabatan = 'pelaksana';
                break;
            default:
                $level_jabatan = '';
        }

        $notest = $activityModel->no_test . '/EVA/' . $level_jabatan.'/SETKAB/'.$romawi.'/18';

        $dateTest =  $day . ' - ' . ($day + 2) . ' ' . date_format($date,"F") . ' 2018';

            $content =  $this->renderPartial('pdf2',[
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
                ]);

        return $content;
    }

	public function actionPdf($id)
	{

    $activityModel = $this->findModel($id);
    $assesseeModel = SetkabAssessee::findOne($activityModel->assessee_id);
    $lkjModel = SetkabLkj::find()->andWhere(['level' => $activityModel->assessee->level])->One();
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
    $sumbuX = $sumbuX + $activityModel->psikogram_berpikiranalitis;
    $sumbuX = $sumbuX + $activityModel->psikogram_empati;
    $sumbuX = $sumbuX + $activityModel->psikogram_inteligensiumum;
    $sumbuX = $sumbuX + $activityModel->psikogram_kemampuanbelajar;
    $sumbuX = $sumbuX + $activityModel->psikogram_ketekunan;
    $sumbuX = $sumbuX + $activityModel->psikogram_ketelitian;
    $sumbuX = $sumbuX + $activityModel->psikogram_komunikasiefektif;
    $sumbuX = $sumbuX + $activityModel->psikogram_konsepdiri;
    $sumbuX = $sumbuX + $activityModel->psikogram_logikaberpikir;
    $sumbuX = $sumbuX + $activityModel->psikogram_motivasi;
    $sumbuX = $sumbuX + $activityModel->psikogram_pemahamansosial;
    $sumbuX = $sumbuX + $activityModel->psikogram_pengaturandiri;
    $sumbuX = $sumbuX + $activityModel->psikogram_sistematikakerja;
    $sumbuX = $sumbuX + $activityModel->psikogram_tempokerja;
    $sumbuX = $sumbuX + $activityModel->psikogram_fleksibilitasberpikir;

    $pembagiSumbuX = 70;

    $date =  date_create($activityModel->tanggal_test);

    //echo date_format($date,"Y/m/d H:i:s");
    $month =  date_format($date,"n");
    $day = date_format($date,"j");
    $romawi  = $this->numberToRomawi($month);

    $level_jabatan = '';
    switch (strtolower($assesseeModel->level)) {
        case "iia":
        $level_jabatan = 'es 2';;
            break;
        case "iiia":
        $level_jabatan = 'es 3';
            break;
        case "iva":
            $level_jabatan = 'es 4';
            break;
        case "jft3":
            $level_jabatan = 'jft';
            break;
        case "jft4":
            $level_jabatan = 'jft';
            break;
        case "pelaksana":
            $level_jabatan = 'pelaksana';
            break;
        default:
            $level_jabatan = '';
    }

    $notest = $activityModel->no_test . '/EVA/' . $level_jabatan.'/SETKAB/'.$romawi.'/18';

    $dateTest =  $day . ' - ' . ($day + 2) . ' ' . date_format($date,"F") . ' 2018';

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

    public function actionGetfile($id)
    {


        //$pa_id = ProjectActivityMeta::find()->andWhere(['project_activity_id' =>$id])->andWhere(['type' => 'general'])
        //->andWhere(['key' => 'assessee'])->One();   
        //$profile_basic = Profile::find()->andWhere(['id' => $pa_id->value])->One();
        $search  = array('.', ' ', ',');
        $replace = array('', '_', '');

        
        $filename = trim(str_replace($search, $replace, $id)).".pdf";

        /* GET METHOD
        $base64url = base64_encode('{url:"http://projects.ppsdm.com/index.php/projects/activity/pdf?id='.$id.'",renderType:"pdf",paperSize :"A4"}');
        $phantomPdf = "https://api.phantomjscloud.com/api/browser/v2/ak-e6rha-y3pt8-t036y-443eq-52eyk/?requestBase64=".$base64url;
        $filecontent=file_get_contents($phantomPdf);
        header("Content-type:application/pdf");
        header("Content-disposition: attachment; filename=$filename");
        header("Pragma: no-cache");
        echo $filecontent;
        */

        $url = 'https://api.PhantomJsCloud.com/api/browser/v2/ak-sxjfq-71djm-5h900-r9z2s-0dd0h/';
        $payload = '
        {
            "url":"https://amazon.com",
            "renderType":"pdf",
            "renderSettings": {
                "quality": 70,
                "pdfOptions": {
                    "border": null,
                    "footer": {
                        "firstPage": "",
                        "height": "1cm",
                        "lastPage": null,
                        "onePage": null,
                        "repeating": "Halaman %pageNum%  dari %numPages%"
                    },
                    "format": "A4",
                    "header": "this is header",
                    "height": "210mm",
                    "orientation": "portrait",
                    "width": "210mm"
                },
				"viewport": {
					"height": 1280,
					"width": 1280
				},
				"zoomFactor": 10,
            },
        }'
        ;
        /*$options = array(
            'http' => array(
                'header'  => "Content-type: application/pdf\r\n",
                'method'  => 'POST',
                'content' => $payload
            )
        );
*/
       // $payload = file_get_contents ( 'request.json' );
$options = array(
    'http' => array(
        'header'  => "Content-type: application/json\r\n",
        'method'  => 'POST',
        'content' => $payload
    )
);


/*
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === FALSE) {  }
        
        header("Content-type:application/pdf");
        header("Content-disposition: attachment; filename=$filename");
        header("Pragma: no-cache");
        echo $result;
*/

        $context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
if ($result === FALSE) { /* Handle error */ }
file_put_contents('content.pdf',$result);

 
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

    public function actionExsum($id)
    {
        if ($role = $this->checkRole($id)) {
        $model = $this->findModel($id);

        $lkjmodel = SetkabLkj::find()->andWhere(['level' => $model->assessee->level])->One();
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

    public function actionDatadiri($id)
    {
        if ($role = $this->checkRole($id)) {
        $model = $this->findModel($id);
		$assessee_model = SetkabAssessee::findOne($model->assessee_id);
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
    public function actionKelemahan($id)
    {
        if ($role = $this->checkRole($id)) {
        $model = $this->findModel($id);
        $lkjmodel = SetkabLkj::find()->andWhere(['level' => $model->assessee->level])->One();

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

    public function actionKelemahan2($id)
    {
        if ($role = $this->checkRole($id)) {
        $model = $this->findModel($id);
        $lkjmodel = SetkabLkj::find()->andWhere(['level' => $model->assessee->level])->One();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('kelemahan2', [
                'model' => $model,  'role' => $role,'lkjmodel' => $lkjmodel,
            ]);
        }    } else {
            echo 'not allowed';
        }
    }


    public function actionKekuatan($id)
    {
        if ($role = $this->checkRole($id)) {

        $model = $this->findModel($id);
        $lkjmodel = SetkabLkj::find()->andWhere(['level' => $model->assessee->level])->One();

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






    public function actionIntegritas($id)
    {

        if ($role = $this->checkRole($id)) {
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
        }    } else {
            echo 'not allowed';
        }

    }






    public function actionKerjasama($id)
    {
        if ($role = $this->checkRole($id)) {
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
        }    } else {
            echo 'not allowed';
        }

    }



    public function actionKomunikasi($id)
    {

        if ($role = $this->checkRole($id)) {
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
		$assessee_model = SetkabAssessee::findOne($model->assessee_id);
		$lkj = SetkabLkj::find()->andWhere(['level' => strtolower($assessee_model->level)])->One();
		if (sizeof($lkj) == 0) {
			$lkj = new SetkabLkj;
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
		$assessee_model = SetkabAssessee::findOne($model->assessee_id);
		$lkj = SetkabLkj::find()->andWhere(['level' => strtolower($assessee_model->level)])->One();
		if (sizeof($lkj) == 0) {
			$lkj = new SetkabLkj;
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
		$assessee_model = SetkabAssessee::findOne($model->assessee_id);
		$lkj = SetkabLkj::find()->andWhere(['level' => strtolower($assessee_model->level)])->One();
		if (sizeof($lkj) == 0) {
			$lkj = new SetkabLkj;
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
		$assessee_model = SetkabAssessee::findOne($model->assessee_id);
		$lkj = SetkabLkj::find()->andWhere(['level' => strtolower($assessee_model->level)])->One();
		if (sizeof($lkj) == 0) {
			$lkj = new SetkabLkj;
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
		$assessee_model = SetkabAssessee::findOne($model->assessee_id);
		$lkj = SetkabLkj::find()->andWhere(['level' => strtolower($assessee_model->level)])->One();
		if (sizeof($lkj) == 0) {
			$lkj = new SetkabLkj;
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

    function checkRole($id)
    {
        $hasright = false;
        $model = $this->findModel($id);
        $userid = Yii::$app->user->id;
        if($model->second_opinion_id == $userid) {
            $hasright = 'secondopinion';
        } elseif ($model->assessor_id == $userid) {
            $hasright = 'assessor';
        } elseif ($userid == '1') {
            $hasright = 'admin';
        }


        return $hasright;
    }


    public function beforeAction($action)
{
/*
    $hasright = false;
    if (Yii::$app->user->identity->username == 'admin') {
        $hasright = true;
    }

    if ($hasright) {
    return parent::beforeAction($action);
    } else {
        echo 'not allowed';
    }
    */
    return parent::beforeAction($action);
}


    public function actionPerekatbangsa($id)
    {
        if ($role = $this->checkRole($id)) {

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


    public function actionPengolah($id)
    {
        echo '<h2>pengolah</h2>';
    }


    public function actionIndex1()
    {
        //untuk batch 1

        $searchModel = new SetkabActivitySearch();
        $params = Yii::$app->request->queryParams;
        if (Yii::$app->user->id != 1) { // IF NON ADMIN
        $params['SetkabActivitySearch']['assessor_id'] = Yii::$app->user->id;
        }
        $dataProvider = $searchModel->search($params);
        $dataProvider->query->andWhere('id >= 4')->andWhere('id <= 17');
        $dataProvider->pagination = ['pageSize' => 50,];


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndex2()
    {
        //untuk batch 2

        $searchModel = new SetkabActivitySearch();
        $params = Yii::$app->request->queryParams;
        if (Yii::$app->user->id != 1) { // IF NON ADMIN
        $params['SetkabActivitySearch']['assessor_id'] = Yii::$app->user->id;
        }
        $dataProvider = $searchModel->search($params);
        $dataProvider->query->andWhere('id >= 18')->andWhere('id <= 48');
        $dataProvider->pagination = ['pageSize' => 50,];


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndex3()
    {
        //untuk batch 3

        $searchModel = new SetkabActivitySearch();
        $params = Yii::$app->request->queryParams;
        if (Yii::$app->user->id != 1) { // IF NON ADMIN
        $params['SetkabActivitySearch']['assessor_id'] = Yii::$app->user->id;
        }
        $dataProvider = $searchModel->search($params);
        $dataProvider->query->andWhere('id >= 49')->andWhere('id <= 68');
        $dataProvider->pagination = ['pageSize' => 50,];


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndex4()
    {
        //untuk batch 4

        $searchModel = new SetkabActivitySearch();
        $params = Yii::$app->request->queryParams;
        if (Yii::$app->user->id != 1) { // IF NON ADMIN
        $params['SetkabActivitySearch']['assessor_id'] = Yii::$app->user->id;
        }
        $dataProvider = $searchModel->search($params);
        $dataProvider->query->andWhere('id >= 69')->andWhere('id <= 98');
        $dataProvider->pagination = ['pageSize' => 50,];


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndex5()
    {
        //untuk batch 4

        $searchModel = new SetkabActivitySearch();
        $params = Yii::$app->request->queryParams;
        if (Yii::$app->user->id != 1) { // IF NON ADMIN
        $params['SetkabActivitySearch']['assessor_id'] = Yii::$app->user->id;
        }
        $dataProvider = $searchModel->search($params);
        $dataProvider->query->andWhere('id >= 99')->andWhere('id <= 134');
        $dataProvider->pagination = ['pageSize' => 50,];


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndex6()
    {
        //untuk batch 4

        $searchModel = new SetkabActivitySearch();
        $params = Yii::$app->request->queryParams;
        if (Yii::$app->user->id != 1) { // IF NON ADMIN
        $params['SetkabActivitySearch']['assessor_id'] = Yii::$app->user->id;
        }
        $dataProvider = $searchModel->search($params);
        $dataProvider->query->andWhere('id >= 135')->andWhere('id <= 160');
        $dataProvider->pagination = ['pageSize' => 50,];


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    public function actionIndex7()
    {
        //untuk batch 4

        $searchModel = new SetkabActivitySearch();
        $params = Yii::$app->request->queryParams;
        if (Yii::$app->user->id != 1) { // IF NON ADMIN
        $params['SetkabActivitySearch']['assessor_id'] = Yii::$app->user->id;
        }
        $dataProvider = $searchModel->search($params);
        $dataProvider->query->andWhere('id >= 168')->andWhere('id <= 197');
        $dataProvider->pagination = ['pageSize' => 50,];


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndex8()
    {

        $searchModel = new SetkabActivitySearch();
        $params = Yii::$app->request->queryParams;
        if (Yii::$app->user->id != 1) { // IF NON ADMIN
        $params['SetkabActivitySearch']['assessor_id'] = Yii::$app->user->id;
        }
        $dataProvider = $searchModel->search($params);
        $dataProvider->query->andWhere('id >= 198')->andWhere('id <= 225');
        $dataProvider->pagination = ['pageSize' => 50,];


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


	public function actionHelp()
{

	return $this->render('help');
}

public function actionNomortes($id)
{
    $activityModel = $this->findModel($id);
    $assesseeModel = SetkabAssessee::findOne($activityModel->assessee_id);

    /*No Test: 20/EVA/ES 2/SETKAB/IX/18*
terdiri dari : 20 - no test saat pengambilan data
EVA : tujuan kegiatan test nama lain dari EVALUASI
ES 2 : level jabatan disesuaiakan, Eselon 2, Eselon 3. Eselon 4. Pelaksana (PEL), dan JFT
SETKAB: Nama lembaga
IX : Bulan diambil data
18 : Tahun diambil data
*/

$date =  date_create($activityModel->tanggal_test);

//echo date_format($date,"Y/m/d H:i:s");
$month =  date_format($date,"n");
$day = date_format($date,"j");
$notest = $activityModel->no_test . '/EVA/' . $assesseeModel->level.'/SETKAB/'.$month.'/18';
    echo $notest;

    echo '<br/>';

echo $day . ' - ' . ($day + 2) . ' ' . date_format($date,"F") . ' 2018';

}



}
