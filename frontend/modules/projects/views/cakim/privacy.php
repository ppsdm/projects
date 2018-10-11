<?php
use yii\web\View;
use yii\helpers\Html;

$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.6/d3.min.js',['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('@web/js/radarChart.js',['position' => \yii\web\View::POS_HEAD]);
$this->registerJs(
"var margin = {top: 65, right: 70, bottom: 130, left: 70},
width = Math.min(480, window.innerWidth - 0) - margin.left - margin.right,
height = Math.min(width, window.innerHeight - margin.top - margin.bottom - 20);
    
    var data = [
      [
		{axis:'',value:1},
      ],[
        {axis:'',value:1},
    
      ]
    ];


var color = d3.scale.ordinal()
.range(['#AEDFFB','#35274E']);

var radarChartOptions = {
w: width,
h: height,
margin: margin,
maxValue: 5,
levels: 5,
roundStrokes: true,
color: color,
opacityArea: 0.5,
opacityCircles: 0,
dotRadius: 3,
strokeWidth: 2, 
wrapWidth: 10,
labelFactor: 10,
};

RadarChart('.radarChart', data, radarChartOptions);"   ,
    View::POS_READY,
'ny-button-handler'
);
?>


<div class='center'>
<br/>
<h3>LAPORAN <br/>
ASESMEN POTENSI DAN KOMPETENSI<br/>
JABATAN PIMPINAN TINGGI PRATAMA DAN<br/>
JABATAN ADMINISTRATOR &amp; PENGAWAS<br/>
KEMENTRIAN KESEHATAN 2017</h3>
</div>




<br/>

<table class='cover'>
<tbody>
<tr>
<td>Nomor Test</td><td>:</td><td>[nomor]/EVAL/KEMENKES/VII/17.... </td></tr>
<tr>
<td>Nama Lengkap</td><td>:</td><td><?php echo $objectPrint['firstname']; ?></td></tr>
<tr>
<td>Tempat / Tgl. Lahir</td><td>:</td><td><?php echo $objectPrint['profile_meta']['personal']['birthplace']; ?> , <?php echo  date_format(date_create($objectPrint['birthdate']),"d/m/Y"); ?></td></tr>
<tr>
<td>Jabatan Saat ini</td><td>:</td><td><?php echo $objectPrint['profile_meta']['work']['current_position']; ?></td></tr>
<tr>
<td>Prospek Jabatan</td><td>:</td><td><?php echo $objectPrint['profile_meta']['work']['prospect_position']; ?></td></tr>
<tr>
<td>Pendidikan Terakhir</td><td>:</td><td><?php echo $objectPrint['profile_meta']['education']['latest']; ?></td></tr>
<tr>
<td>Alamat</td><td>:</td><td><?php echo $objectPrint['profile_meta']['address']['home_address']; ?></td></tr>
<tr>
<td>Tujuan Pemeriksaan</td><td>:</td><td>PEMENTAAN POTENSI & KOMPETENSI</td></tr>
<tr>
<td>Tempat / Tgl Test</td><td>:</td><td>Jakarta, <?php echo date("F j, Y"); ?></td></tr>
</tbody>
</table>


<div class='center'>
<br/>
<br/>
    Jakarta, September 2017<br/>
    <b>PPSDM Consultant</b>
</div>

<div class='kananTandaTangan'>
<div class='center'>
	<p>Penanggung jawab</p>
	<br/>
	<br/>
	<br/>
	Drs. Budiman Sanusi, MPsi.
	<br/>
	<b>SIP : </b>
</div>
</div>

<div class='kiriTandaTangan'>
<div class='center'>
	<p>Assesor</p>
	<br/>
	<br/>
	<br/>
	[Nama Psikolog]
	<br/>
	<b>SIP : </b>
</div>
</div>


<pagebreak />

<br/>
<div class='center'>
<h3>EXECUTIVE SUMMARY</h3>
</div>

<P><?php echo $objectPrint['executive_summary']; ?></p>

<pagebreak />

