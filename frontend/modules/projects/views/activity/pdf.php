<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

use yii\web\View;
use app\assets\AppAsset;
use yii\helpers\ArrayHelper;

$monthE = array("","January","February","March","April","May","June","July","August","September","October","November","December");
$bulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");


$tanggal_test = $objectPrint['tanggal_test'];
//echo $tanggal_test.'nirwan';

$day = substr($tanggal_test, 0,2);
$month = substr($tanggal_test, 2,2);
$year = substr($tanggal_test, 4,4);
$date_test = $day.'-'.$month.'-'.$year;
$newDate = str_replace($monthE, $bulan, date("j F Y", strtotime($date_test)+'21 days'));



$daySignature = substr($tanggal_test, 0,1).substr($tanggal_test, 1,1)+2;
$date_testSignature = $daySignature.'-'.$month.'-'.$year;
$newDateSignature = str_replace($monthE, $bulan,date("j F Y", strtotime($date_testSignature)));
$footerReport='
<div class="footerReport">

<hr>
<table width=100%><tr><td style="padding-right:10px;">
<i>Assessment Psikologik dan Kompetensi Bagi Jabatan Tinggi Pratama,</i> <br/>
<i>Jabatan Administrator, dan Jabatan Pengawas </i><br/>
<i>Kementerian Kesehatan RI 2017 </i></div>
</td>
<td  style="text-align:left;border-left: solid  1px #000000;padding-left:10px;" valign="top">
<div id="pageFooter"></div>
</td>
</tr>
</table>

';
$pagebreak = $footerReport.'</b></p></article>
</section>
<section class="sheet padding-25mm">
<div class="headerReport">
<h2>RAHASIA</h2>
<hr></div>
<img style="position:absolute; right: 100px; top: 50px;" src="'.Url::base().'/images/ppsdm-logo-atas.png">
<article><br/>';

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title><?=$objectPrint['firstname']; ?></title>

  <!-- Normalize or reset CSS with your favorite library -->
  <link rel="stylesheet" type="text/css" href="<?=Url::to('@web/css/normalize.css');?>">

  <!-- Load paper.css for happy printing  -->
  <link rel="stylesheet" type="text/css"href="<?=Url::to('@web/css/paper.css');?>">

  <link rel="stylesheet" type="text/css" href="<?=Url::to('@web/css/psikogramTable.css');?>">

  <!-- Set page size here: A5, A4 or A3 -->
  <!-- Set also "landscape" if you need -->

  <script src="<?=Url::to('@web/js/d3.min.js');?>" charset="utf-8"></script>



</head>

<body class="A4">

  <!-- Each sheet element should have the class "sheet" -->
  <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
  <section class="sheet padding-0mm">
  <div style= "width: 210mm; height: 296mm; margin:0; background-image: url('<?=Url::base();?>/images/1/coverlaporan.png');
 background-position: center; background-repeat: no-repeat;background-size: 210mm 296mm" >
<article>


 </div>
 <div style="font-size: 18pt;position:absolute; left: 250px; top: 500px;"><b><?=$objectPrint['firstname']; ?></b></div>
 <div style="font-size: 18pt;position:absolute; left: 250px; top: 550px;"><b><?=$objectPrint['profile_meta']['work']['nip'];?></b></div>

 <div style="font-size: 18pt;position:absolute; left: 280px; top: 690px;"><b> <?=substr($tanggal_test, 0,2);?> - <?=$newDateSignature;?></b></div>


</article>
</section>
<section class="sheet padding-25mm">
<div class="headerReport">
<h2>RAHASIA</h2>
<hr></div>
<img style="position:absolute; right: 100px; top: 50px;" src="<?=Url::base();?>/images/ppsdm-logo-atas.png">
<article>


<div class='center'>
<h3>
LAPORAN<br/>
ASSESSMENT PSIKOLOGIK DAN KOMPETENSI<br/>
BAGI JABATAN PIMPINAN TINGGI PRATAMA,<br/>
JABATAN ADMINISTRATOR DAN JABATAN PENGAWAS<br/>
KEMENTERIAN KESEHATAN REPUBLIK INDONESIA 2017</h3>
</div>

<br/>

<div style="font-size: 18pt;position:absolute; right: 95px; top: 305px;">
<?=Html::img('@web/project-uploads/1/photos/'.$objectPrint['profile_id'].'.jpg', ['alt' => '--missing image--','style'=> 'max-width:150px;max-height:150px' ]);?>
</div>
<?php


$nomor_test = $objectPrint['nomor_test'];

$day1 = substr($tanggal_test, 0,2);
$month1 = substr($tanggal_test, 3,2);
$year1 = substr($tanggal_test, 6,2);
$year2 = substr($tanggal_test, 4,4);
$tanggaltest=  $day1.$month1.$year1;
?>

<table class='cover'>
<tbody>
<tr>
<td>Nomor Test</td><td>:</td><td><?=$nomor_test;?>/EVAL/ESELON4/KEMENKES/<?=$tanggaltest;?>/IX/<?=$year2;?> </td></tr>
<tr>
<td>Nama Lengkap</td><td>:</td><td><b><?=$objectPrint['firstname']; ?></b></td></tr>
<tr>
<td>Tempat / Tgl. Lahir</td><td>:</td><td><?=$objectPrint['profile_meta']['personal']['birthplace']; ?> , <?= date_format(date_create($objectPrint['birthdate']),"d/m/Y"); ?></td></tr>
<tr>
<td>Jabatan Saat ini</td><td>:</td><td><?=$objectPrint['profile_meta']['work']['current_position']; ?></td></tr>
<tr>
<td>Prospek Jabatan</td><td>:</td><td><?=$objectPrint['profile_meta']['work']['prospect_position']; ?></td></tr>
<tr>
<td>Pendidikan Terakhir</td><td>:</td><td><?=$objectPrint['profile_meta']['education']['latest']; ?></td></tr>
<tr>
<td>Tujuan Pemeriksaan</td><td>:</td><td>PEMETAAN POTENSI & KOMPETENSI</td></tr>
<tr>
<td>Tempat / Tgl Test</td><td>:</td><td>Jakarta, <?=substr($tanggal_test, 0,2);?> - <?=$newDateSignature;?></td>
</tr>
</tbody>
</table>
<?php
$date = date_create($newDate);
date_add($date, date_interval_create_from_date_string('21 days'));

?>

<div class='center'>
<br/>
<br/>
    Jakarta, <?=str_replace($monthE,$bulan,date_format($date, "j F Y"));?><br/>
    <b>PPSDM Consultant</b>
</div>
<br/>
<table>
<tr>
<td>
<div class='kananTandaTangan'>
<div class='center'>
	Assesor<br/>
	<b><?=$objectPrint['assessor_name'];?><b>
</div>
</div>
</td>
<td width='200px'>
</td>
<td>
<div class='kiriTandaTangan'>
<div class='center'>
	Penanggung jawab<br/>
	<strong>Drs. Budiman Sanusi, MPsi.
	<br/>
	SIP : 0723-12-2-1</strong>
</div>
</div>
</td>
</tr>
</table>
<?=$footerReport;?>
</article>
</section>




<section class="sheet padding-25mm">
<div class="headerReport">
<h2>RAHASIA</h2>
<hr></div>
<img style="position:absolute; right: 100px; top: 48px;" src="<?=Url::base();?>/images/ppsdm-logo-atas.png">
<article>

<div class='center'>
<h3>EXECUTIVE SUMMARY</h3>
</div>
<?php
$htmltag = array('<p style="text-align: justify;">','<p></p>');
$htmlesc   = array('<p>','');
?>
<div style="margin-bottom:60px;text-align:justify;text-justify:inter-word;font-size: 12;";>
<?=wordwrap(str_replace($htmltag, $htmlesc, $objectPrint['executive_summary']), 3150,  $pagebreak, false);?>
</div>


