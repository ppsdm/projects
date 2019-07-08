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
      echo "<h3>Kuesioner 3</h3>
      <p>
          Dengan mengisi kuesioner dibawah kamu akan mendapatkan <B>bonus 200 credit</B> ke akun kamu yang dapat digunakan untuk melakukan latihan tes      </p>";
      echo "<div class='form-group'>";
      echo '<B>1. Apakah latihan tes di siapngampus cukup membantu kamu belajar?</B>';
      echo Html::radioList('1', '', ['Cukup','Kurang'],['class'=>'checkbox']);
      echo "</div>";
      echo "<div class='form-group'>";
      echo '<B>2. Apa saja menurut kamu yang masih kurang dari latihan tes di siapngampus...</B>';
      echo Html::textarea('2', '',['class'=>'form-control']);
      echo "</div>";
      echo "<div class='form-group'>";
      echo '<B>3. Apabila satu poin dihargai Rp.1000 Rp. apakah menurut kamu harga tersebut sudah cocok?</B>';
      echo Html::radioList('3', '', ['Cukup','Kurang'],['class'=>'checkbox']);
      echo "</div>";
      echo Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']);

ActiveForm::end();
?>