<div class='center'>
<br/>
 <p><h3>DIAGRAM KOMPETENSI</H3></p>
 <div class="radarChart"><img src="<?= \yii\helpers\Url::to('@web/images/Psikogram.png', true) ?>" height="400px" width="400px" alt="Psikogram" /></div>
</div>

<br/>
<div class='center'>
<table class="blueTable" align="center">
<thead>
<tr>
<th colspan="4" rowspan="1">Kompetensi</th>
<th>LKJ</th>
<th>LKI</th>
<th>DIS</th>
<th>PCT</th>
</tr>
</thead>
<tfoot></tfoot>
<tbody>
<tr>
<td colspan="1" rowspan="5">
<p>Mandatory</p>
<p>Competency</p>
</td>
<td colspan="2" rowspan="1">Kompetensi 01</td>
<td>KOMP-01</td>
<td>5</td>
<td><?php echo $objectPrint['kompetensigram']['int']['lki']; ?></td>
<td>-1</td>
<td>80%</td>
</tr>
<tr>
<td colspan="2" rowspan="1">Kompetensi 02</td>
<td>KOMP-02</td>
<td>4</td>
<td>5</td>
<td>1</td>
<td>125%</td>
</tr>
<tr>
<td colspan="2" rowspan="1">Kompetensi 03</td>
<td>KOMP-03</td>
<td>4</td>
<td>5</td>
<td>1</td>
<td>125%</td>
</tr>
<tr>
<td colspan="2" rowspan="1">Kompetensi 04</td>
<td>KOMP-04</td>
<td>5</td>
<td>4</td>
<td>-1</td>
<td>80%</td>
</tr>
<tr>
<td colspan="2" rowspan="1">Kompetensi 05</td>
<td>KOMP-05</td>
<td>5</td>
<td>3</td>
<td>-2</td>
<td>60%</td>
</tr>
<tr>
<td colspan="4" rowspan="1">&nbsp;</td>
<td><strong>23</strong></td>
<td><strong>21</strong></td>
<td><strong>-2</strong></td>
<td><strong>91%</strong></td>
</tr>
<tr>
<td colspan="1" rowspan="7">
<p>Personal</p>
<p>Quality</p>
</td>
<td colspan="2" rowspan="1">Kompetensi 06</td>
<td>KOMP-06</td>
<td>5</td>
<td>3</td>
<td>-2</td>
<td>60%</td>
</tr>
<tr>
<td colspan="2" rowspan="1">Kompetensi 07</td>
<td>KOMP-07</td>
<td>5</td>
<td>4</td>
<td>-1</td>
<td>80%</td>
</tr>
<tr>
<td colspan="2" rowspan="1">Kompetensi 08</td>
<td>KOMP-08</td>
<td>5</td>
<td>5</td>
<td><strong>0</strong></td>
<td><strong>100%</strong></td>
</tr>
<tr>
<td colspan="2" rowspan="1">Kompetensi 09</td>
<td>KOMP-09</td>
<td>4</td>
<td>5</td>
<td>1</td>
<td>125%</td>
</tr>
<tr>
<td colspan="2" rowspan="1">Kompetensi 10</td>
<td>KOMP-10</td>
<td>5</td>
<td>4</td>
<td>-1</td>
<td>80%</td>
</tr>
<tr>
<td colspan="2" rowspan="1">Kompetensi 11</td>
<td>KOMP-11</td>
<td>5</td>
<td>3</td>
<td>-2</td>
<td>60%</td>
</tr>
<tr>
<td colspan="2" rowspan="1">Kompetensi 12</td>
<td>KOMP-12</td>
<td>5</td>
<td><strong>5</strong></td>
<td><strong>0</strong></td>
<td><strong>100%</strong></td>
</tr>
<tr>
<td colspan="4" rowspan="1">&nbsp;</td>
<td><strong>34</strong></td>
<td><strong>29</strong></td>
<td><strong>-5</strong></td>
<td><strong>85%</strong></td>
</tr>
<tr>
<td colspan="4"><strong>Total</strong></td>
<td>57</td>
<td>50</td>
<td>-7</td>
<td>88%</td>
</tr>
</tbody>
</table>


