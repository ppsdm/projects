<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

use yii\web\View;
use app\assets\AppAsset;

use app\modules\projects\models\Project;
use app\modules\projects\models\ProjectAssessment;
use app\modules\projects\models\ProjectAssessmentResult;
use app\modules\projects\models\ProjectMeta;
use app\modules\projects\models\ProjectActivity;
use app\modules\projects\models\AssessmentReport;
use app\modules\projects\models\ProjectActivityMeta;
use common\modules\profile\models\ProfileMeta;
use common\modules\profile\models\Profile;
use common\modules\catalog\models\RefAssessmentDictionary;

use kartik\grid\GridView;
use machour\yii2\notifications\widgets\NotificationsWidget;
use common\modules\core\models\Notification;
use common\modules\core\models\RefScale;


$id = $_GET['id'];
$project = ProjectAssessment::findOne($id);
$project_results = ProjectAssessmentResult::find()->andWhere(['project_assessment_id' => $id])->All();
echo 'debug';



$raws = [];
$scores = [];

//IST

foreach ($project_results as $key => $value) {
	$raws[$value->type][$value->key] = $value->value;
}

function storeresult_ist($scores)
{


}



function processor_ist($raws, $scores)
{
				$scores['ist']['total'] = 0;
	$ist_values = $raws['ist'];
	$usia = $ist_values['usia'];
	if ($usia > 50) {
		$kategori_usia = 'f';
	} else if ($usia >45 ) {
		$kategori_usia = 'e';
	} else if($usia >40 ) {
		$kategori_usia = 'd';
	} else if($usia >35 ) {
		$kategori_usia = 'c';
	} else if($usia >30 ) {
		$kategori_usia = 'b';
	} else {
		$kategori_usia = 'a';
	}
	$scores['kategori_usia'] = $kategori_usia;
	foreach ($ist_values as $ist_key => $ist_value) {
		if ($ist_key == 'sub1_tc') {
			$ist_scaled = RefScale::find()->andWhere(['type' => 'ist'])->andWhere(['name' => 'se_' . $scores['kategori_usia']])->andWhere(['raw' => $ist_value])->One();
			$scores['ist']['se_raw'] = $ist_value;
			$scores['ist']['se_scaled'] = $ist_scaled->scaled;
			$scores['ist']['total'] = $scores['ist']['total'] + $ist_value;
		} else if ($ist_key == 'sub2_tc') {
			$ist_scaled = RefScale::find()->andWhere(['type' => 'ist'])
			->andWhere(['name' => 'wa_' . $scores['kategori_usia']])
			->andWhere(['raw' => $ist_value])->One();
			$scores['ist']['wa_raw'] = $ist_value;
			$scores['ist']['wa_scaled'] = $ist_scaled->scaled;
			$scores['ist']['total'] = $scores['ist']['total'] + $ist_value;
		} else if ($ist_key == 'sub3_tc') {
			$ist_scaled = RefScale::find()->andWhere(['type' => 'ist'])
			->andWhere(['name' => 'an_' . $scores['kategori_usia']])
			->andWhere(['raw' => $ist_value])->One();
			$scores['ist']['an_raw'] = $ist_value;
			$scores['ist']['an_scaled'] = $ist_scaled->scaled;
			$scores['ist']['total'] = $scores['ist']['total'] + $ist_value;
		} else if ($ist_key == 'sub-test-4') {
			$ist_scaled = RefScale::find()->andWhere(['type' => 'ist'])
			->andWhere(['name' => 'ge_' . $scores['kategori_usia']])
			->andWhere(['raw' => $ist_value])->One();
			$scores['ist']['ge_raw'] = $ist_value;
			$scores['ist']['ge_scaled'] = $ist_scaled->scaled;
			$scores['ist']['total'] = $scores['ist']['total'] + $ist_value;
		} else if ($ist_key == 'sub5_tc') {
			$ist_scaled = RefScale::find()->andWhere(['type' => 'ist'])
			->andWhere(['name' => 'ra_' . $scores['kategori_usia']])
			->andWhere(['raw' => $ist_value])->One();
			$scores['ist']['ra_raw'] = $ist_value;
			$scores['ist']['ra_scaled'] = $ist_scaled->scaled;
			$scores['ist']['total'] = $scores['ist']['total'] + $ist_value;
		} else if ($ist_key == 'sub6_tc') {
			$ist_scaled = RefScale::find()->andWhere(['type' => 'ist'])
			->andWhere(['name' => 'zr_' . $scores['kategori_usia']])
			->andWhere(['raw' => $ist_value])->One();
			$scores['ist']['zr_raw'] = $ist_value;
			$scores['ist']['zr_scaled'] = $ist_scaled->scaled;
			$scores['ist']['total'] = $scores['ist']['total'] + $ist_value;
		} else if ($ist_key == 'sub7_tc') {
			$ist_scaled = RefScale::find()->andWhere(['type' => 'ist'])
			->andWhere(['name' => 'fa_' . $scores['kategori_usia']])
			->andWhere(['raw' => $ist_value])->One();
			$scores['ist']['fa_raw'] = $ist_value;
			$scores['ist']['fa_scaled'] = $ist_scaled->scaled;
			$scores['ist']['total'] = $scores['ist']['total'] + $ist_value;
		} else if ($ist_key == 'sub8_tc') {
			$ist_scaled = RefScale::find()->andWhere(['type' => 'ist'])
			->andWhere(['name' => 'wu_' . $scores['kategori_usia']])
			->andWhere(['raw' => $ist_value])->One();
			$scores['ist']['wu_raw'] = $ist_value;
			$scores['ist']['wu_scaled'] = $ist_scaled->scaled;
			$scores['ist']['total'] = $scores['ist']['total'] + $ist_value;
		} else if ($ist_key == 'sub9_tc') {
			$ist_scaled = RefScale::find()->andWhere(['type' => 'ist'])
			->andWhere(['name' => 'me_' . $scores['kategori_usia']])
			->andWhere(['raw' => $ist_value])->One();
			$scores['ist']['me_raw'] = $ist_value;
			$scores['ist']['me_scaled'] = $ist_scaled->scaled;
			$scores['ist']['total'] = $scores['ist']['total'] + $ist_value;
		}
	}

	$gesamtrs_scaled = RefScale::find()->andWhere(['type' => 'ist'])
			->andWhere(['name' => 'gesamtrs_' . $scores['kategori_usia']])
			->andWhere(['raw' => $scores['ist']['total']])
			->One();
	$iq_scaled = RefScale::find()->andWhere(['type' => 'ist'])
			->andWhere(['name' => 'gesamtrs2iq'])
			->andWhere(['raw' => $scores['ist']['total']])
			->One();
	$scores['ist']['gesamtrs'] = $gesamtrs_scaled->scaled;
	$scores['ist']['iq'] = $iq_scaled->scaled;
	return $scores;
}

