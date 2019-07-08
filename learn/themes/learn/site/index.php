<?php

use yii\helpers\Url;
use common\models\User;
use app\modules\accounting\models\Accounting;

$this->title = 'Siap Ngampus | Belajar & Ujian Online';

/* @var $this yii\web\View */

//$this->title = 'My Yii Application';
?>
<BR>
<div class="bg"></div>
<div class="jumbotron">
    <div class="container" style="margin:auto";>

        <p class="lead"><h2></h2></p>

     <br/><br/><br/><br/><br/>   <BR><BR><BR> <BR><BR><BR><br/>
        <p style=" text-align: center;"><a class="btn-menu-transparent btn-trns" href="
        <?php
            if (Yii::$app->user->isGuest) {
                echo Url::to(['/site/signup']);
            } else {
                echo Url::to(['/catalog']);
            }
        ?>
         ">DAFTAR SEKARANG</a></p>
        </div>
           <br>
    <div id="mid">
    </div>
</div>
<div id="mid-yellow">
    <div class="container">
        <div class="row">
              <a href="#">
              <div class="col-md-4 text-center">
                  <img src="<?=@web?>../../images/tes-online.png">
                  <BR><span id="tittle">Test Online</span><BR>
                  <BR><span id="sub-tittle">Mengerjakan soal-soal latihan untuk<BR>menghadapi ujian secara online</span><BR>
              </div>
              </a>
              <a href="#">
              <div class="col-md-4 text-center">
              <img src="<?=@web?>../../images/hasil-instant.png">
                  <BR><span id="tittle">Hasil Instant</span><BR>
                  <BR><span id="sub-tittle">Melihat hasil penilaian test yang<BR>sudah dikerjakan</span><BR>
              </div>
              </a>
              <a href="#">
              <div class="col-md-4 text-center">
              <img src="<?=@web?>../../images/papan-peringkat.png">
                  <BR><span id="tittle">Papan Peringkat</span><BR>
                  <BR><span id="sub-tittle">Bersaing dengan teman-temanmu<BR>untuk menjadi yang pertama</span><BR>
              </div>
              </a>
        </div>
    </div>
</div>