<table class="klasifikasi" align="center"><caption>&nbsp;</caption>
<thead>
<tr>
<th colspan="2" rowspan="1" scope="col">Klasifikasi</th>
<th colspan="2" rowspan="1" scope="col">Kualitas Kompetensi</th>
</tr>
</thead>
<tbody>
<tr>
<td>K-1</td>
<td>TINGGI</td>
<td>Memenuhi semua atau lebih dari level kompetensi yang dipersyaratkan</td>
<td>100%- Keatas</td>
</tr>
<tr>
<td>K-2</td>
<td>SEDANG</td>
<td>Memenuhi sebagian kompetensi yang dipersyaratkan</td>
<td>75-99%</td>
</tr>
<tr>
<td>K-3</td>
<td>RENDAH</td>
<td>Kurang memenuhi kompetensi yang dipersyaratkan</td>
<td>74% ke bawah</td>
</tr>
</tbody>
</table>
</div>

<pagebreak/>


<pagebreak />

<br/>
<br/>
<div class='center'>
<h3>PSIKOGRAM HASIL PEMERIKSAAN POTENSI PSIKOLOGIK</h3>

<table class="psikogram">
<tr>
	<td class="auto-style1" colspan="5" rowspan="2">ASPEK PSIKOLOGIS</td>
	<td class="auto-style2" colspan="6" rowspan="2">KETERANGAN</td>
	<td class="auto-style3" colspan="7">P E N I L A I A N</td>
</tr>
<tr>
	<td class="auto-style4">1</td>
	<td class="auto-style4">2</td>
	<td class="auto-style4">3</td>
	<td class="auto-style4">4</td>
	<td class="auto-style4">5</td>
	<td class="auto-style4">6</td>
	<td class="auto-style5">7</td>
</tr>
<tr>
	<td class="auto-style6" >A</td>
	<td class="auto-style7" colspan="17">ASPEK INTELEKTUAL</td>
</tr>
<tr>
	<td class="auto-style8"  rowspan="5">&nbsp;</td>
	<td class="auto-style9">1</td>
	<td class="auto-style10" colspan="3">Inteligensi Umum</td>
	<td class="auto-style11" colspan="6">Gabungan keseluruhan potensi kecerdasan sebagai perpaduan dari aspek-aspek pembentukan intelektualitas</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style13">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style14">&nbsp;</td>
</tr>
<tr>
	<td class="auto-style9" >2</td>
	<td class="auto-style10" colspan="3">Berpikir Analitis</td>
	<td class="auto-style11" colspan="6">Kemampuan menguraikan masalah menjadi bagian-bagian dan menemukan hubungan sebab akibat dari suastu situasi</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style15">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style14">&nbsp;</td>
</tr>
<tr>
	<td class="auto-style9" >3</td>
	<td class="auto-style10" colspan="3">Logik Berfikir</td>
	<td class="auto-style11" colspan="6">Kemampuan untuk mengorganisir proses berfikir yang menunjukkan adanya alur berfikir yang sistematis dan logis</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style15">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style14">&nbsp;</td>
</tr>
<tr>
	<td class="auto-style9" >4</td>
	<td class="auto-style10" colspan="3">Kemampuan Belajar</td>
	<td class="auto-style11" colspan="6">Kemampuan menguasai dan meningkatkan pengetahuan dan ketrampilan kerja yang baru maupun yang telah dimiliki</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style13">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style14">&nbsp;</td>
</tr>
<tr>
	<td class="auto-style9" >5</td>
	<td class="auto-style10" colspan="3">Emotional Quotient</td>
	<td class="auto-style11" colspan="6">Kecerdasan Emosional, yakni keluasan pengetahuan dan kemampuan mengelola emosi secara optimal</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style13">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style14">&nbsp;</td>
</tr>
<tr>
	<td class="auto-style6" >B</td>
	<td class="auto-style7" colspan="17">ASPEK SIKAP KERJA</td>
</tr>
<tr>
	<td class="auto-style8"  rowspan="5">&nbsp;</td>
	<td class="auto-style9">1</td>
	<td class="auto-style10" colspan="3">Sistematika Kerja</td>
	<td class="auto-style11" colspan="6">Kemampuan dan ketrampilan menyelesaikan suatu tugas secara runut, proporsional, sesuai dengan skala prioritas tertentu</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style13">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style14">&nbsp;</td>
