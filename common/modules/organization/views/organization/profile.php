<?php

use common\modules\organization\models\Organization;

//use Yii\helpers\Html;
use yii\helpers\Html;

?>

<div class="admin-default-index">
    <h1>Choose your organization</h1>
<?php

foreach ($orgs as $key => $value) {
	# code...
	//echo $value->organization->name;
echo 	Html::a($value->organization->name, ['main', 'org_id'=>$value->organization_id], ['class'=>'btn-menu-transparent btn-info']);
	echo '<br/>';
}

?>

</div>

