<?php


namespace common\modules\core\models;

use yii\base\Model;
use yii\web\UploadedFile;
use Yii;

class SpreadsheetUpload extends Model
{
    /**
     * @var UploadedFile
     */
    public $spreadsheetFile;

    public function rules()
    {
        return [
            [['spreadsheetFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'xls, xlsx'],
        ];
    }
    

    public function upload()
    {
        if ($this->validate()) {
            $this->spreadsheetFile->saveAs('project-uploads/' . $this->spreadsheetFile->baseName . '.' . $this->spreadsheetFile->extension);
            return true;
        } else {
            return false;
        }
    }

    public function projectupload($id)
    {
        if ($this->validate()) {
            $this->spreadsheetFile->saveAs('project-uploads/'.$id .'/scan/'. $this->spreadsheetFile->baseName . '.' . $this->spreadsheetFile->extension);
            return 'project-uploads/'.$id .'/scan/';
        } else {
            return false;
        }
    }

}

?>