<?=$footerReport;?>
</article>
</section>




<section class="sheet padding-25mm">
<div class="headerReport">
<h2>RAHASIA</h2>
<hr></div>
<img style="position:absolute; right: 100px; top: 52px;" src="<?=Url::base();?>/images/ppsdm-logo-atas.png">
<article>

<div class='center'>
<h3>DIAGRAM KOMPETENSI</H3>

 <div class="radarChart" style=" background-image: url('<?=Url::base();?>/images/1/<?=$objectPrint['catalog_id'];?>.png');
 background-position: center; background-repeat: no-repeat;background-size: 400px 420px;"></div>
 <script src="<?=Url::to('@web/js/radarChart.js');?>"></script>


		<script>

      /* Radar chart design created by Nadieh Bremer - VisualCinnamon.com */

			//////////////////////////////////////////////////////////////
			//////////////////////// Set-Up //////////////////////////////
			//////////////////////////////////////////////////////////////

			var margin = {top: 10, right: 50, bottom: 35, left: 50},
				width = Math.min(500, window.innerWidth - 10) - margin.left - margin.right,
				height = Math.min(width, window.innerHeight - margin.top - margin.bottom - 20);

			//////////////////////////////////////////////////////////////
			////////////////////////// Data //////////////////////////////
			//////////////////////////////////////////////////////////////
			var data = [
				[
			<?php foreach ($objectPrint as $key => $value) {
					  		if ($key == 'kompetensiSQLDataProvider') {
					  			foreach ($value as $key2 => $value2) {
					  				echo "{axis:'',value:'".trim($value2['standar'])."'},";
					  			}
					  		}
					  	}
			?>
				],[
					<?php
					foreach ($objectPrint as $key => $value) {
					  		if ($key == 'kompetensiSQLDataProvider') {
					  			foreach ($value as $key2 => $value2) {
					  				echo 	"{axis:'',value:'".trim($value2['value'])."'},";

					  			}
					  		}
					  	}?>
				]
			  ];

			//////////////////////////////////////////////////////////////
			//////////////////// Draw the Chart //////////////////////////
			//////////////////////////////////////////////////////////////

			var color = d3.scale.ordinal()
			.range(['#AEDFFB','#35274E']);

			var radarChartOptions = {
			w: width,
			h: height,
			margin: margin,
			maxValue: 6,
			levels: 5,
			roundStrokes: false,
			color: color,
			opacityArea: 0.5,
			opacityCircles: 0,
			dotRadius: 3,
			strokeWidth: 2,
			wrapWidth: 10,
			labelFactor: 10,
			};
			//Call function to draw the Radar chart
			RadarChart(".radarChart", data, radarChartOptions);
		</script>
</div>