function processor_kostik($raws, $scores)
{
	$ist_values = $raws['inventory'];
	

	foreach ($ist_values as $ist_key => $ist_value) {
		if ($ist_key == 'subtest5') {
			$scores['kostik'][$ist_key] = $ist_value;
		}

	}

	$scan = $scores['kostik']['subtest5'];
	
//g =[A1]+[A11]+[A21]+[A31]+[A41]+[A51]+[A61]+[A71]+[A81]
	$scores['kostik']['g'] = substr_count(strtolower($scan[0].$scan[10].$scan[20].$scan[30].$scan[40].$scan[50].$scan[60].$scan[70].$scan[80]), 'a');
	//[B80]+[B69]+[B58]+[B47]+[B36]+[B25]+[B14]+[B3]+[A2]
	$scores['kostik']['a'] = substr_count(strtolower($scan[79].$scan[68].$scan[57].$scan[46].$scan[35].$scan[24].$scan[13].$scan[2]), 'b') + 
							 substr_count(strtolower($scan[1]), 'a');
// l =[B81]+[A82]+[A72]+[A62]+[A52]+[A42]+[A32]+[A22]+[A12]
	$scores['kostik']['l'] = substr_count(strtolower($scan[81].$scan[71].$scan[61].$scan[51].$scan[41].$scan[31].$scan[21].$scan[11]), 'a') + 
							 substr_count(strtolower($scan[80]), 'b');
//p =[B70]+[B59]+[B48]+[B37]+[B26]+[B15]+[B4]+[A3]+[A13]
	$scores['kostik']['p'] = substr_count(strtolower($scan[69].$scan[58].$scan[47].$scan[36].$scan[25].$scan[14].$scan[3]), 'b') + 
							 substr_count(strtolower($scan[2].$scan[12]), 'a');
//i =[B71]+[B82]+[A83]+[A73]+[A63]+[A53]+[A43]+[A33]+[A23]
	$scores['kostik']['i'] = substr_count(strtolower($scan[82].$scan[72].$scan[62].$scan[52].$scan[42].$scan[32].$scan[22]), 'a') + 
							 substr_count(strtolower($scan[70] . $scan[81]), 'b');
//t =[B61]+[B72]+[B83]+[A84]+[A74]+[A64]+[A54]+[A44]+[A34]
	$scores['kostik']['t'] = substr_count(strtolower($scan[83].$scan[73].$scan[63].$scan[53].$scan[43].$scan[33]), 'a') + 
							 substr_count(strtolower($scan[60] . $scan[71] . $scan[82]), 'b');
//v =[B51]+[B62]+[B73]+[B84]+[A85]+[A75]+[A65]+[A55]+[A45]
	$scores['kostik']['v'] = substr_count(strtolower($scan[84].$scan[74].$scan[64].$scan[54].$scan[44]), 'a') + 
							 substr_count(strtolower($scan[50] . $scan[61] . $scan[72] . $scan[83]), 'b');
//x =[B60]+[B49]+[B38]+[B27]+[B16]+[B5]+[A4]+[A14]+[A24]
	$scores['kostik']['x'] = substr_count(strtolower($scan[3].$scan[13].$scan[23]), 'a') + 
							 substr_count(strtolower($scan[59] . $scan[48] . $scan[37] . $scan[26] . $scan[15] . $scan[4]), 'b');
//s =[B41]+[B52]+[B63]+[B74]+[B85]+[A86]+[A76]+[A66]+[A56]
	$scores['kostik']['s'] = substr_count(strtolower($scan[85].$scan[75].$scan[65].$scan[55]), 'a') + 
							 substr_count(strtolower($scan[40] . $scan[51] . $scan[62] . $scan[73].$scan[84]), 'b');
//b=[B50]+[B39]+[B28]+[B17]+[B6]+[A5]+[A15]+[A25]+[A35]
	$scores['kostik']['b'] = substr_count(strtolower($scan[4].$scan[14].$scan[24].$scan[34]), 'a') + 
							 substr_count(strtolower($scan[49] . $scan[38] . $scan[27] . $scan[16].$scan[5]), 'b');
//o=[B40]+[B29]+[B18]+[B7]+[A6]+[A16]+[A26]+[A36]+[A46]
	$scores['kostik']['o'] = substr_count(strtolower($scan[5].$scan[15].$scan[25].$scan[35].$scan[45]), 'a') + 
							 substr_count(strtolower($scan[39] . $scan[28] . $scan[17] . $scan[6]), 'b');
//r=[B31]+[B42]+[B53]+[B64]+[B75]+[B86]+[A87]+[A77]+[A67]
	$scores['kostik']['r'] = substr_count(strtolower($scan[86].$scan[76].$scan[66]), 'a') + 
							 substr_count(strtolower($scan[30] . $scan[41] . $scan[52] . $scan[63].$scan[74].$scan[85]), 'b');
//d=[B21]+[B32]+[B43]+[B54]+[B65]+[B76]+[B87]+[A88]+[A78]
	$scores['kostik']['d'] = substr_count(strtolower($scan[87].$scan[77]), 'a') + 
							 substr_count(strtolower($scan[20] . $scan[31] . $scan[42] . $scan[53].$scan[64].$scan[75].$scan[86]), 'b');
//c=[B11]+[B22]+[B33]+[B44]+[B55]+[B66]+[B77]+[B88]+[A89]
	$scores['kostik']['c'] = substr_count(strtolower($scan[88]), 'a') + 
							 substr_count(strtolower($scan[10] . $scan[21] . $scan[32] . $scan[43].$scan[54].$scan[65].$scan[76] . $scan[87]), 'b');
//z=([B30]+[B19]+[B8]+[A7]+[A17]+[A27]+[A37]+[A47]+[A57])
	$scores['kostik']['z'] = substr_count(strtolower($scan[6].$scan[16].$scan[26].$scan[36].$scan[46].$scan[56]), 'a') + 
							 substr_count(strtolower($scan[29] . $scan[18] . $scan[7]), 'b');
//e=[B1]+[B12]+[B23]+[B34]+[B45]+[B56]+[B67]+[B78]+[B89]
	$scores['kostik']['e'] = substr_count(strtolower($scan[0] . $scan[11] . $scan[22] . $scan[33].$scan[44].$scan[55].$scan[66].$scan[77].$scan[88]), 'b');
//k=([B20]+[B9]+[A8]+[A18]+[A28]+[A38]+[A48]+[A58]+[A68])
	$scores['kostik']['k'] = substr_count(strtolower($scan[19].$scan[8]), 'b') + 
							 substr_count(strtolower($scan[7] . $scan[17] . $scan[27] . $scan[37].$scan[47].$scan[57].$scan[67]), 'a');
//f=[B10]+[A9]+[A19]+[A29]+[A39]+[A49]+[A59]+[A69]+[A79]
	$scores['kostik']['f'] = substr_count(strtolower($scan[9]), 'b') + 
							 substr_count(strtolower($scan[8] . $scan[18] . $scan[28] . $scan[38].$scan[48].$scan[58].$scan[68].$scan[78]), 'a');
//w=[A10]+[A20]+[A30]+[A40]+[A50]+[A60]+[A70]+[A80]+[A90]
	$scores['kostik']['w'] = substr_count(strtolower($scan[9] . $scan[19] . $scan[29] . $scan[39].$scan[49].$scan[59].$scan[69].$scan[79].$scan[89]), 'a');
//n=[B90]+[B79]+[B68]+[B57]+[B46]+[B35]+[B24]+[B13]+[B2]
	$scores['kostik']['n'] = substr_count(strtolower($scan[89] . $scan[78] . $scan[67].$scan[56].$scan[45].$scan[34].$scan[23].$scan[12].$scan[1]), 'b');

	return $scores;
}

