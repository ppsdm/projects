<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\profile\models\ProfileGeneral */
/* @var $form yii\widgets\ActiveForm */

$form = ActiveForm::begin();
    			//echo     $form->field($model, 'username')->textInput();
        //$form->field($model, 'user_id')->textInput();
    echo Html::textInput('bonus','200',['hidden'=>true]);
    echo "<h3>Kuesioner 2</h3>
    <p>
        Dengan mengisi kuesioner dibawah kamu akan mendapatkan <B>bonus 200 credit</B> ke akun kamu yang dapat digunakan untuk melakukan latihan tes      </p>";
    echo "<div class='form-group'>";
    echo '<B>1. apakah navigasi siapngampus cuukup jelas atau membingungkan?</B>';
    echo Html::radioList('1', '', ['Cukup','Kurang'],['class'=>'checkbox']);
    echo "</div>";
    echo "<div class='form-group'>";
    echo '<B>2. tuliskan usulan-usulan kamu tentang apa yang masih kurang di siapngampus</B>';
    echo Html::textarea('2', '',['class'=>'form-control']);
    echo "</div>";
    echo Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']);

ActiveForm::end();
?>