<div class='center'>
<?php if(array_key_exists('0',$objectPrint['kompetensiSQLDataProvider'])){   ?>

<table border="0" cellpadding="0" cellspacing="0" style="border-collapse:
 collapse;width:100%">
	<colgroup>
		<col span="1">
		<col span="18" style="width:20pt" width="26">
	</colgroup>
	<tr>
		<td class="kompetensi1" colspan="12" height="20" style="height: 15.0pt; width: 240pt" width="312">
		Kompetensi</td>
		<td class="kompetensi1" colspan="2" style="width: 40pt" width="52">LKJ</td>
		<td class="kompetensi2" colspan="2" style="width: 40pt" width="52">LKI</td>
		<td class="kompetensi2" colspan="2" style="width: 40pt" width="52">GAP</td>
		<td class="kompetensi2" colspan="2" style="width: 40pt" width="52">PCT</td>
	</tr>
	<tr>
		<td class="kompetensi3" colspan="2"  rowspan="4" style="height: 70.0pt;">
		<div style= "transform: rotate(-90deg);">KOMPETENSI<br/>GENERIK</div></td>
		<td class="kompetensi4" colspan="8"><?=$objectPrint['kompetensigramDict'][$objectPrint['kompetensiSQLDataProvider'][0]['key']]['attribute_1'];?></td>
		<td class="kompetensi5" colspan="2"><?=strtoupper($objectPrint['kompetensiSQLDataProvider'][0]['key']);?></td>
		<td class="kompetensi6" colspan="2"><?=$objectPrint['kompetensiSQLDataProvider'][0]['standar'];?></td>
		<td class="kompetensi5" colspan="2"><?=$objectPrint['kompetensiSQLDataProvider'][0]['value'];?></td>
		<td class="kompetensi7" colspan="2" >
		<?=$objectPrint['kompetensiSQLDataProvider'][0]['standar']-$objectPrint['kompetensiSQLDataProvider'][0]['value'];?></td>
		<td class="kompetensi7" colspan="2" >
		<?=round($objectPrint['kompetensiSQLDataProvider'][0]['value']/$objectPrint['kompetensiSQLDataProvider'][0]['standar']*100);?>%</td>
	</tr>
	<tr>
	<td class="kompetensi4" colspan="8"><?=$objectPrint['kompetensigramDict'][$objectPrint['kompetensiSQLDataProvider'][1]['key']]['attribute_1'];?></td>
	<td class="kompetensi5" colspan="2"><?=strtoupper($objectPrint['kompetensiSQLDataProvider'][1]['key']);?></td>
	<td class="kompetensi6" colspan="2"><?=$objectPrint['kompetensiSQLDataProvider'][1]['standar'];?></td>
	<td class="kompetensi5" colspan="2"><?=$objectPrint['kompetensiSQLDataProvider'][1]['value'];?></td>
	<td class="kompetensi7" colspan="2" >
	<?=$objectPrint['kompetensiSQLDataProvider'][1]['standar']-$objectPrint['kompetensiSQLDataProvider'][1]['value'];?></td>
	<td class="kompetensi7" colspan="2" >
	<?=round($objectPrint['kompetensiSQLDataProvider'][1]['value']/$objectPrint['kompetensiSQLDataProvider'][1]['standar']*100);?>%</td>
	</tr>
	<tr>
	<td class="kompetensi4" colspan="8"><?=$objectPrint['kompetensigramDict'][$objectPrint['kompetensiSQLDataProvider'][2]['key']]['attribute_1'];?></td>
	<td class="kompetensi5" colspan="2"><?=strtoupper($objectPrint['kompetensiSQLDataProvider'][2]['key']);?></td>
	<td class="kompetensi6" colspan="2"><?=$objectPrint['kompetensiSQLDataProvider'][2]['standar'];?></td>
	<td class="kompetensi5" colspan="2"><?=$objectPrint['kompetensiSQLDataProvider'][2]['value'];?></td>
	<td class="kompetensi7" colspan="2" >
	<?=$objectPrint['kompetensiSQLDataProvider'][2]['standar']-$objectPrint['kompetensiSQLDataProvider'][2]['value'];?></td>
	<td class="kompetensi7" colspan="2" >
	<?=round($objectPrint['kompetensiSQLDataProvider'][2]['value']/$objectPrint['kompetensiSQLDataProvider'][2]['standar']*100);?>%</td>
	</tr>
	<tr>
	<td class="kompetensi4" colspan="8"><?=$objectPrint['kompetensigramDict'][$objectPrint['kompetensiSQLDataProvider'][3]['key']]['attribute_1'];?></td>
	<td class="kompetensi5" colspan="2"><?=strtoupper($objectPrint['kompetensiSQLDataProvider'][3]['key']);?></td>
	<td class="kompetensi6" colspan="2"><?=$objectPrint['kompetensiSQLDataProvider'][3]['standar'];?></td>
	<td class="kompetensi5" colspan="2"><?=$objectPrint['kompetensiSQLDataProvider'][3]['value'];?></td>
	<td class="kompetensi7" colspan="2" >
	<?=$objectPrint['kompetensiSQLDataProvider'][3]['standar']-$objectPrint['kompetensiSQLDataProvider'][3]['value'];?></td>
	<td class="kompetensi7" colspan="2" >
	<?=round($objectPrint['kompetensiSQLDataProvider'][3]['value']/$objectPrint['kompetensiSQLDataProvider'][3]['standar']*100);?>%</td>
	</tr>
	<!--
	<tr>
		<td class="kompetensi18" colspan="8" height="20" style="height: 15.0pt">
		&nbsp;</td>
		<td class="kompetensi19" colspan="2">&nbsp;</td>
		<td class="kompetensi20" colspan="2">15</td>
		<td class="kompetensi21" colspan="2">0</td>
		<td class="kompetensi21" colspan="2" >
		-15</td>
		<td class="kompetensi21" colspan="2" >
		0%</td>
	</tr>
	-->
	<tr>
	<td class="kompetensi23" colspan="2" height="140" rowspan="7" style="height: 105.0pt; ">
	<div style= "transform: rotate(-90deg);">KOMPETENSI <br>SPESIFIK</div></td>
	<td class="kompetensi24" colspan="8"><?=$objectPrint['kompetensigramDict'][$objectPrint['kompetensiSQLDataProvider'][4]['key']]['attribute_1'];?></td>
	<td class="kompetensi25" colspan="2"><?=strtoupper($objectPrint['kompetensiSQLDataProvider'][4]['key']);?></td>
	<td class="kompetensi26" colspan="2"><?=$objectPrint['kompetensiSQLDataProvider'][4]['standar'];?></td>
	<td class="kompetensi25" colspan="2"><?=$objectPrint['kompetensiSQLDataProvider'][4]['value'];?></td>
	<td class="kompetensi27" colspan="2" ><?=$objectPrint['kompetensiSQLDataProvider'][4]['standar']-$objectPrint['kompetensiSQLDataProvider'][4]['value'];?></td>
	<td class="kompetensi27" colspan="2" ><?=round($objectPrint['kompetensiSQLDataProvider'][4]['value']/$objectPrint['kompetensiSQLDataProvider'][4]['standar']*100);?>%</td>
	</tr>
	<tr>
	<td class="kompetensi24" colspan="8"><?=$objectPrint['kompetensigramDict'][$objectPrint['kompetensiSQLDataProvider'][5]['key']]['attribute_1'];?></td>
	<td class="kompetensi25" colspan="2"><?=strtoupper($objectPrint['kompetensiSQLDataProvider'][5]['key']);?></td>
	<td class="kompetensi26" colspan="2"><?=$objectPrint['kompetensiSQLDataProvider'][5]['standar'];?></td>
	<td class="kompetensi25" colspan="2"><?=$objectPrint['kompetensiSQLDataProvider'][5]['value'];?></td>
	<td class="kompetensi27" colspan="2" ><?=$objectPrint['kompetensiSQLDataProvider'][5]['standar']-$objectPrint['kompetensiSQLDataProvider'][5]['value'];?></td>
	<td class="kompetensi27" colspan="2" ><?=round($objectPrint['kompetensiSQLDataProvider'][5]['value']/$objectPrint['kompetensiSQLDataProvider'][5]['standar']*100);?>%</td>
	</tr>
	<tr>
	<td class="kompetensi24" colspan="8"><?=$objectPrint['kompetensigramDict'][$objectPrint['kompetensiSQLDataProvider'][6]['key']]['attribute_1'];?></td>
	<td class="kompetensi25" colspan="2"><?=strtoupper($objectPrint['kompetensiSQLDataProvider'][6]['key']);?></td>
	<td class="kompetensi26" colspan="2"><?=$objectPrint['kompetensiSQLDataProvider'][6]['standar'];?></td>
	<td class="kompetensi25" colspan="2"><?=$objectPrint['kompetensiSQLDataProvider'][6]['value'];?></td>
	<td class="kompetensi27" colspan="2" ><?=$objectPrint['kompetensiSQLDataProvider'][6]['standar']-$objectPrint['kompetensiSQLDataProvider'][6]['value'];?></td>
	<td class="kompetensi27" colspan="2" ><?=round($objectPrint['kompetensiSQLDataProvider'][6]['value']/$objectPrint['kompetensiSQLDataProvider'][6]['standar']*100);?>%</td>
	</tr>
	<tr>
	<td class="kompetensi24" colspan="8"><?=$objectPrint['kompetensigramDict'][$objectPrint['kompetensiSQLDataProvider'][7]['key']]['attribute_1'];?></td>
	<td class="kompetensi25" colspan="2"><?=strtoupper($objectPrint['kompetensiSQLDataProvider'][7]['key']);?></td>
	<td class="kompetensi26" colspan="2"><?=$objectPrint['kompetensiSQLDataProvider'][7]['standar'];?></td>
	<td class="kompetensi25" colspan="2"><?=$objectPrint['kompetensiSQLDataProvider'][7]['value'];?></td>
	<td class="kompetensi27" colspan="2" ><?=$objectPrint['kompetensiSQLDataProvider'][7]['standar']-$objectPrint['kompetensiSQLDataProvider'][7]['value'];?></td>
	<td class="kompetensi27" colspan="2" ><?=round($objectPrint['kompetensiSQLDataProvider'][7]['value']/$objectPrint['kompetensiSQLDataProvider'][7]['standar']*100);?>%</td>
	</tr>
	<tr>
	<td class="kompetensi24" colspan="8"><?=$objectPrint['kompetensigramDict'][$objectPrint['kompetensiSQLDataProvider'][8]['key']]['attribute_1'];?></td>
	<td class="kompetensi25" colspan="2"><?=strtoupper($objectPrint['kompetensiSQLDataProvider'][8]['key']);?></td>
	<td class="kompetensi26" colspan="2"><?=$objectPrint['kompetensiSQLDataProvider'][8]['standar'];?></td>
	<td class="kompetensi25" colspan="2"><?=$objectPrint['kompetensiSQLDataProvider'][8]['value'];?></td>
	<td class="kompetensi27" colspan="2" ><?=$objectPrint['kompetensiSQLDataProvider'][8]['standar']-$objectPrint['kompetensiSQLDataProvider'][8]['value'];?></td>
	<td class="kompetensi27" colspan="2" ><?=round($objectPrint['kompetensiSQLDataProvider'][8]['value']/$objectPrint['kompetensiSQLDataProvider'][8]['standar']*100);?>%</td>
	</tr>
	<tr>
	<td class="kompetensi24" colspan="8"><?=$objectPrint['kompetensigramDict'][$objectPrint['kompetensiSQLDataProvider'][9]['key']]['attribute_1'];?></td>
	<td class="kompetensi25" colspan="2"><?=strtoupper($objectPrint['kompetensiSQLDataProvider'][9]['key']);?></td>
	<td class="kompetensi26" colspan="2"><?=$objectPrint['kompetensiSQLDataProvider'][9]['standar'];?></td>
	<td class="kompetensi25" colspan="2"><?=$objectPrint['kompetensiSQLDataProvider'][9]['value'];?></td>
	<td class="kompetensi27" colspan="2" ><?=$objectPrint['kompetensiSQLDataProvider'][9]['standar']-$objectPrint['kompetensiSQLDataProvider'][9]['value'];?></td>
	<td class="kompetensi27" colspan="2" ><?=round($objectPrint['kompetensiSQLDataProvider'][9]['value']/$objectPrint['kompetensiSQLDataProvider'][9]['standar']*100);?>%</td>
	</tr>
	<tr>
		<td class="kompetensi46" colspan="8">&nbsp;</td>
		<td class="kompetensi45" colspan="2">TOTAL</td>
		<td class="kompetensi46" colspan="2"><?=$objectPrint['sumC'];?></td>
		<td class="kompetensi47" colspan="2"><?=$objectPrint['PArk'];?></td>
		<td class="kompetensi47" colspan="2" ><?=$objectPrint['sumC']-$objectPrint['PArk'];?></td>
		<td class="kompetensi47" colspan="2" ><?=round($objectPrint['PArk']/$objectPrint['sumC']*100);?>%</td>
	</tr>
</table>
<?php
} else {echo 'nodata';} ?>
<br/>