</tr>
<tr>
	<td class="auto-style9" >2</td>
	<td class="auto-style10" colspan="3">Tempo Kerja</td>
	<td class="auto-style11" colspan="6">Kecepatan dan kecekatan kerja, yang menunjukkan kemampuan menyelesaikan sejumlah tugas dalam batas waktu tertentu<span>&nbsp;</span>
	</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style13">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style14">&nbsp;</td>
</tr>
<tr>
	<td class="auto-style9" >3</td>
	<td class="auto-style10" colspan="3">Ketelitian</td>
	<td class="auto-style11" colspan="6">Kemampuan bekerja dengan sesedikit mungkin melakukan kesalahan atau kekeliruan</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style15">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style14">&nbsp;</td>
</tr>
<tr>
	<td class="auto-style9">4</td>
	<td class="auto-style10" colspan="3">Ketekunan</td>
	<td class="auto-style11" colspan="6">Daya tahan menghadapi dan menyelesaikan tugas sampai tuntas dalam waktu relatif lama dengan mencapai hasil yang optimal</td>
	<td class="auto-style12"/>
	<td class="auto-style12"/>
	<td class="auto-style12"/>
	<td class="auto-style13"/>
	<td class="auto-style12"/>
	<td class="auto-style12"/>
	<td class="auto-style14"/>
</tr>
<tr>
	<td class="auto-style9" >5</td>
	<td class="auto-style10" colspan="3">Komunikasi Efektif</td>
	<td class="auto-style11" colspan="6">Kemampuan menyampaikan pendapat secara lancar, sehingga pendengar paham dan bersedia mengikuti pendapatnya</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style15">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style14">&nbsp;</td>
</tr>
<tr>
	<td class="auto-style6" >C</td>
	<td class="auto-style7" colspan="17">ASPEK KEPRIBADIAN</td>
</tr>
<tr>
	<td class="auto-style8"  rowspan="5">&nbsp;</td>
	<td class="auto-style9">1</td>
	<td class="auto-style10" colspan="3">Motivasi</td>
	<td class="auto-style11" colspan="6">Keinginan meningkatkan hasil kerja dan selalu berfokus pada profit opportunities</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style13">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style14">&nbsp;</td>
</tr>
<tr>
	<td class="auto-style9" >2</td>
	<td class="auto-style10" colspan="3">Konsep Diri</td>
	<td class="auto-style11" colspan="6">Pemahaman atas kelebihan dan kekurangan diri sendiri</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style13">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style14">&nbsp;</td>
</tr>
<tr>
	<td class="auto-style9" >3</td>
	<td class="auto-style10" colspan="3">Empati</td>
	<td class="auto-style11" colspan="6">Kemampuan memahami dan merasakan adanya permasalahan dan kondisi emosional orang lain</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style15">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style14">&nbsp;</td>
</tr>
<tr>
	<td class="auto-style9" >4</td>
	<td class="auto-style10" colspan="3">Pemahaman Sosial</td>
	<td class="auto-style11" colspan="6">Kemampuan bereaksi dengan cepat terhadap kebutuhan orang lain atau tuntutan lingkungan, serta memahami norma sosial yang berlaku.</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style15">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style14">&nbsp;</td>
</tr>
<tr>
	<td class="auto-style9" >5</td>
	<td class="auto-style10" colspan="3">Pengaturan Diri</td>
	<td class="auto-style11" colspan="6">Kemampuan mengendalikan diri dalamsituasi-situasi sulit dan kemampuan melakukan perencanaan sebelum bertindak.<span>&nbsp;&nbsp;&nbsp;</span>
	</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style13">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style12">&nbsp;</td>
	<td class="auto-style14">&nbsp;</td>
</tr>
<tr>
	<td class="auto-style18" colspan="11">TOTALSKOR</td>
	<td class="auto-style2" colspan="7">0</td>
</tr>
</table>
</div>

<pagebreak />


