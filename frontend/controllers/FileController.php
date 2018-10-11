<?php

namespace frontend\controllers;
use common\modules\core\models\SpreadsheetUpload;
use common\modules\core\models\File;
use common\modules\core\models\FileMeta;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\helpers\Url;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;

use Yii;


class FileController extends \common\modules\core\controllers\FileController {
    // empty class


    public function actionTest()
    {
    	echo 'test';
    }

    public function actionUpload($id)
    {
    	$spreadsheetuploadmodel = new SpreadsheetUpload;
    	$model = new File;

        $ids = FileMeta::find()->andWhere(['key' => 'project'])->andWhere(['value' => $id])->asArray()->All();
        $id_array = [];
        $id_array = ArrayHelper::getColumn($ids, 'file_id');
        

        $query = File::find()
        ->andWhere(['in', 'id',$id_array])
        //->andWhere(['like','tag',$tags_array])
        //->andWhere(['in', 'status', $status_array])
        ;

        $dataProvider = new ActiveDataProvider([
        'query' => $query,
        'pagination' => [
            'pageSize' => 20,
        ],
        ]);


    	if ($_POST) {
  
            $spreadsheetuploadmodel->spreadsheetFile = UploadedFile::getInstance($spreadsheetuploadmodel, 'spreadsheetFile');
			
			$model->name = $spreadsheetuploadmodel->spreadsheetFile->baseName . '.' . $spreadsheetuploadmodel->spreadsheetFile->extension;


			$path = $spreadsheetuploadmodel->projectupload($id);
			$file_exist = File::find()->andWhere(['name' => $model->name])->andWhere(['path' => $path])->One();
			if (null !== $file_exist) {
				$file_exist->modified_at = new Expression('NOW()');
				$file_exist->save();
				Yii::$app->session->addFlash('warning', 'File with the same name existed and overwritten');
			} else {
				$model->path = $path;
				$model->created_at = new Expression('NOW()');
				$model->save();
                $filemeta = new FileMeta();
                $filemeta->file_id = $model->id;
                $filemeta->type = 'scan';
                $filemeta->key = 'project';
                $filemeta->value = $id;
                $filemeta->save();
				Yii::$app->session->setFlash('success', 'File is saved');
			}

        }
    	return $this->render('upload',[
    		//'model' => $model,
            'dataProvider' => $dataProvider,
    		'spreadsheetuploadmodel' => $spreadsheetuploadmodel,
    		]);
    }
}

?>