<table class="rekomendasi" align="center">

<tr bgcolor="#B8CCE4">
<th colspan="2" rowspan="1" scope="col">Kualifikasi</th>
<th colspan="1" rowspan="1" scope="col">Rekomendasi</th>
<th colspan="3" rowspan="1" scope="col">Skala</th>
</tr>
<?php
$PArk =$objectPrint['PArk'];
$PArp =$objectPrint['PArp'];
$sumC = $objectPrint['sumC'];
if (round($PArk/$sumC*100) >=100) {
    $bgclolor1 = '#C4D79B';$bgclolor2 = '#ffffff';$bgclolor3 = '#ffffff';
}

else if ((round($PArk/$sumC*100) >= 75) && (round($PArk/$sumC*100) <= 99)) {
    $bgclolor1 = '#ffffff';$bgclolor2 = '#C4D79B';$bgclolor3 = '#ffffff';

}

else {
	$bgclolor1 = '#ffffff';$bgclolor2 = '#ffffff';$bgclolor3 = '#C4D79B';
}
?>
<tbody>
<tr bgcolor="<?=$bgclolor1;?>">
<td>K-1</td>
<td>Baik</td>
<td>Ready Now</td>
<td>100%</td><td>-</td><td>ke atas</td>
</tr>
<tr bgcolor="<?=$bgclolor2;?>">
<td>K-2</td>
<td>Cukup</td>
<td>Ready with development</td>
<td>75%</td><td>-</td><td>99%</td>
</tr>
<tr bgcolor="<?=$bgclolor3;?>">
<td>K-3</td>
<td>Kurang</td>
<td>Not Ready</td>
<td>74%</td><td>-</td><td>ke bawah</td>
</tr>
</tbody>
</table>
</div>
<?=$footerReport;?>
</article>
</section>










<section class="sheet padding-25mm">
<div class="headerReport">
<h2>RAHASIA</h2>
<hr></div>
<img style="position:absolute; right: 100px; top: 50px;" src="<?=Url::base();?>/images/ppsdm-logo-atas.png">
<article>