<br/>
<br/>
<table class="rekomendasi">
<thead>
<tr>
<td colspan="3"><strong>Rekomendasi : </strong>Memperhatikan seluruh Gambaran  aspek psikologis yang dimiliki, dikaitkan dengan kemungkinan keberhasilannya untuk memikul beban tugas dan tanggung jawab yang lebih besar, maka Potensi Psikologinya secara umum tergolong :</td>
</tr>
</thead>
<tbody>
<tr>
<td  colspan="2"><strong>KUALITAS/ KUALIFIKASI PSIKOLOGIK</strong></td>
<td ><strong>NORMA</strong></td>
</tr>
<tr>
<td >K-1</td>
<td >Low</td>
<td >Mean - 1stDev. ke Bawah</td>
</tr>
<tr>
<td >K-2</td>
<td >Medium</td>
<td >Mean +/- 1StDev.</td>
</tr>
<tr>
<td >K-3</td>
<td >High</td>
<td >Mean + 1StDev. Ke Atas</td>
</tr>
</tbody>
</table>

<div class ='signatureRekomendasi'>
<div class='center'>
	Jakarta, <?php echo date("F j, Y"); ?><br/>
	<strong>A.n PSIKOLOGI PEMERIKSA :<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
(Drs. Budiman Sanusi MPsi)<br/>
No. HIMPSI : 0111891963
</strong>
</div>
</div>
<br/>
<i>*) Aspek Aspek diatas beserta passing grade hanya merupakan Contoh.
	<br/>
	Dalam pelaksanaan akan ditentukan kemudian berdasarkan hasil diskusi dan kesepakatan dengan pihak KEMENKES</i>
	<br/>


	<pagebreak />

	<br/>
	<br/>
	<div class='center'><h3>GAMBARAN POSISI 9-CELL (KOMPETENSI DAN POTENSI)</h3></div>


	<hr/>

	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart'], 'language': 'id'});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Potensi', 'Kompetensi'],
          [ 10,  34], //ini harus diisi

        ]);

        var options = {
          title: 'Gambaran Posisi 9-Cell (Kompetensi dan Potensi)',
          hAxis: {
              //title: 'Potensi', minValue: 0, maxValue: 100,
              gridlines:{color: '#eee', count: 7},
              ticks: [0, 20, 40, 60, 80, 100, 120, 140, ]
              },
          vAxis: {
             // title: 'Kompetensi', minValue: 0, maxValue: 100, 
             gridlines:{color: '#eee', count: 7},
             ticks: [0, 20, 40, 60, 80, 100, 120, 140, ]
             },
          crosshair: { trigger: 'both' },
          legend: 'none',
          backgroundColor: { fill:'transparent' }
          //vAxis.gridlines:{color: '#333', count: 4}
        };

        var chart = new google.visualization.ScatterChart(document.getElementById('chart_div'));

      // Wait for the chart to finish drawing before calling the getImageURI() method.
      google.visualization.events.addListener(chart, 'ready', function () {
        chart_div.innerHTML = '<img src="' + chart.getImageURI() + '">';
        console.log(chart_div.innerHTML);
      });        

        chart.draw(data, options);

        
      }
    </script>  	
<table class="center">
<tr>
<td><img src="/images/kompetensiSumbuY.png"></td>
<td>
    <div id="chart_div" class ="ninecell ">
    </div>
 </td></tr>
 <tr>
 <td></td>
