<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
// $this->params['breadcrumbs'][] = $this->title;
?>

<div class="container background-form">
	<div class="img-logo-center form-box">
		<center>
			<?php echo Html::img('/images/ppsdm-logo-atas.png', ['class' => 'img-responsive', 'alt' => 'logo']); ?>
		</center>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-4" id="login">
			<form id="login-form" class="login-form" action="/index.php/site/login" method="post" role="form">
				<div class="form-group">
					<div class="input-group">
						<div class="icon-input">
							<?php echo Html::img('/images/icon-user.png', ['class' => 'icon-input', 'alt' => 'icon']); ?>
						</div>
						<div class="form-input">
							<input type="text" class="form-control" id="username" name="LoginForm[username]" placeholder="Username" autofocus aria-required="true">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<div class="icon-input">
							<?php echo Html::img('/images/icon-password.png', ['class' => 'icon-input', 'alt' => 'icon']); ?>
						</div>
						<div class="form-input">
							<input type="password" class="form-control" id="password" name="LoginForm[password]" aria-required="true" placeholder="Password">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="checkbox">
						<label for="loginform-rememberme">
						<input type="hidden" name="LoginForm[rememberMe]" value="0"><input type="checkbox" id="loginform-rememberme" name="LoginForm[rememberMe]" value="1" checked>
						Remember Me
						</label>
						<p class="help-block help-block-error"></p>
					</div>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-success" name="login-button" style="border-radius:0px; width:100%;">Login</button>
				</div>
				<div class="form-group">
					<a href="/index.php/site/signup"><input type="button" class="btn btn-primary" value="Register" style="border-radius:0px; width: 100%;"></a>
    		</div>
   			<div class="form-group">
    					<div style="color: black; font-size: 15px; float: right; margin-right: 10px; margin-bottom: 20px;">
								<a href="/index.php/site/request-password-reset">Reset Password</a>
							</div>
				</div>
			</form>
		</div>
		<div class="col-md-6 col-md-offset-3">
			<div class="info">
				<center>
					<?php echo Html::img('/images/product.png', ['class' => 'img-responsive', 'alt' => 'logo']); ?>
				</center>
			</div>
		</div>
		<div class="col-md-6 col-md-offset-3">
			<div class="info">
				<center>
					<b><p>
						KONSULTAN PSIKOLOGI DAN PENGEMBANGAN SDM<br>
						Gedung ILP Pusat, Lt. III
					</p></b>
					<p>
						Jl. Raya Pasar Minggu No. 39 A Pancoran, Jakarta Selatan 12780, <br>
						Telp. (021) 7940525, (021) 79181128 fax: (021) 79101921 <br>
						psippsdm@yahoo.com
					</p>
				</center>
			</div>
		</div>
	</div>
</div>