<div class='center'>
<h3>PSIKOGRAM HASIL PEMERIKSAAN POTENSI PSIKOLOGIK</h3>
</div>
<?php if(array_key_exists('0',$objectPrint['psikogramSQLDataProvider'])) { ?>
<table border="3" cellpadding="0" cellspacing="0" style="border-collapse:collapse;width:100%">
   <colgroup>
	   <col span="1"><col span="3"  width="64">
	   <col  width="60">
	   <col span="5"  width="64">
	   <col  width="12">
	   <col  width="32">
	   <col  width="28">
	   <col  width="32">
	   <col  width="33">
	   <col width="24">
	   <col  width="22">
	   <col  width="32">
   </colgroup>
   <tr bgcolor="yellow">
	   <td class="psikogramtable1" colspan="5" rowspan="2"  >
	   ASPEK PSIKOLOGIS</td>
	   <td class="psikogramtable2" colspan="6" rowspan="2" >
	   KETERANGAN</td>
	   <td class="psikogramtable3" colspan="7" >P E  N I L A I A N</td>
   </tr>
   <tr bgcolor="yellow">
	   <td class="psikogramtable4" >1</td>
	   <td class="psikogramtable4" >2</td>
	   <td class="psikogramtable4" >3</td>
	   <td class="psikogramtable4" >4</td>
	   <td class="psikogramtable4" >5</td>
	   <td class="psikogramtable4" >6</td>
	   <td class="psikogramtable5" >7</td>
   </tr>
   <tr bgcolor="#B8CCE4">
	   <td class="psikogramtable6"  style="height: 20pt;; width: 25px;">
	   A</td>
	   <td class="psikogramtable7" colspan="17">ASPEK INTELEKTUAL</td>
   </tr>
   <tr>
	   <td class="psikogramtable8"  rowspan="5" >
	   &nbsp;</td>
	   <td class="psikogramtable9" >1</td>
	   <td class="psikogramtable10" colspan="3">

	   <?=$objectPrint['psikogram'][$objectPrint['psikogramSQLDataProvider'][0]['key']]['attribute_1'];?></td>
	   <td class="psikogramtable11" colspan="6" >
	   <?=$objectPrint['psikogram'][$objectPrint['psikogramSQLDataProvider'][0]['key']]['attribute_2'];?></td>
	   <td class="<?php $objectPrint['psikogramSQLDataProvider'][0]['standar']=='1' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][0]['value']=='1') {echo 'X';} else {};?></td>
	   <td class="<?php $objectPrint['psikogramSQLDataProvider'][01]['standar']=='2' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][0]['value']=='2') {echo 'X';} else {};?></td>
	   <td class="<?php $objectPrint['psikogramSQLDataProvider'][0]['standar']=='3' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][0]['value']=='3') {echo 'X';} else {};?></td>
	   <td class="<?php $objectPrint['psikogramSQLDataProvider'][0]['standar']=='4' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][0]['value']=='4') {echo 'X';} else {};?></td>
	   <td class="<?php $objectPrint['psikogramSQLDataProvider'][0]['standar']=='5' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][0]['value']=='5') {echo 'X';} else {};?></td>
	   <td class="<?php $objectPrint['psikogramSQLDataProvider'][0]['standar']=='6' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][0]['value']=='6') {echo 'X';} else {};?></td>
	   <td class="<?php $objectPrint['psikogramSQLDataProvider'][0]['standar']=='7' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][0]['value']=='7') {echo 'X';} else {};?></td>
   </tr>
   <tr>
	   <td class="psikogramtable9" >
	   2</td>
	   <td class="psikogramtable10" colspan="3"><?=$objectPrint['psikogram'][$objectPrint['psikogramSQLDataProvider'][1]['key']]['attribute_1'];?></td>
	   <td class="psikogramtable11" colspan="6" >
	   <?=$objectPrint['psikogram'][$objectPrint['psikogramSQLDataProvider'][1]['key']]['attribute_2'];?></td>
	   <td class="<?php $objectPrint['psikogramSQLDataProvider'][1]['standar']=='1' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][1]['value']=='1') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][1]['standar']=='2' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][1]['value']=='2') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][1]['standar']=='3' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][1]['value']=='3') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][1]['standar']=='4' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][1]['value']=='4') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][1]['standar']=='5' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][1]['value']=='5') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][1]['standar']=='6' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][1]['value']=='6') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][1]['standar']=='7' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][1]['value']=='7') {echo 'X';} else {};?></td>
   </tr>
   <tr>
	   <td class="psikogramtable9" >
	   3</td>
	   <td class="psikogramtable10" colspan="3"><?=$objectPrint['psikogram'][$objectPrint['psikogramSQLDataProvider'][2]['key']]['attribute_1'];?></td>
	   <td class="psikogramtable11" colspan="6" >
	   <?=$objectPrint['psikogram'][$objectPrint['psikogramSQLDataProvider'][2]['key']]['attribute_2'];?></td>
	   <td class="<?php $objectPrint['psikogramSQLDataProvider'][2]['standar']=='1' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][2]['value']=='1') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][2]['standar']=='2' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][2]['value']=='2') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][2]['standar']=='3' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][2]['value']=='3') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][2]['standar']=='4' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][2]['value']=='4') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][2]['standar']=='5' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][2]['value']=='5') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][2]['standar']=='6' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][2]['value']=='6') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][2]['standar']=='7' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][2]['value']=='7') {echo 'X';} else {};?></td>
   </tr>
   <tr>
	   <td class="psikogramtable9" >
	   4</td>
	   <td class="psikogramtable10" colspan="3"><?=$objectPrint['psikogram'][$objectPrint['psikogramSQLDataProvider'][3]['key']]['attribute_1'];?></td>
	   <td class="psikogramtable11" colspan="6" >
	   <?=$objectPrint['psikogram'][$objectPrint['psikogramSQLDataProvider'][3]['key']]['attribute_2'];?></td>
	   <td class="<?php $objectPrint['psikogramSQLDataProvider'][3]['standar']=='1' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][3]['value']=='1') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][3]['standar']=='2' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][3]['value']=='2') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][3]['standar']=='3' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][3]['value']=='3') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][3]['standar']=='4' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][3]['value']=='4') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][3]['standar']=='5' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][3]['value']=='5') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][3]['standar']=='6' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][3]['value']=='6') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][3]['standar']=='7' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][3]['value']=='7') {echo 'X';} else {};?></td>
   </tr>
   <tr>
	   <td class="psikogramtable9"  >
	   5</td>
	   <td class="psikogramtable10" colspan="3"><?=$objectPrint['psikogram'][$objectPrint['psikogramSQLDataProvider'][4]['key']]['attribute_1'];?></td>
	   <td class="psikogramtable11" colspan="6" >
	   <?=$objectPrint['psikogram'][$objectPrint['psikogramSQLDataProvider'][4]['key']]['attribute_2'];?></td>
	   <td class="<?php $objectPrint['psikogramSQLDataProvider'][4]['standar']=='1' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][4]['value']=='1') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][4]['standar']=='2' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][4]['value']=='2') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][4]['standar']=='3' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][4]['value']=='3') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][4]['standar']=='4' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][4]['value']=='4') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][4]['standar']=='5' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][4]['value']=='5') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][4]['standar']=='6' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][4]['value']=='6') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][4]['standar']=='7' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][4]['value']=='7') {echo 'X';} else {};?></td>
   </tr>
   <tr bgcolor="bf8f00">
	   <td class="psikogramtable6"  style="height: 20pt;; width: 25px;">
	   B</td>
	   <td class="psikogramtable7" colspan="17">ASPEK SIKAP KERJA</td>
   </tr>
   <tr>
	   <td class="psikogramtable8"  rowspan="5" >
	   &nbsp;</td>
	   <td class="psikogramtable9" >1</td>
	   <td class="psikogramtable10" colspan="3"><?=$objectPrint['psikogram'][$objectPrint['psikogramSQLDataProvider'][5]['key']]['attribute_1'];?></td>
	   <td class="psikogramtable11" colspan="6" >
	   <?=$objectPrint['psikogram'][$objectPrint['psikogramSQLDataProvider'][5]['key']]['attribute_2'];?></td>
	   <td class="<?php $objectPrint['psikogramSQLDataProvider'][5]['standar']=='1' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][5]['value']=='1') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][5]['standar']=='2' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][5]['value']=='2') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][5]['standar']=='3' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][5]['value']=='3') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][5]['standar']=='4' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][5]['value']=='4') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][5]['standar']=='5' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][5]['value']=='5') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][5]['standar']=='6' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][5]['value']=='6') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][5]['standar']=='7' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][5]['value']=='7') {echo 'X';} else {};?></td>
   </tr>
   <tr>
	   <td class="psikogramtable9" >
	   2</td>
	   <td class="psikogramtable10" colspan="3"><?=$objectPrint['psikogram'][$objectPrint['psikogramSQLDataProvider'][6]['key']]['attribute_1'];?></td>
	   <td class="psikogramtable11" colspan="6" >
	   <?=$objectPrint['psikogram'][$objectPrint['psikogramSQLDataProvider'][6]['key']]['attribute_2'];?><span style="mso-spacerun:yes">&nbsp;</span></td>
	   <td class="<?php $objectPrint['psikogramSQLDataProvider'][6]['standar']=='1' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][6]['value']=='1') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][6]['standar']=='2' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][6]['value']=='2') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][6]['standar']=='3' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][6]['value']=='3') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][6]['standar']=='4' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][6]['value']=='4') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][6]['standar']=='5' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][6]['value']=='5') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][6]['standar']=='6' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][6]['value']=='6') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][6]['standar']=='7' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][6]['value']=='7') {echo 'X';} else {};?></td>
   </tr>
   <tr>
	   <td class="psikogramtable9" >
	   3</td>
	   <td class="psikogramtable10" colspan="3"><?=$objectPrint['psikogram'][$objectPrint['psikogramSQLDataProvider'][7]['key']]['attribute_1'];?></td>
	   <td class="psikogramtable11" colspan="6" >
	   <?=$objectPrint['psikogram'][$objectPrint['psikogramSQLDataProvider'][7]['key']]['attribute_2'];?></td>
	   <td class="<?php $objectPrint['psikogramSQLDataProvider'][7]['standar']=='1' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][7]['value']=='1') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][7]['standar']=='2' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][7]['value']=='2') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][7]['standar']=='3' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][7]['value']=='3') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][7]['standar']=='4' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][7]['value']=='4') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][7]['standar']=='5' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][7]['value']=='5') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][7]['standar']=='6' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][7]['value']=='6') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][7]['standar']=='7' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][7]['value']=='7') {echo 'X';} else {};?></td>
   </tr>
   <tr>
	   <td class="psikogramtable9" >4</td>
	   <td class="psikogramtable10" colspan="3" style="height: 20pt;"><?=$objectPrint['psikogram'][$objectPrint['psikogramSQLDataProvider'][8]['key']]['attribute_1'];?></td>
	   <td class="psikogramtable11" colspan="6"  width="332">
	   <?=$objectPrint['psikogram'][$objectPrint['psikogramSQLDataProvider'][8]['key']]['attribute_2'];?></td>
	   <td class="<?php $objectPrint['psikogramSQLDataProvider'][8]['standar']=='1' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][8]['value']=='1') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][8]['standar']=='2' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][8]['value']=='2') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][8]['standar']=='3' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][8]['value']=='3') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][8]['standar']=='4' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][8]['value']=='4') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][8]['standar']=='5' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][8]['value']=='5') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][8]['standar']=='6' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][8]['value']=='6') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][8]['standar']=='7' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][8]['value']=='7') {echo 'X';} else {};?></td>
   </tr>
   <tr>
	   <td class="psikogramtable9"  >
	   5</td>
	   <td class="psikogramtable10" colspan="3"><?=$objectPrint['psikogram'][$objectPrint['psikogramSQLDataProvider'][9]['key']]['attribute_1'];?></td>
	   <td class="psikogramtable11" colspan="6" >
	   <?=$objectPrint['psikogram'][$objectPrint['psikogramSQLDataProvider'][9]['key']]['attribute_2'];?></td>
	   <td class="<?php $objectPrint['psikogramSQLDataProvider'][9]['standar']=='1' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][9]['value']=='1') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][9]['standar']=='2' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][9]['value']=='2') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][9]['standar']=='3' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][9]['value']=='3') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][9]['standar']=='4' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][9]['value']=='4') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][9]['standar']=='5' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][9]['value']=='5') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][9]['standar']=='6' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][9]['value']=='6') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][9]['standar']=='7' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][9]['value']=='7') {echo 'X';} else {};?></td>
   </tr>
   <tr bgcolor="#00b050">
	   <td class="psikogramtable6"  style="height: 20pt;; width: 25px;">
	   C</td>
	   <td class="psikogramtable7" colspan="17">ASPEK KEPRIBADIAN</td>
   </tr>
   <tr>
	   <td class="psikogramtable8"  rowspan="5" >
	   &nbsp;</td>
	   <td class="psikogramtable9" >1</td>
	   <td class="psikogramtable10" colspan="3"><?=$objectPrint['psikogram'][$objectPrint['psikogramSQLDataProvider'][10]['key']]['attribute_1'];?></td>
	   <td class="psikogramtable11" colspan="6" >
	   <?=$objectPrint['psikogram'][$objectPrint['psikogramSQLDataProvider'][10]['key']]['attribute_2'];?></td>
	   <td class="<?php $objectPrint['psikogramSQLDataProvider'][10]['standar']=='1' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][10]['value']=='1') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][10]['standar']=='2' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][10]['value']=='2') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][10]['standar']=='3' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][10]['value']=='3') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][10]['standar']=='4' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][10]['value']=='4') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][10]['standar']=='5' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][10]['value']=='5') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][10]['standar']=='6' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][10]['value']=='6') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][10]['standar']=='7' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][10]['value']=='7') {echo 'X';} else {};?></td>
   </tr>
   <tr>
	   <td class="psikogramtable9" >
	   2</td>
	   <td class="psikogramtable10" colspan="3"><?=$objectPrint['psikogram'][$objectPrint['psikogramSQLDataProvider'][11]['key']]['attribute_1'];?></td>
	   <td class="psikogramtable11" colspan="6" >
	   <?=$objectPrint['psikogram'][$objectPrint['psikogramSQLDataProvider'][11]['key']]['attribute_2'];?></td>
	   <td class="<?php $objectPrint['psikogramSQLDataProvider'][11]['standar']=='1' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][11]['value']=='1') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][11]['standar']=='2' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][11]['value']=='2') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][11]['standar']=='3' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][11]['value']=='3') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][11]['standar']=='4' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][11]['value']=='4') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][11]['standar']=='5' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][11]['value']=='5') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][11]['standar']=='6' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][11]['value']=='6') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][11]['standar']=='7' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][11]['value']=='7') {echo 'X';} else {};?></td>
   </tr>
   <tr>
	   <td class="psikogramtable9" >
	   3</td>
	   <td class="psikogramtable10" colspan="3"><?=$objectPrint['psikogram'][$objectPrint['psikogramSQLDataProvider'][12]['key']]['attribute_1'];?></td>
	   <td class="psikogramtable11" colspan="6" >
	   <?=$objectPrint['psikogram'][$objectPrint['psikogramSQLDataProvider'][12]['key']]['attribute_2'];?></td>
	   <td class="<?php $objectPrint['psikogramSQLDataProvider'][12]['standar']=='1' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][12]['value']=='1') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][12]['standar']=='2' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][12]['value']=='2') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][12]['standar']=='3' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][12]['value']=='3') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][12]['standar']=='4' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][12]['value']=='4') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][12]['standar']=='5' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][12]['value']=='5') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][12]['standar']=='6' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][12]['value']=='6') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][12]['standar']=='7' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][12]['value']=='7') {echo 'X';} else {};?></td>
   </tr>
   <tr>
	   <td class="psikogramtable9" >
	   4</td>
	   <td class="psikogramtable10" colspan="3"><?=$objectPrint['psikogram'][$objectPrint['psikogramSQLDataProvider'][13]['key']]['attribute_1'];?></td>
	   <td class="psikogramtable11" colspan="6" >
	   <?=$objectPrint['psikogram'][$objectPrint['psikogramSQLDataProvider'][13]['key']]['attribute_2'];?></td>
	   <td class="<?php $objectPrint['psikogramSQLDataProvider'][13]['standar']=='1' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][13]['value']=='1') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][13]['standar']=='2' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][13]['value']=='2') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][13]['standar']=='3' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][13]['value']=='3') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][13]['standar']=='4' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][13]['value']=='4') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][13]['standar']=='5' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][13]['value']=='5') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][13]['standar']=='6' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][13]['value']=='6') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][13]['standar']=='7' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][13]['value']=='7') {echo 'X';} else {};?></td>
   </tr>
   <tr>
	   <td class="psikogramtable9"  >
	   5</td>
	   <td class="psikogramtable10" colspan="3"><?=$objectPrint['psikogram'][$objectPrint['psikogramSQLDataProvider'][14]['key']]['attribute_1'];?></td>
	   <td class="psikogramtable11" colspan="6" >
	   <?=$objectPrint['psikogram'][$objectPrint['psikogramSQLDataProvider'][14]['key']]['attribute_2'];?><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp;</span></td>
	   <td class="<?php $objectPrint['psikogramSQLDataProvider'][14]['standar']=='1' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][14]['value']=='1') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][14]['standar']=='2' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][14]['value']=='2') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][14]['standar']=='3' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][14]['value']=='3') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][14]['standar']=='4' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][14]['value']=='4') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][14]['standar']=='5' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][14]['value']=='5') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][14]['standar']=='6' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][14]['value']=='6') {echo 'X';} else {};?></td>
		<td class="<?php $objectPrint['psikogramSQLDataProvider'][14]['standar']=='7' ? print 'psikogramtable13': print  'psikogramtable12';?>"><?php if ($objectPrint['psikogramSQLDataProvider'][14]['value']=='7') {echo 'X';} else {};?></td>
   </tr>
   <tr bgcolor="#B8CCE4">
	   <td class="psikogramtable18" colspan="11" width="444">
	   TOTAL SKOR<font class="font5">.</font></td>
	   <td class="psikogramtable2" colspan="7"><?=$objectPrint['PArp'];?></td>
   </tr>
</table>
		<?php } else {echo 'no data';}?>