<td align="center"><img src="/images/potensiSumbuX.png"></td>


 </table>  

 <pagebreak />
 <br/>
 <h3> HASIL ASESSMENT BERDASARKAN KOMPETENSI </H3>

 <hr/>

 <H3>A. CLUSTER KOMPETENSI INTI (CORE KOMPETENCY)</H3>


 <br/>


 <table  class="cluster">
 <tr>
	 <td class="cluster1" rowspan="3" ><h1>A-1</h1></td>
	 <td class="cluster3" rowspan="3" >&nbsp;</td>
	 <td class="cluster4" >Standar</td>
	 <td class="cluster4" >&nbsp;</td>
 </tr>
 <tr>
	 <td class="cluster4" >Individu</td>
	 <td class="cluster4" >&nbsp;</td>
 </tr>
 <tr>
	 <td class="cluster4" >Fit %</td>
	 <td class="cluster4" ></td>
 </tr>
 <tr>
	 <td class="cluster5" colspan="4"><br><br><br><br><br><br><br></td>
 </tr>
 <tr>
	 <td class="cluster1" rowspan="3" ><h1>A-2</h1></td>
	 <td class="cluster3" rowspan="3" >&nbsp;</td>
	 <td class="cluster4" >Standar</td>
	 <td class="cluster4" >&nbsp;</td>
 </tr>
 <tr>
	 <td class="cluster4" >Individu</td>
	 <td class="cluster4" >&nbsp;</td>
 </tr>
 <tr>
	 <td class="cluster4" >Fit %</td>
	 <td class="cluster4" ></td>
 </tr>
 <tr>
	 <td class="cluster5" colspan="4"><br><br><br><br><br><br><br></td>
 </tr>
 <tr>
	 <td class="cluster1" rowspan="3" ><h1>A-3</h1></td>
	 <td class="cluster3" rowspan="3" >&nbsp;</td>
	 <td class="cluster4" >Standar</td>
	 <td class="cluster4" >&nbsp;</td>
 </tr>
 <tr>
	 <td class="cluster4" >Individu</td>
	 <td class="cluster4" >&nbsp;</td>
 </tr>
 <tr>
	 <td class="cluster4" >Fit %</td>
	 <td class="cluster4" ></td>
 </tr>
 <tr>
	 <td class="cluster5" colspan="4"><br><br><br><br><br><br><br></td>
 </tr>
</table>


<pagebreak />
 <br/>

 <H3>B. CLUSTER KOMPETENSI MANAGERIAL (MANAGERIAL KOMPETENCY)</H3>


 <br/>


 <table  class="cluster">
 <tr>
	 <td class="cluster1" rowspan="3" ><h1>B-1</h1></td>
	 <td class="cluster3" rowspan="3" >&nbsp;</td>
	 <td class="cluster4" >Standar</td>
	 <td class="cluster4" >&nbsp;</td>
 </tr>
 <tr>
	 <td class="cluster4" >Individu</td>
	 <td class="cluster4" >&nbsp;</td>
 </tr>
 <tr>
	 <td class="cluster4" >Fit %</td>
	 <td class="cluster4" ></td>
 </tr>
 <tr>
	 <td class="cluster5" colspan="4"><br><br><br><br><br><br><br></td>
 </tr>
 <tr>
	 <td class="cluster1" rowspan="3" ><h1>B-2</h1></td>
	 <td class="cluster3" rowspan="3" >&nbsp;</td>
	 <td class="cluster4" >Standar</td>
	 <td class="cluster4" >&nbsp;</td>
 </tr>
 <tr>
	 <td class="cluster4" >Individu</td>
	 <td class="cluster4" >&nbsp;</td>
 </tr>
 <tr>
	 <td class="cluster4" >Fit %</td>
	 <td class="cluster4" ></td>
 </tr>
 <tr>
	 <td class="cluster5" colspan="4"><br><br><br><br><br><br><br></td>
 </tr>
 <tr>
	 <td class="cluster1" rowspan="3" ><h1>B-3</h1></td>
	 <td class="cluster3" rowspan="3" >&nbsp;</td>
	 <td class="cluster4" >Standar</td>
	 <td class="cluster4" >&nbsp;</td>
 </tr>
 <tr>
	 <td class="cluster4" >Individu</td>
	 <td class="cluster4" >&nbsp;</td>
 </tr>
 <tr>
	 <td class="cluster4" >Fit %</td>
	 <td class="cluster4" ></td>
 </tr>
 <tr>
	 <td class="cluster5" colspan="4"><br><br><br><br><br><br><br></td>
 </tr>
</table>


<pagebreak />
 <br/>
 <h3> KESIMPULAN - RESUME </H3>
 <HR/>

 <H3>A. HAL-HAL POSITIF YANG MENUNJANG KINERJA (KEKUATAN)</h3>
 <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>

 <H3>B. SARAN PENGEMBANGAN</h3>
 <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>

 
