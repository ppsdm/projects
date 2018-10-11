<?php
use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = 'PPSDM Consultant';
@session_regenerate_id(true);
?>
<div class="site-index">



    <div class="body-content">


    
  


      
        <?php

if (Yii::$app->user->isGuest) {
    echo "
    <center><h2><span style= 'color: #F86D18''>PPSDM Consultant</span>, <i>hadir sebagai solusi</i></h2>
    Profesional di bidang Pengembangan Sumber Daya Manusia.<br>
    Mengedepankan prinsip – prinsip; <b><em>integrity</em>, <em>responsibility</em> dan <em>continuous improvement</em>.<br></b>
    <br/>
    
    <div style='text-align:center;background-color:#F9F9F9;'><img align='center' src ='/images/front.png'></div>";
} 
                      else {
			echo '<div class="col-sm-3" style="margin-top: 3rem;"><a href="http://projects.ppsdm.com/index.php/projects/project/dashboard?id=5"><img class="img-thumbnail" src="http://setkab.go.id/wp-content/uploads/2016/02/garuda.jpg"><h3>Sekretariat Kabinet</h3></a></div>';
                        //echo "<br/>".Html::a(Yii::t('app', 'Select Project'), ['projects/project/select'], ['class' => 'btn btn-lg btn-success btn-small']);
                       // echo "<div style='align:center;background-color:#F9F9F9;'><img align='center' src ='/images/front.png'></div>";
                        
                      }
                      ?>
        
                    </div>

  
</div>