<br/>

<table width="100%" class="rekomendasi">
<thead>
<tr>
<td style='font-size:12px;' colspan="6"><strong>REKOMENDASI : </strong>Memperhatikan seluruh Gambaran  aspek psikologis yang dimiliki, dikaitkan dengan kemungkinan keberhasilannya untuk memikul beban tugas dan tanggung jawab yang lebih besar, maka Potensi Psikologinya secara umum tergolong :</td>
</tr>
</thead>
<tbody>
<tr bgcolor="#B8CCE4">
<th colspan="2" rowspan="1" scope="col">Kualifikasi</th>
<th colspan="1" rowspan="1" scope="col">Rekomendasi</th>
<th colspan="3" rowspan="1" scope="col">Skala</th>
</tr>
<?php
$PArp = $objectPrint['PArp'];

if (round($PArp/66*100) >=100) {
    $bgclolor1 = '#C4D79B';$bgclolor2 = '#ffffff';$bgclolor3 = '#ffffff';
}
else if ((round($PArp/66*100) >= 75) && (round($PArp/66*100) <= 99)) {
    $bgclolor1 = '#ffffff';$bgclolor2 = '#C4D79B';$bgclolor3 = '#ffffff';
}
else {
	$bgclolor1 = '#ffffff';$bgclolor2 = '#ffffff';$bgclolor3 = '#C4D79B';
}
?>
<tr bgcolor="<?=$bgclolor1;?>">
<td>K-1</td>
<td>Baik</td>
<td>Mampu berkembang secara wajar</td>
<td>100%</td><td>-</td><td>ke atas</td>
</tr>
<tr bgcolor="<?=$bgclolor2;?>">
<td>K-2</td>
<td>Cukup</td>
<td>Mampu berkembang spesifik</td>
<td>75%</td><td>-</td><td>99%</td>
</tr>
<tr bgcolor="<?=$bgclolor3;?>">
<td>K-3</td>
<td>Kurang</td>
<td>Kemampuan perkembangannya terbatas</td>
<td>74%</td><td>-</td><td>ke bawah</td>
</tr>
</tbody>
</table>
<?=$footerReport;?>
</article>
</section>


<section class="sheet padding-25mm">
<div class="headerReport">
<h2>RAHASIA</h2>
<hr></div>
<img style="position:absolute; right: 100px; top: 50px;" src="<?=Url::base();?>/images/ppsdm-logo-atas.png">
<article>

