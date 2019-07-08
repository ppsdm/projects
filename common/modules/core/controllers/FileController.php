<?php

namespace common\modules\core\controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;
/*error_reporting(E_ALL);
set_time_limit(0);
date_default_timezone_set('Europe/London');
*/

        class MyReadFilter implements IReadFilter
        {
    private $_startRow = 0;
    private $_endRow   = 0;
    private $_columns  = array();

    /**  Get the list of rows and columns to read  */
    public function __construct($startRow, $endRow, $columns) {
        $this->_startRow = $startRow;
        $this->_endRow   = $endRow;
        $this->_columns  = $columns;
    }

    public function readCell($column, $row, $worksheetName = '') {
        //  Only read the rows and columns that were configured
        if ($row >= $this->_startRow && $row <= $this->_endRow) {
            if (in_array($column,$this->_columns)) {
                return true;
            }
        }
        return false;
    }
        }



class FileController extends \yii\web\Controller
{




    public function actionIndex()
    {

	//	    	require 'vendor/autoload.php';


		/*$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'Hello World !');

		$writer = new Xlsx($spreadsheet);
		$writer->save('hello world.xlsx');
		*/

        $inputFileName = './uploads/scan/data.xlsx';
        echo 'Loading file ', pathinfo($inputFileName, PATHINFO_BASENAME), ' using IOFactory to identify the format<br />';
        //$spreadsheet = IOFactory::load($inputFileName);
        $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $reader->setReadDataOnly(true);
$filterSubset = new MyReadFilter(1,4,range('B','D'));

         $reader->setReadFilter($filterSubset);

        $spreadsheet = $reader->load($inputFileName);
        echo '<hr />';
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        //var_dump($sheetData);
        echo '<pre>';
        print_r($sheetData);


//echo 'sasa';

        //return $this->render('index');
    }

}
