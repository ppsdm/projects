<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\helpers\Url;
$this->title = 'SiapNgampus.com';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

	 <!-- Product Panel -->
      
            <div class="col-lg-4 col-md-4 col-sm-4 mb">
              <div class="product-panel-2 pn">
                <?= Html::img('@web/images/tablet-reader-hand_icon-icons.com_49272.png', ['width' => '200px']) ?>
                <h3 class="mt bg-warning">Latihan Soal</h3>
                <div class="row">
                  <div class="col-md-6"><h6>Total Soal: 1388</h6></div>
                  <div class="col-md-6">
                  <?= Html::a('Lihat Semua',['/edulab/edulab/soal'],['class'=>'btn btn-small btn-theme03']); ?>
                  </div>
                </div>     
              </div>
            </div><! --/col-md-4 -->			

            <!-- Product Panel -->
        
            <div class="col-lg-4 col-md-4 col-sm-4 mb">
              <div class="product-panel-2 pn">
                <div class="badge badge-hot">BARU</div>
                <?= Html::img('@web/images/open-book-pen_icon-icons.com_49283.png', ['width' => '200px']) ?>
                <h3 class="mt bg-warning">Try Out</h3>
                <div class="row">
                  <div class="col-md-6"><h6>Total Soal: 1388</h6></div>
                  <div class="col-md-6">
                  <?= Html::a('Lihat Semua',['/edulab/edulab/tryout'],['class'=>'btn btn-small btn-theme03']); ?>
                  </div>
                </div>
              </div>
            </div><! --/col-md-4 -->

             <!-- Product Panel -->
         
            <div class="col-lg-4 col-md-4 col-sm-4 mb">
              <div class="product-panel-2 pn">
                <?= Html::img('@web/images/screen-letter_icon-icons.com_49278.png', ['width' => '200px']) ?>
                <h3 class="mt bg-warning">Materi Video</h3>
                <div class="row">
                  <div class="col-md-6"><h6>Total Soal: 1388</h6></div>
                  <div class="col-md-6">
					<?= Html::a('Lihat Semua',['/edulab/edulab/video'],['class'=>'btn btn-small btn-theme03']); ?>
                  </div>
                </div>
              </div>
            </div><! --/col-md-4 -->

             <!-- Product Panel -->
         
            <div class="col-lg-4 col-md-4 col-sm-4 mb">
              <div class="product-panel-2 pn">
                <?= Html::img('@web/images/student-cap-books_icon-icons.com_49273.png', ['width' => '200px']) ?>
                <h3 class="mt bg-warning">Materi</h3>
                <div class="row">
                  <div class="col-md-6"><h6>Total Soal: 1388</h6></div>
                  <div class="col-md-6">
					<?= Html::a('Lihat Semua',['/edulab/edulab/materi'],['class'=>'btn btn-small btn-theme03']); ?>
                  </div>
                </div>
              </div>
            </div><! --/col-md-4 -->

</div>
