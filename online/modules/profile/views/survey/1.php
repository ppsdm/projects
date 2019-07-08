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
    echo "
    <h3>Kuesioner 1</h3>
      <p>
        Terima kasih telah mendaftar di siapngampus.com. <BR>dengan mengisi kuesioner  kamu akan mendapatkan <B>bonus 200 credit</B> ke akun kamu yang dapat digunakan untuk melakukan latihan tes
      </p>
    ";
    echo "<div class='form-group'>";
    echo '<B>1. Sudah berapa lama anda ikut Edulab?</B>';
    echo Html::textInput('1','',['class'=>'form-control']);
    echo "</div>";
    echo "<div class='form-group'>";
    echo '<B>2. di kota manakah kamu tergabung ke edulab?</B>';
    echo Html::dropDownList('2', '', ['Bandung','Bekasi', 'Purwakarta', 'Medan', 'Surabaya', 'Cirebon', 'Karawang','Semarang','Balikpapan', 'Makassar', 'Pekanbaru', 'Padang'],['class'=>'form-control']);
    echo "</div>";
    echo "<div class='form-group'>";
    echo '<B>3. apakah edulab sudah cukup membantu belajar kamu?</B>';
    echo Html::radioList('3', '', ['Cukup','Kurang'],['class'=>'checkbox']);
    echo "</div>";
    echo "<div class='form-group'>";
    echo '<B>4. paket edulab kamu sekarang</B>';
    echo Html::radioList('4', '', ['Suite Medulab Class','Suite Platinum Class','Deluxe Class','Velvet Class'],['class'=>'checkbox']);
    echo "</div>";
    echo "<div class='form-group'>";
    echo '<B>5. siapngampus adalah platform untuk melakukan testing/latihan tes secara online. pilih 3 fitur yang paling penting menurut kamu harus ada di siapngampus :</B>';
    echo Html::checkboxList('5', '', ['Review latihan soal','Sharing social media','Ranking nilai dari seluruh peserta siapngampus','Ranking nilai dari group belajarmu sendiri','Review pengajar edulab','Forum diskusi','Akses dari smartphone'],['class'=>'checkbox', 'separator' => '<br/>']);
    echo "</div>";
    echo Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']);

ActiveForm::end();
?>