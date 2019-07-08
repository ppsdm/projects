<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use app\assets\AppAsset;
use app\assets\SortAsset;

AppAsset::register($this);
SortAsset::register($this);

$this->title = 'Video';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="row">
  <div class="col-md-9 col-md-push-3">
                  <ul id="container">
            <li data-genre="zenner" data-main-actors="benazio" data-director="adel">
                        <! -- Spotify Panel -->
                        <div class="col-lg-4 col-md-4 col-sm-4 mb" data-director="adel">
                          <div class="content-panel pn">
                            <div id="spotify">
                              <div class="embed-responsive embed-responsive-16by9">
                                  <iframe class="embed-responsive-item" src="//www.youtube.com/embed/TZwBTBIIUQo"></iframe>
                              </div>
                              
                              <div class="play">

                                <i class="fa fa-play-circle"></i>
                              </div>
                            </div>
                            <p class="followers">Matematika (Algoritma Dasar)</p>
                          </div>
                        </div><! --/col-md-4-->
            </li>
            <li data-genre="zenner" data-main-actors="benazio" data-director="uvu">
                        <! -- Spotify Panel -->
                        <div class="col-lg-4 col-md-4 col-sm-4 mb">
                          <div class="content-panel pn">
                            <div id="spotify">
                              <div class="embed-responsive embed-responsive-16by9">
                                  <iframe class="embed-responsive-item" src="//www.youtube.com/embed/PfCdbncMiLo"></iframe>
                              </div>
                              
                              <div class="play">

                                <i class="fa fa-play-circle"></i>
                              </div>
                            </div>
                            <p class="followers">Matematika (Algoritma Dasar)</p>
                          </div>
                        </div><! --/col-md-4-->
            </li>
            <li data-genre="zenner" data-main-actors="benazio" data-director="adel">
                        <! -- Spotify Panel -->
                        <div class="col-lg-4 col-md-4 col-sm-4 mb">
                          <div class="content-panel pn">
                            <div id="spotify">
                              <div class="embed-responsive embed-responsive-16by9">
                                  <iframe class="embed-responsive-item" src="//www.youtube.com/embed/X_OCryK4JoI"></iframe>
                              </div>
                              
                              <div class="play">

                                <i class="fa fa-play-circle"></i>
                              </div>
                            </div>
                            <p class="followers">Matematika (Algoritma Dasar)</p>
                          </div>
                        </div><! --/col-md-4-->
            </li>
            <li data-genre="zenner" data-main-actors="benazio" data-director="adel">
                        <! -- Spotify Panel -->
                        <div class="col-lg-4 col-md-4 col-sm-4 mb">
                          <div class="content-panel pn">
                            <div id="spotify">
                              <div class="embed-responsive embed-responsive-16by9">
                                  <iframe class="embed-responsive-item" src="//www.youtube.com/embed/KXrEbW3wEpA"></iframe>
                              </div>
                              
                              <div class="play">

                                <i class="fa fa-play-circle"></i>
                              </div>
                            </div>
                            <p class="followers">Matematika (Algoritma Dasar)</p>
                          </div>
                        </div><! --/col-md-4-->
            </li>
            <li data-genre="zenner" data-main-actors="benazio" data-director="adel">
                        <! -- Spotify Panel -->
                        <div class="col-lg-4 col-md-4 col-sm-4 mb">
                          <div class="content-panel pn">
                            <div id="spotify">
                              <div class="embed-responsive embed-responsive-16by9">
                                  <iframe class="embed-responsive-item" src="//www.youtube.com/embed/zNzuGfXldU0"></iframe>
                              </div>
                              
                              <div class="play">

                                <i class="fa fa-play-circle"></i>
                              </div>
                            </div>
                            <p class="followers">Matematika (Algoritma Dasar)</p>
                          </div>
                        </div><! --/col-md-4-->
            </li>
            <li data-genre="zenner" data-main-actors="benazio" data-director="adel">
                        <! -- Spotify Panel -->
                        <div class="col-lg-4 col-md-4 col-sm-4 mb">
                          <div class="content-panel pn">
                            <div id="spotify">
                              <div class="embed-responsive embed-responsive-16by9">
                                  <iframe class="embed-responsive-item" src="//www.youtube.com/embed/m7zGqXPWCn8"></iframe>
                              </div>
                              
                              <div class="play">

                                <i class="fa fa-play-circle"></i>
                              </div>
                            </div>
                            <p class="followers">Matematika (Algoritma Dasar)</p>
                          </div>
                        </div><! --/col-md-4-->
            </li>
            <li data-genre="zenner" data-main-actors="benazio" data-director="adel">
            </ul>
  </div>

  <div class="col-md-3 col-md-pull-9">
      <div id="placeHolder"></div>
  </div>

</div>
