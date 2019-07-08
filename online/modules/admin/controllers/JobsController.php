<?php

namespace cats\modules\admin\controllers;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use app\modules\cats\models\JobCatalog;
use app\modules\cats\models\JobCatalogSearch;
use Yii;



use app\models\jobsimageUpload;
use yii\db\Expression;
use yii\web\UploadedFile;
use yii\helpers\Html;

class JobsController extends \yii\web\Controller
{
    public function actionIndex()
    {
            $searchModel = new JobCatalogSearch;
       $dataProvider = $searchModel->search(Yii::$app->request->queryParams);



        return $this->render('index',[
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            ]);
    }


    public function actionUpdate($id)
    {

    	$model = JobCatalog::findOne($id);

                if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->addFlash('success','Job Updated');
                        return $this->redirect('index');
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }




    }

    public function actionView($id)
    {

        $model = JobCatalog::findOne($id);

            return $this->render('view', [
                'model' => $model,
            ]);
        

    }

    public function actionPreview($id)
    {

        $model = JobCatalog::findOne($id);

            return $this->renderPartial('preview', [
                'model' => $model,
            ]);
        

    }

    public function actionImageupload()
    {
/*
        //echo 'image';
        echo '<pre>';
        print_r($_REQUEST);
        echo '<hr/>';
        //print_r($file);
        echo '<hr/>';
        print_r($_FILES['upload']);
*/

$imageuploadmodel = new jobsimageUpload;
$imageFile = new UploadedFile();


$imageFile->name = $_FILES['upload']['name'];
$imageFile->type  = $_FILES['upload']['type'];
$imageFile->size = $_FILES['upload']['size'];
$imageFile->error  = $_FILES['upload']['error'];
$imageFile->tempName  = $_FILES['upload']['tmp_name'];



            $imageuploadmodel->imageFile = $imageFile;

           // print_r($imageuploadmodel);

if(sizeof($imageuploadmodel->imageFile) > 0) {


     // Required: anonymous function reference number as explained above.
$funcNum = $_GET['CKEditorFuncNum'] ;

// Check the $_FILES array and save the file. Assign the correct path to a variable ($url).

// Usually you will only assign something here if the file could not be uploaded.
$message = 'File has been uploaded';
$url = '/path/to/uploaded/file.ext';
     $url = $imageuploadmodel->upload();

echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";
//echo Html::img('@web/jobs/images/' . $id. '_' . $imageuploadmodel->imageFile->name);
     //echo '<pre>';
     //print_r($imageuploadmodel);
         //$this->redirect('index');



} else {
 //   $this->redirect('http://www.detik.com');
    echo 'eror';
}



    }


    public function actionCreate()
    {
        $model = new JobCatalog();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->addFlash('success','Job Created');
                        return $this->redirect('index');
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }

    }

}