<br/>
	<div class='center' style="border-style: solid;"><h3>GAMBARAN POSISI 9-CELL (KOMPETENSI DAN POTENSI)</h3></div>


	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart'], 'language': 'id'});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Potensi', 'Kompetensi'],
          [ <?=round($PArp/66*100); ?>,  <?=round($PArk/$sumC*100); ?>], //ini harus diisi

        ]);

        var options = {

          hAxis: {
              //title: 'Potensi', minValue: 0, maxValue: 100,
              gridlines:{color: '#eee', count: 7},
			  ticks: [0, 20, 40, 60, 80, 100, 120, 140, ]
              },
          vAxis: {
             // title: 'Kompetensi', minValue: 0, maxValue: 100,
             gridlines:{color: '#eee', count: 7},
			 ticks: [0, 20, 40, 60,  80,100, 120, 140, ]
             },
          crosshair: { trigger: 'both' },
          legend: 'none',
          backgroundColor: { fill:'transparent' }
          //vAxis.gridlines:{color: '#333', count: 4}
        };

        var chart = new google.visualization.ScatterChart(document.getElementById('chart_div'));

        chart.draw(data, options);
      }
    </script>
<table class="center">
<tr>
<td align="left">

<?php
$sumbuY = round($PArk/$sumC*100);
$sumbuX = round($PArp/66*100);
if ($sumbuY >=100) {
    echo "<img height='450' width='130' src=".Url::base()."/images/kompetensiSumbuY-top.png>";
}

else if ($sumbuY >= 75 && $sumbuY <= 99) {
    echo "<img height='450' width='130' src=".Url::base()."/images/kompetensiSumbuY-middle.png>";

}
else {
	echo "<img height='450' width='130' src=".Url::base()."/images/kompetensiSumbuY-bottom.png>";
}
?>

</td>
<td>
<div id="chart_div"
    style="width: 600px; height: 600px;
    background-image: url('<?=Url::base()?>/images/ninecell.png');
    background-repeat: no-repeat;
    background-position: center;
    ">
    </div>
 </td></tr>
 <tr>
 <td>

<div style= "margin:10px;">
<table style="width: 100%; margin-left: auto; margin-right: auto;" border="1" cellspacing="1" cellpadding="1">
<tbody>
<tr>
<td bgcolor="yellow">X</td>
<td bgcolor="yellow"><?=$sumbuX;?>%</td>
<td rowspan="2"><h2>
<?php
if ($sumbuX < 75 && $sumbuY < 75) {$ninecellScore = 1;}
else if ($sumbuX < 75 && $sumbuY < 100 && $sumbuY > 74 && $sumbuY < 100) {$ninecellScore = 2;}
else if ($sumbuX >= 75 && $sumbuX < 100 && $sumbuY < 75) {$ninecellScore = 3;}
else if ($sumbuX < 75 && $sumbuY < 99) {$ninecellScore = 4;}
else if ($sumbuX >= 75 && $sumbuX < 100 && $sumbuY > 74 && $sumbuY < 100) {$ninecellScore = 5;}
else if ($sumbuX >= 100 && $sumbuY < 75) {$ninecellScore = 6;}
else if ($sumbuX >= 75 && $sumbuX < 100 && $sumbuY >= 100) {$ninecellScore = 7;}
else if ($sumbuX >= 100 && $sumbuY >= 75 && $sumbuY < 100) {$ninecellScore = 8;}
else if ($sumbuX >= 100 && $sumbuY >= 100) {$ninecellScore = 9;}
else {$ninecellScore = 0;}
echo '<font style="color:green;">'.$ninecellScore.'</font>';
?>
</h2></td>
</tr>
<tr >
<td bgcolor="#B8CCE4">Y</td>
<td bgcolor="#B8CCE4"><?=$sumbuY;?>%</td>
</tr>
</tbody>
</table>
</div>

 </td>
<td align="left">
<?php
if ($sumbuX >=100) {
    echo "<img height='125' width='500' src=".Url::base()."/images/potensiSumbuX.png>";
}

else if ($sumbuX >= 75 && $sumbuX<= 99) {
    echo "<img height='125' width='500' src=".Url::base()."/images/potensiSumbuX-middle.png>";

}

else {
    echo "<img height='125' width='500' src=".Url::base()."/images/potensiSumbuX-bottom.png>";
}
?>

</td>


 </table>
 <?=$footerReport;?>
 </article>
 </section>


 <section class="sheet padding-25mm">
 <div class="headerReport">
 <h2>RAHASIA</h2>
 <hr></div>
 <img style="position:absolute; right: 100px; top: 68px;" src="<?=Url::base();?>/images/ppsdm-logo-atas.png">
 <article>

 <h3> HASIL ASESSMENT BERDASARKAN KOMPETENSI </H3>

 <hr style='border-top: 3px double;'>

 <H3>A. KOMPETENSI GENERIK</H3>





<?php
foreach ($objectPrint as $key => $value) {
if ($key == 'kompetensigram') {
	//echo count($value);

$kompetensigenerik = array_splice($value, 0, 2);
foreach ($kompetensigenerik as $key2 => $value2) {
?>

<table  class="cluster" style = 'width: 100%; height: 100%; overflow: auto;'>
<tr>
	 <td class="cluster1" rowspan="3" ><h1><?=strtoupper($key2);?></h1></td>
	 <td class="cluster3" rowspan="3" ><b>
	 <?=strtoupper($objectPrint['kompetensigramDict'][$key2]['attribute_1']);?></b><br/>
	 <?=$objectPrint['kompetensigramDict'][$key2]['textvalue'];?></td>
	 <td class="cluster4" >Standar</td>
	 <td class="cluster4" ><?=$value2['lkj'];?></td>
 </tr>
 <tr>
	 <td class="cluster4" >Individu</td>
	 <td class="cluster4" ><?=$value2['lki'];?></td>
 </tr>
 <tr>
	 <td class="cluster4" >Fit %</td>
	 <td class="cluster4" ><?=round($value2['lki']/$value2['lkj']*100);?>%</td>
 </tr>
 <tr>
	 <td class="cluster5" colspan="4"><?=str_replace('<p>','',str_replace($htmltag, $htmlesc,$value2['uraian']));?></td>


 </tr>
 </table>
 <br/>
<?php
}
}
}

?>
<?=$footerReport;?>
</article>
</section>


<section class="sheet padding-25mm">
 <div class="headerReport">
 <h2>RAHASIA</h2>
 <hr></div>
 <img style="position:absolute; right: 100px; top: 45px;" src="<?=Url::base();?>/images/ppsdm-logo-atas.png">
 <article>
	 <br/>
<?php
foreach ($objectPrint as $key => $value) {
if ($key == 'kompetensigram') {
	//echo count($value);

$kompetensigenerik = array_splice($value, 2, 2);
foreach ($kompetensigenerik as $key2 => $value2) {
?>

<table  class="cluster" style = 'width: 100%; height: 100%; overflow: auto;'>
<tr>
<td class="cluster1" rowspan="3" ><h1><?=strtoupper($key2);?></h1></td>
<td class="cluster3" rowspan="3" ><b>
<?=strtoupper($objectPrint['kompetensigramDict'][$key2]['attribute_1']);?></b><br/>
<?=$objectPrint['kompetensigramDict'][$key2]['textvalue'];?></td>
<td class="cluster4" >Standar</td>
<td class="cluster4" ><?=$value2['lkj'];?></td>
</tr>
 <tr>
	 <td class="cluster4" >Individu</td>
	 <td class="cluster4" ><?=$value2['lki'];?></td>
 </tr>
 <tr>
	 <td class="cluster4" >Fit %</td>
	 <td class="cluster4" ><?=round($value2['lki']/$value2['lkj']*100);?>%</td>
 </tr>
 <tr>
	 <td class="cluster5" colspan="4"><?=str_replace('<p>','',str_replace($htmltag, $htmlesc,$value2['uraian']));?></td>
 </tr>
 </table>
 <br/>
<?php
}
}
}
?>
<?=$footerReport;?>
 </article>
