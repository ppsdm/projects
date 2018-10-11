<?php
/* @var $this yii\web\View */
?>
<h1>PROJECT DASHBOARD</h1>

<p>

</p>
<div>
	<?php
		echo '<hr/><h2>ROLES : ';
    		foreach ($project_meta_model as $key => $value) {
  				if ($value->type == 'project-role') {
  					echo $value->value . ', ';
  				}
    		}
    		echo '</h2>';

	?>

	<?php

		//$searchresult = '';
		//echo '<hr/>PAGES : <br/>';
    		foreach ($project_meta_model as $key => $value) {
  				if ($value->type == 'project-role') {

					//$im1=Yii::getAlias('@vendor').'/gamantha/pao/project/views/project/_'.$value->value.'.php';
					$im1=Yii::getAlias('@app').'/modules/projects/views/project/'.$_GET['id'].'/_'.$value->value.'.php';

					if (file_exists($im1)) {
					  					echo $this->render($_GET['id'] . '/_'.$value->value, [
					        				//'model' => $model,
					        				//'searchresult' => $searchresult,
					    				]);
					} else {
					    echo '_ ' . $value->value. ' doesnt exists';
					}


  				}
    		}

	?>


</div>