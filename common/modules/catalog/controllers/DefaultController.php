<?php

namespace common\modules\catalog\controllers;
use common\modules\catalog\models\CatalogGeneral;
use common\modules\catalog\models\CatalogGeneralSearch;
use yii\data\ActiveDataProvider;

use yii\web\Controller;
use common\models\User as User;
//use app\modules\catalog\models\;
use Yii;
use common\models\Log;
use yii\db\Expression;


/**
 * Default controller for the `catalog` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */


    public function actionIndex($path)
    {

$returnpath = '';
        if ($path =='') {
$returnpath = 'catalogindex';
        } else if ($path == 'akademik') {
            $returnpath = 'akademik-index';
        } else if ($path == 'nonakademik') {
            $returnpath = 'nonakademik-index';
        } else if ($path == 'akademik-sma') {
            $returnpath = 'akademik-sma-index';
        } else {
            $returnpath = 'notfound';
        }
        

                return $this->render($returnpath, [
                        //'dataProvider' => $provider,
        ]);



    }


    public function actionList($selection)
    {

        $selections = explode(",",urldecode($selection));

     //   echo urldecode($selection);
        $selectionarray =[];
        foreach ($selections as $key => $value) {
            if (($value != null) && !empty($value))
                array_push($selectionarray, ',' . $value . ',');
            //echo $value;
            //echo 'ww';
            //echo '<br/>';
        }

        //print_r($selectionarray);

        $query = CatalogGeneral::find()->andWhere(['like', 'tag', $selectionarray]);

$provider = new ActiveDataProvider([
    'query' => $query,
    'pagination' => [
        //'pageSize' => 10,
    ],
    'sort' => [
        'defaultOrder' => [
            //'created_at' => SORT_DESC,
            //'title' => SORT_ASC, 
        ]
    ],
]);


        

                return $this->render('cataloglist', [
                        'dataProvider' => $provider,
        ]);


    }


    //public function action



    public function actionTest()
    {
        return $this->render('test');
    }

    public function actionView($catalog_id){

        echo $catalog_id;
    }

    public function actionDirectory($directory) {


        $selections = explode(";",$directory);
        $selectionarray =[];
        $selectionstring = 'directory';
        foreach ($selections as $key => $value) {
            if (($value != null) && !empty($value)) {
                array_push($selectionarray, ',' . $value . ',');
            $selectionstring = $selectionstring . '_' . $value;
        }
            //echo $value;
            //echo '<br/>';
        }
        //echo $selectionstring;

                return $this->render($selectionstring, [
           //             'dataProvider' => $provider,
        ]);
       

    }

    public function actionTestCategory()
    {
        $test = array(
            'akademik' => 'Akademik', 
            'non-akademik' => 'Non Akademik'
        );
        return $this->render('testCategory', ['test' => $test]);
    }

    public function actionJenjang()
    {
        $test = Yii::$app->request->queryParams;
        if (array_key_exists('kategori', $test)) {
            if ($test['kategori'] == 'akademik') {
                $jenjang = array(
                    'sd' => 'Sekolah Dasar',
                    'smp' => 'Sekolah Menengah Pertama',
                    'sma' => 'Sekolah Menengah Atas'
                );
            } else if ($test['kategori'] == 'non-akademik') {
                $jenjang = array(
                    'iq' => 'IQ',
                    'eq' => 'EQ'
                );
            }

            return $this->render('jenjang', [
                'kategori' => $test['kategori'],
                'jenjang' => $jenjang
            ]);
        }
    }

    public function actionMataPelajaran()
    {
        $test = Yii::$app->request->queryParams;
        if (array_key_exists('kategori', $test) && array_key_exists('jenjang', $test)) {
            $mapel = array(
                'ipa' => 'Ilmu Pengetahuan Alam',
                'ips' => 'Ilmu Pengetahuan Sosial',
                'bahasa' => 'Ilmu Bahasa'
            );

            return $this->render('mataPelajaran', [
                'kategori' => $test['kategori'],
                'jenjang' => $test['jenjang'],
                'mapel' => $mapel
            ]);
        }
    }

    public function actionBab()
    {
        $test = Yii::$app->request->queryParams;
        if (array_key_exists('kategori', $test) && array_key_exists('jenjang', $test) && array_key_exists('mapel', $test)) {
            $bab = array(
                'bab-1' => 'Tulang',
                'bab-2' => 'Kulit',
                'bab-3' => 'Pencernaan'
            );

            return $this->render('bab', [
                'kategori' => $test['kategori'],
                'jenjang' => $test['jenjang'],
                'mapel' => $test['mapel'],
                'bab' => $bab
            ]);
        }
    }

    public function actionPenjelasan()
    {
        $test = Yii::$app->request->queryParams;
        if (array_key_exists('kategori', $test) && array_key_exists('jenjang', $test) && array_key_exists('mapel', $test) && array_key_exists('bab', $test)) {
            $guide = 'lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum \nlorem ipsum lorem ipsum lorem ipsum \nlorem ipsum lorem ipsum';

            return $this->render('penjelasan', [
                'kategori' => $test['kategori'],
                'jenjang' => $test['jenjang'],
                'mapel' => $test['mapel'],
                'bab' => $test['bab'],
                'guide' => $guide
            ]);
        }
    }


    public function actionCategory($id) {

        $category = CatalogGeneral::findOne($id);
        $lessons = CatalogGeneral::find()
                    ->andWhere(['type' => 'lesson'])
->andWhere(['like', 'tag', $category->tag])
                    ->All();

//echo '<pre>';
                    //print_r($lesson);

   
                return $this->render('category_view', [
                        'lessons' => $lessons
        ]);
    }





                public function beforeAction($action) {

  Log::add(Yii::$app->controller->id, $action->id,'activity');
    if (Yii::$app->session->has('lang')) {
        Yii::$app->language = Yii::$app->session->get('lang');
    } else {
        //or you may want to set lang session, this is just a sample
        //Yii::$app->language = 'us';
    }
    return parent::beforeAction($action);
}



public function log($controller, $action)
{
  $log = new Log();
$log->user_id = Yii::$app->user->id;
$log->type = 'activity';
$log->controller = $controller;
$log->action = $action;
  $log->timestamp = new Expression('NOW()');
  $log->save();

}
}
