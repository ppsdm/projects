<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use common\modules\assessment\models\Assessment;
//use common\modules\profile\models\ProfileExtended;



$this->title = 'Try Out';
$this->params['breadcrumbs'][] = $this->title;


$registered_tryouts = Assessment::find()->andWhere(['status' => 'active'])->andWhere(['catalog_id' => '20'])->andWhere(['user_id' => Yii::$app->user->id])->All();
if(sizeof($registered_tryouts) > 0){
$terdaftar = "true";
} else {
	$terdaftar = "false";
}

?>

<div class="row">
							<div class="col-md-6 col-lg-3 col-sm-6">
								<div class="panel panel-default panel-white core-box">
									<div class="panel-tools">
										<a href="#" class="btn btn-xs btn-link panel-close">
											<i class="fa fa-times"></i>
										</a>
									</div>
									<div class="panel-body no-padding">
										<div class="partition-green padding-5 text-center core-icon">
										<?= Html::img('@web/images/sbmptn.png', ['alt' => 'My logo', 'width' => '75px', 'style' => 'padding-top: 15px;']) ?>
										</div>
										<div class="padding-20 core-content">
											<h3 class="title block no-margin">SBMPTN</h3>
											<span class="subtitle"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. </span>
										</div>
									</div>
									<div class="panel-footer clearfix no-padding">
										<div class=""></div>
										<a href="edulab/assesment/info" class="col-xs-4 padding-10 text-center text-white tooltips partition-green" data-toggle="tooltip" data-placement="top" title="" data-original-title="More Options"><i class="fa fa-cog"></i>Info</a>
										<a href="../assessment/result?id=20" class="col-xs-4 padding-10 text-center text-white tooltips partition-blue" data-toggle="tooltip" data-placement="top" title="" data-original-title="Add Content"><i class="fa fa-plus"></i>Hasil</a>
										<?php
											if ($terdaftar == "true")
											{
												$cls = "col-xs-4 padding-10 text-center text-white tooltips partition-orange";
												$txt = "Kerjakan";
                                                $lnk = "../assessment/start?id=20" ;
											}
											else
											{
												$cls = "col-xs-4 padding-10 text-center text-white tooltips partition-red";
												$txt = "Daftar";
                                                $lnk = "../assessment/register?id=20" ;
											}
											
										?>
										<a href="<?=$lnk?>" class="<?=$cls?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="View More"><i class="fa fa-chevron-right"></i><?=$txt?></a>
									</div>
								</div>
							</div>
							<div class="col-md-6 col-lg-3 col-sm-6">
								<div class="panel panel-default panel-white core-box">
									<div class="panel-tools">
										<a href="#" class="btn btn-xs btn-link panel-close">
											<i class="fa fa-times"></i>
										</a>
									</div>
									<div class="panel-body no-padding">
										<div class="partition-blue padding-5 text-center core-icon">
											<?= Html::img('@web/images/itb.png', ['alt' => 'My logo', 'width' => '75px', 'style' => 'padding-top: 15px;']) ?>
										</div>
										<div class="padding-20 core-content">
											<h3 class="title block no-margin">USM-ITB</h3>
											<span class="subtitle"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. </span>
										</div>
									</div>
									<div class="panel-footer clearfix no-padding">
										<a href="#" class="col-xs-4 padding-10 text-center text-white tooltips partition-green" data-toggle="tooltip" data-placement="top" title="" data-original-title="More Options"><i class="fa fa-cog"></i>Info</a>
										<a href="#" class="col-xs-4 padding-10 text-center text-white tooltips partition-blue" data-toggle="tooltip" data-placement="top" title="" data-original-title="Add Content"><i class="fa fa-plus"></i>Hasil</a>
										<a href="#" class="col-xs-4 padding-10 text-center text-white tooltips partition-red" data-toggle="tooltip" data-placement="top" title="" data-original-title="View More"><i class="fa fa-chevron-right"></i>Kerjakan</a>
									</div>
								</div>
							</div>
							<div class="col-md-6 col-lg-3 col-sm-6">
								<div class="panel panel-default panel-white core-box">
									<div class="panel-tools">
										<a href="#" class="btn btn-xs btn-link panel-close">
											<i class="fa fa-times"></i>
										</a>
									</div>
									<div class="panel-body no-padding">
										<div class="partition-red padding-5 text-center core-icon">
											<?= Html::img('@web/images/un.png', ['alt' => 'My logo', 'width' => '75px', 'style' => 'padding-top: 15px;']) ?>
										</div>
										<div class="padding-20 core-content">
											<h3 class="title block no-margin">UJIAN NASIONAL</h3>
											<span class="subtitle"> Lorem ipsum dolor sit amet, consectetuer. </span>
										</div>
									</div>
									<div class="panel-footer clearfix no-padding">
										<a href="#" class="col-xs-4 padding-10 text-center text-white tooltips partition-green" data-toggle="tooltip" data-placement="top" title="" data-original-title="More Options"><i class="fa fa-cog"></i>Info</a>
										<a href="#" class="col-xs-4 padding-10 text-center text-white tooltips partition-blue" data-toggle="tooltip" data-placement="top" title="" data-original-title="Add Content"><i class="fa fa-plus"></i>Hasil</a>
										<a href="#" class="col-xs-4 padding-10 text-center text-white tooltips partition-red" data-toggle="tooltip" data-placement="top" title="" data-original-title="View More"><i class="fa fa-chevron-right"></i>Kerjakan</a>
									</div>
								</div>
							</div>
							<div class="col-md-6 col-lg-3 col-sm-6">
								<div class="panel panel-default panel-white core-box">
									<div class="panel-tools">
										<a href="#" class="btn btn-xs btn-link panel-close">
											<i class="fa fa-times"></i>
										</a>
									</div>
									<div class="panel-body no-padding">
										<div class="partition-azure padding-5 text-center core-icon">
											<?= Html::img('@web/images/ugm.png', ['alt' => 'My logo', 'width' => '75px', 'style' => 'padding-top: 15px;']) ?>
										</div>
										<div class="padding-20 core-content">
											<h3 class="title block no-margin">USM-UGM</h3>
											<span class="subtitle"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. </span>
										</div>
									</div>
									<div class="panel-footer clearfix no-padding">
										<a href="#" class="col-xs-4 padding-10 text-center text-white tooltips partition-green" data-toggle="tooltip" data-placement="top" title="" data-original-title="More Options"><i class="fa fa-cog"></i>Info</a>
										<a href="#" class="col-xs-4 padding-10 text-center text-white tooltips partition-blue" data-toggle="tooltip" data-placement="top" title="" data-original-title="Add Content"><i class="fa fa-plus"></i>Hasil</a>
										<a href="#" class="col-xs-4 padding-10 text-center text-white tooltips partition-red" data-toggle="tooltip" data-placement="top" title="" data-original-title="View More"><i class="fa fa-chevron-right"></i>Kerjakan</a>
									</div>
								</div>
							</div>
						</div>
