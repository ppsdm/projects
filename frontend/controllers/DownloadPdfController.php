<?php

namespace frontend\controllers;

use \yii\helpers\VarDumper;
use app\modules\projects\models\ProjectActivityMeta;
use app\modules\profile\models\Profile;
use kartik\mpdf\Pdf;

class DownloadPdfController extends \yii\web\Controller
{
    public function actionIndex($id)
    {
      $projectActivityId = ProjectActivityMeta::find()->andWhere(['project_activity_id' =>$id])->andWhere(['type' => 'general'])
      ->andWhere(['key' => 'assessee'])->One();

      $profile = Profile::find()->andWhere(['id' => $projectActivityId->value])->One();

      $search  = array('.', ' ', ',');
      $replace = array('', '_', '');

      $filename = trim(str_replace($search, $replace, $profile->first_name)).".pdf";

      $url = 'https://api.phantomjscloud.com/api/browser/v2/ak-e6rha-y3pt8-t036y-443eq-52eyk/';
      $payload = '
      {
          "url":"http://projects.ppsdm.com/index.php/projects/activity/pdf?id='.$id.'",
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
                  "orientation": "potrait",
                  "width": "210mm"
              },
              "viewport": {
                "height": 1280,
                "width": 1280
              },
              "zoomFactor": 10,
          },
      }';

      $options = array(
          'http' => array(
              'header'  => "Content-type: application/pdf\r\n",
              'method'  => 'POST',
              'content' => $payload
          )
      );

      $context  = stream_context_create($options);
      $result = file_get_contents($url, false, $context);
      if ($result === FALSE) { /* Handle error */ }
      header("Content-type:application/pdf");
      header("Content-disposition: attachment; filename=$filename");
      header("Pragma: no-cache");
      echo $result;

      VarDumper::dump($result);

    }

    public function actionDownloadPdf($id){

    }

}