function processor_disc($raws, $scores)
{
	$scores['disc']['a'] = 0;
	$scores['disc']['b'] = 0;
	$scores['disc']['c'] = 0;
	$scores['disc']['d'] = 0;
	$scores['disc']['e'] = 0;
	$scores['disc']['f'] = 0;
	$scores['disc']['g'] = 0;
	$scores['disc']['h'] = 0;
	$scores['disc']['i'] = 0;
	$scores['disc']['j'] = 0;


	$map['r1c1'] = 'cdejabih';
	$map['r1c2'] = 'cdejabih';
	$map['r1c3'] = 'cdejabih';

	$map['r2c1'] = 'cdejabih';
	$map['r2c2'] = 'cdejabih';
	$map['r2c3'] = 'cdejabih';

	$map['r3c1'] = 'cdejabih';
	$map['r3c2'] = 'cdejabih';
	$map['r3c3'] = 'cdejabih';

	$map['r4c1'] = 'cdejabih';
	$map['r4c2'] = 'cdejabih';
	$map['r4c3'] = 'cdejabih';

	$map['r5c1'] = 'cdejabih';
	$map['r5c2'] = 'cdejabih';
	$map['r5c3'] = 'cdejabih';

	$map['r6c1'] = 'cdejabih';
	$map['r6c2'] = 'cdejabih';
	$map['r6c3'] = 'cdejabih';

	$map['r7c1'] = 'cdejabih';
	$map['r7c2'] = 'cdejabih';
	$map['r7c3'] = 'cdejabih';

	$map['r8c1'] = 'cdejabih';
	$map['r8c2'] = 'cdejabih';
	$map['r8c3'] = 'cdejabih';

	$ist_values = $raws['disc'];
	foreach ($ist_values as $ist_key => $ist_value) {
		if(strlen(trim($ist_value)) <= 4) {
			$str_val = strtolower(trim($ist_value));
			$scores['disc'][$ist_key] = $str_val;
			//$scores['disc'][$ist_key . '_mloc'] = strpos($str_val,"m");
			//$scores['disc'][$ist_key . '_lloc'] = strpos($str_val,"l");
		//	$scores['disc'][$ist_key . '_m'] = $map[$ist_key][(strpos($str_val,"m") * 2)];
		//	$scores['disc'][$ist_key . '_l'] = $map[$ist_key][(strpos($str_val,"l") * 2) + 1];
$scores['disc'][$map[$ist_key][(strpos($str_val,"m") * 2)]]++;
$scores['disc'][$map[$ist_key][(strpos($str_val,"l") * 2) + 1]]++;

		} else {
			$scores['disc'][$ist_key] = 'INVALID';
		}
	}

	$scores['disc']['d1'] = $scores['disc']['a'];
	$scores['disc']['d2'] = $scores['disc']['b'];
	$scores['disc']['d3'] = $scores['disc']['a'] - $scores['disc']['b'];

	$scores['disc']['i1'] = $scores['disc']['c'];
	$scores['disc']['i2'] = $scores['disc']['d'];
	$scores['disc']['i3'] = $scores['disc']['c'] - $scores['disc']['d'];

	$scores['disc']['s1'] = $scores['disc']['e'];
	$scores['disc']['s2'] = $scores['disc']['f'];
	$scores['disc']['s3'] = $scores['disc']['e'] - $scores['disc']['f'];

	$scores['disc']['c1'] = $scores['disc']['g'];
	$scores['disc']['c2'] = $scores['disc']['h'];
	$scores['disc']['c3'] = $scores['disc']['g'] - $scores['disc']['h'];

	$scores['disc']['x1'] = $scores['disc']['i'];
	$scores['disc']['x2'] = $scores['disc']['j'];
	return $scores;
}






$scores = processor_ist($raws, $scores);
//$scores = processor_kostik($raws, $scores);
//$scores = processor_disc($raws, $scores);

echo '<pre>';
//print_r($raws);
echo '<br/>SCORES<hr/>';
print_r($scores);
?>