</section>








<section class="sheet padding-25mm">
<div class="headerReport">
<h2>RAHASIA</h2>
<hr></div>
<img style="position:absolute; right: 100px; top: 50px;" src="<?=Url::base();?>/images/ppsdm-logo-atas.png">
<article>


 <H3>B. KOMPETENSI SPESIFIK</H3>

 <?php
foreach ($objectPrint as $key => $value) {
if ($key == 'kompetensigram') {
	//echo count($value);

$kompetensispesifik = array_splice($value, 4, 2);
foreach ($kompetensispesifik as $key2 => $value2) {
?>

<table  class="cluster" style = 'width: 100%; height: 100%; overflow: auto;'>
<tr>
<td class="cluster1" rowspan="3" ><h1><?=strtoupper($key2);?></h1></td>
<td class="cluster3" rowspan="3" ><b>
<?=strtoupper($objectPrint['kompetensigramDict'][$key2]['attribute_1']);?></b><br/>
<?=$objectPrint['kompetensigramDict'][$key2]['textvalue'];?></td>
<td class="cluster4" >Standar</td>
<td class="cluster4" ><?=$value2['lkj'];?></td>
</tr>
 <tr>
	 <td class="cluster4" >Individu</td>
	 <td class="cluster4" ><?=$value2['lki'];?></td>
 </tr>
 <tr>
	 <td class="cluster4" >Fit %</td>
	 <td class="cluster4" ><?=round($value2['lki']/$value2['lkj']*100);?>%</td>
 </tr>
 <tr>
 <td class="cluster5" colspan="4"><?=str_replace('<p>','',str_replace($htmltag, $htmlesc,$value2['uraian']));?></td>
 </tr>
 </table>
 <br/>
<?php
}
}
}

?>
<?=$footerReport;?>
</article>
</section>

<section class="sheet padding-25mm">
<div class="headerReport">
<h2>RAHASIA</h2>
<hr></div>
<img style="position:absolute; right: 100px; top: 50px;" src="<?=Url::base();?>/images/ppsdm-logo-atas.png">
<article>

<br/>

 <?php
foreach ($objectPrint as $key => $value) {
if ($key == 'kompetensigram') {
	//echo count($value);

$kompetensispesifik = array_splice($value, 6, 2);
foreach ($kompetensispesifik as $key2 => $value2) {
?>

<table  class="cluster" style = 'width: 100%; height: 100%; overflow: auto;'>
<tr>
<td class="cluster1" rowspan="3" ><h1><?=strtoupper($key2);?></h1></td>
<td class="cluster3" rowspan="3" ><b>
<?=strtoupper($objectPrint['kompetensigramDict'][$key2]['attribute_1']);?></b><br/>
<?=$objectPrint['kompetensigramDict'][$key2]['textvalue'];?></td>
<td class="cluster4" >Standar</td>
<td class="cluster4" ><?=$value2['lkj'];?></td>
</tr>
 <tr>
	 <td class="cluster4" >Individu</td>
	 <td class="cluster4" ><?=$value2['lki'];?></td>
 </tr>
 <tr>
	 <td class="cluster4" >Fit %</td>
	 <td class="cluster4" ><?=round($value2['lki']/$value2['lkj']*100);?>%</td>
 </tr>
 <tr>
 <td class="cluster5" colspan="4"><?=str_replace('<p>','',str_replace($htmltag, $htmlesc,$value2['uraian']));?></td>
 </tr>
 </table>
 <br/>
<?php
}
}
}

?>
<?=$footerReport;?>
</article>
</section>


<section class="sheet padding-25mm">
<div class="headerReport">
<h2>RAHASIA</h2>
<hr></div>
<img style="position:absolute; right: 100px; top: 50px;" src="<?=Url::base();?>/images/ppsdm-logo-atas.png">
<article>

<br/>
 <?php
foreach ($objectPrint as $key => $value) {
if ($key == 'kompetensigram') {
	//echo count($value);

$kompetensispesifik = array_splice($value, 8, 2);
foreach ($kompetensispesifik as $key2 => $value2) {
?>

<table  class="cluster" style = 'width: 100%; height: 100%; overflow: auto;'>
<tr>
<td class="cluster1" rowspan="3" ><h1><?=strtoupper($key2);?></h1></td>
<td class="cluster3" rowspan="3" ><b>
<?=strtoupper($objectPrint['kompetensigramDict'][$key2]['attribute_1']);?></b><br/>
<?=$objectPrint['kompetensigramDict'][$key2]['textvalue'];?></td>
<td class="cluster4" >Standar</td>
<td class="cluster4" ><?=$value2['lkj'];?></td>
</tr>
 <tr>
	 <td class="cluster4" >Individu</td>
	 <td class="cluster4" ><?=$value2['lki'];?></td>
 </tr>
 <tr>
	 <td class="cluster4" >Fit %</td>
	 <td class="cluster4" ><?=round($value2['lki']/$value2['lkj']*100);?>%</td>
 </tr>
 <tr>
 <td class="cluster5" colspan="4"><?=str_replace('<p>','',str_replace($htmltag, $htmlesc,$value2['uraian']));?></td>
 </tr>
 </table>
 <br/>
<?php
}
}
}

?>
<?=$footerReport;?>
</article>
</section>



 <section class="sheet padding-25mm">
 <div class="headerReport">
 <h2>RAHASIA</h2>
 <hr></div>
 <img style="position:absolute; right: 100px; top: 50px;" src="<?=Url::base();?>/images/ppsdm-logo-atas.png">
 <article>



 <h3>KESIMPULAN</H3>
 <hr style='border-top: 3px double;'>
 <STRONG>A. HAL HAL POSITIF YANG MENUNJANG TAMPILNYA KINERJA YANG OPTIMAL</STRONG>

 <div style="text-align:justify;">
 <?=wordwrap(str_replace($htmltag, $htmlesc, $objectPrint['kekuatan']), 3000,  $pagebreak, false);?>
 </div>
 <?php if (strlen($objectPrint['kekuatan'])+strlen($objectPrint['kelemahan']) >= 3000) {echo $pagebreak;} else {echo '';}?>

 <STRONG>B. HAL HAL NEGATIF YANG MENGHAMBAT TAMPILNYA KINERJA YANG OPTIMAL</STRONG>
 <div style="text-align:justify;">
 <?=wordwrap(str_replace($htmltag, $htmlesc, $objectPrint['kelemahan']), 3000,  $pagebreak, false);?>
</div>

 <?=$footerReport;?>
 </article>
 </section>



 <section class="sheet padding-25mm">
 <div class="headerReport">
 <h2>RAHASIA</h2>
 <hr></div>
 <img style="position:absolute; right: 100px; top: 50px;" src="<?=Url::base();?>/images/ppsdm-logo-atas.png">
 <article>



 <H3>SARAN PENGEMBANGAN</h3>
 <hr style='border-top: 3px double;'>
 <?=wordwrap(str_replace($htmltag, $htmlesc,$objectPrint['saran_pengembangan']), 2650,  $pagebreak, false);?>

 <div class ='signatureRekomendasi'>
<div class='center'>
	Jakarta, <?=str_replace($monthE,$bulan,date_format($date, "j F Y"));?><br/>
	<strong>A.n PSIKOLOGI PEMERIKSA :<br/>
	<img height="60" width="230"src="<?=Url::base();?>/images/1/signature.png">
	<br/>
Drs. BUDIMAN SANUSI, M.Psi., Psikolog<br/>
No. SIP : 07231221
</strong>
</div>
</div>
<?=$footerReport;?>
 </article>
 </section>



</body>
