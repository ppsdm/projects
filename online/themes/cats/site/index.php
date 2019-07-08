<?php

use yii\helpers\Url;
use common\models\User;
use pao\modules\accounting\models\Accounting;

$this->title = 'PPSDM Online | CATS';

/* @var $this yii\web\View */

//$this->title = 'My Yii Application';
?>
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<style type="text/css">
  .vertical-center {
    min-height: 100%;  
    min-height: 100vh;
    display: flex;
    align-items: center;
  }
   .kotak {
       width: 500px;
       }
  .verticalLine {
     border-left: thick solid #ff0000;
      }


</style>
<div class=" vertical-center"> 
  <div class="container  text-center kotak">
      <div class="">
        <img src="images/logo_cats.png" width="80%" style="min-width: 200px;">
      </div><BR/>
      <div class="">
        <h4>Adalah aplikasi berbasis web yang secara khusus digunakan untuk melakukan rekrutmen secara online</h4>
      </div><BR/>
      <div class="row ">
        <div class="col-xs-6" style="border-right: 2px solid grey;"><a href="index.php/cats/cats/signup"><button type="button" class="btn btn-default">DAFTAR SEKARANG</button></a></div>
        <div class="col-xs-6"><a href="index.php/cats/cats/jobs"><button type="button" class="btn btn-default">LIHAT DAFTAR LOWONGAN</button></div></a>
    </div>
  </div>
</div>