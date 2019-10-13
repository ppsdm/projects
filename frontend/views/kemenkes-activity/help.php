<?php
use yii\helpers\Html;

?>
<h2 id="atas"><b> PETUNJUK PELAKSANAAN</b> </h2>
<h3><b>Daftar Isi</b></h3>
    <ul>
        <li>Umum</li>
        <li> <a href="#data-diri">Panduan Asesor</a></li>
            <ul>
                <li><a href="#data-diri">Pengisian Data Diri</a> </li>
                <li><a href="#psikogram">Pengisian Psikogram</a></li>
                <li><a href="#kompetensi">Pengisian Aspek Kompetensi</a></li>
                <li><a href="#plus-minus">Pengisian Kelemahan dan Kelebihan</a> </li>
                <li><a href="#exsum">Pengisian Executive Summary</a></li>
            </ul>
        <li><a href="#So-er">Panduan Second Opinion</a></li>
    </ul>
<h5>▼ ---------------------------------------------------------------------------------------------------------------- ▼ <a href="#atas"> ▲ Ke Atas ▲ </a></h5>
<h3><b>Umum</b></h3>
<ul>
<li>Status laporan terdiri dari</li>
    <ul>
    <li><i><b>Submitted :</b></i> asesor sudah selesai mengisi laporan dan siap untuk di <b>SO</b><p><?= Html::img('@web/images/setkab/help/status-submitted.png', ['alt' => 'datadiri', 'width' => 600]) ?> </p></li>
    <li><i><b>Reviewed :</b></i> laporan sudah selesai dikontrol melalui quailty contro para <i>"SO-er"</i><p><?= Html::img('@web/images/setkab/help/status-reviewed.png', ['alt' => 'datadiri', 'width' => 600, 'border'=>5]) ?> </p></li>
    <li><i><b>Returned :</b></i> laporan dikembalikan kepada asesor yang bersangkutan <p><?= Html::img('@web/images/setkab/help/status-returned.png', ['alt' => 'datadiri', 'width' => 600, 'border' => 5]) ?> </p></li>
    </ul>
<li>Notifikasi ketiga status hanya ada diaplikasi untuk kedua status dari <b>SO-er</b> akan diberitahukan melalui jaringan pribadi SO kepada asesor yang bersangkutan</li>
<li>Tombol <b>UPDATE</b> fungsinya sama dengan <b>SAVE</b> </li>
<li>Setiap menekan tombol <b>UPDATE</b> maka akan kembali ke halaman utama <b><i>assessee</i></b> yang bersangkutan </li>
<li>Klik <?= Html::button('Edit', ['class' => 'btn btn-primary']) ?> untuk mulai mengerjakan setiap bagian laporan</li>
<li> Tombol <b>Edit</b> akan berubah warna ketika masing - masing uraian sudah memenuhi jumlah minimal kata yang dipersyaratkan yakni:
    <ul>
    <li>Warna kuning : <?= Html::button('Edit', ['class' => 'btn btn-warning']) ?> kondisi default, uraian belum memenuhi jumlah minimal kata yang dipersyaratkan</li>
    <li>Warna hijau : <?= Html::button('Edit', ['class' => 'btn btn-success']) ?> uraian sudah memenuhi jumlah kata yang dipersyaratkan</li>
    <li>Warna biru : <?= Html::button('Edit', ['class' => 'btn btn-primary']) ?> khusus untuk <b>Data Diri</b> dan <b>Psikogram</b> tidak akan berubah meski isinya sudah diubah</li>
    </ul>
</ul>

<h5>▼ ---------------------------------------------------------------------------------------------------------------- ▼ <a href="#atas"> ▲ Ke Atas ▲ </a></h5>

<h3  id="data-diri"><b>Panduan Asesor</b></h3>
<ul>
<li>Pengisian data diri<p><?= Html::img('@web/project-uploads/kemenkes2019/help/datadiri-awal.png', ['alt' => 'datadiri', 'width' => 600]) ?></p></li>
<ul>
<li>Tekan tombol <b>Edit</b> pada bagian <b>Data Diri</b> <p><?= Html::img('@web/project-uploads/kemenkes2019/help/edit.png', ['alt' => 'datadiri-edit', 'width' => 600]) ?></p></li>
<li>Data diri sesuaikan dengan yang tercantum dalam Lembar Kehidupan <i>assessee</i></li>
<li>Menggunakan huruf capital (huruf besar)</li>
<li>Jika ada data yang kosong, silahkan bubuhkan tanda (-) pada kotak yang dimaksud</li>
<li>Data yang sudah terisi dalam aplikasi terdiri dari Nama, Jabatan Saat ini, Golongan, Jabatan, Level, NIP, yang lainnya masih kosong. Silagkan diisi sesuai data assessee tersebut</li>
<li>Jika data telah lengkap diisi silahkan tekan tombol <b>UPDATE</b> <p><?= Html::img('@web/project-uploads/kemenkes2019/help/datadiri.png', ['alt' => 'datadiri-update', 'width' => 600]) ?></p>di bagian paling bawah laman</li>
    </ul>

<h5>▼ ---------------------------------------------------------------------------------------------------------------- ▼ <a href="#atas"> ▲ Ke Atas ▲ </a></h5>


<li id="psikogram"><b>Pengisian Psikogram</b><p><?= Html::img('@web/project-uploads/kemenkes2019/help/psikogram-kemenkes.png', ['alt' => 'psikogram', 'width' => 600]) ?></p></li>
<ul>
<li>Tekan tombol <b>Edit</b> pada bagian psikogram <p><?= Html::img('@web/images/setkab/help/psikogram-edit.png', ['alt' => 'psikogram', 'width' => 600]) ?></p>
<li>Anda hanya memilih radio button yang berisi nilai - nilai dari aspek psikologis yang ada, antara 1 - 5<p><?= Html::img('@web/project-uploads/kemenkes2019/help/skala-5.png', ['alt' => 'psikogram-radio', 'width' => 600]) ?></p></li>
<li>Jika sudah terisi semua sesuai nilai psikologisnya silahkan tekan tombol <b>UPDATE</b></li>
<li>Total skor, persentase dan kualifikasi (K2, K2, K3) akan terupdate otomatis setelah Anda menekan tombol <b>UPDATE</b></li>
    </ul>
    <li id="kompetensi">Pengisian Aspek Kompetensi<p><?= Html::img('@web/images/setkab/help/kompetensi.png', ['alt' => 'kompetensi', 'width' => 600]) ?></p></li>
    <ul>
    <li>Tekan tombol <b>Edit</b> pada setiap Aspek Kompetensi yang akan diuraikan</li>
    <li>Pilih LKI yang sesuai dengan assessee yang bersangkutan <p><?= Html::img('@web/images/setkab/help/kompetensi-lki.png', ['alt' => 'kompetensi', 'width' => 600, 'border' => 5]) ?></p></li>
    <li>Klik tombol simpan LKI untuk menampilkan LKI tersebut</li>
    <li>Lengkapi dengan memilih (klik kotak disebelah kiri) indikator dari LKI tersebut </li>
    <li>klik tunjukan usulan uraian untuk menampilkan indikator LKI tersebut ke dalam kotak uraian kamus, kemudian copy dan paste uraian kamus tersebut ke dalam kotak uraian kompetensi dibawah <p><?= Html::img('@web/images/setkab/help/kompetensi-uraian.png', ['alt' => 'kompetensi', 'border' => 5,'width' => 600]) ?></p></li>
    <li>Jika sudah selesai mengisi, simpan uraian dengan menekan tombol <b>Update Uraian</b></li>
    </ul>

<h5>▼ ---------------------------------------------------------------------------------------------------------------- ▼ <a href="#atas"> ▲ Ke Atas ▲ </a></h5>

<li id="plus-minus"><b>Pengisian Kekuatan dan Kelemahan</b></li>
<ul>
<li>Tekan tombol <?= Html::button('Edit', ['class' => 'btn btn-primary']) ?> di sebelah kanan Kekuatan dan Kelemahan</li>
<li>Terdapat Diagram kompetensi, Tabel Kompetensi (LKY, LKI, GAP dan Percentage), dan dilengkapi Nine Cell</li>
<li>Untuk mengisi uraian kekuatan silahkan tuliskan pada kotak bagian bawah<p><?= Html::img('@web/images/setkab/help/exsum-kotak.png', ['alt' => 'kekuatankelemahan', 'width' => 600]) ?></p>
<ul>
<li><b>Kekuatan</b> - <i>Hal - hal positif yang menunjang tampilnya kinerja optimal</i></li>
<li><b>Kelemahan</b> - <i>Hal - hal negatif yang menghambat tampilnya kinerja optimal</i></li>
</ul>
<li>Jika selesai mengisi uraian keduanya sila tekan tombol <b>Update</b></li>
</li>
</ul>
</ul>

<h5>▼ ---------------------------------------------------------------------------------------------------------------- ▼ <a href="#atas"> ▲ Ke Atas ▲ </a></h5>

    <li id="exsum"><b>Pengisian Executive Summary</b><p><?= Html::img('@web/images/setkab/help/exsum.png', ['alt' => 'exsum', 'border' => 5, 'width' => 600]) ?></p></li>
    <ul>
    <li>Untuk mengisi executive summary silahkan tekan tombol Edit di sebelah kanan Executive Summary</li>
    <li>Terdapat Diagram kompetensi, Tabel kompetensi (LKJ, LKI, GAP dan Percentage), dan dilengkapi Nine Cell</li>
    <li>Diagram Kompetensi dan Nine Cell ini akan terisi jika kita telah mengisi masing - masing aspek kompetensi diatas</li>
    <li>Untuk mengisi uraian Executive Summary silahkan tuliskan di kotak bagian bawah lihat gambar <p><?= Html::img('@web/images/setkab/help/exsum-kotak.png', ['alt' => 'exsum', 'width' => 600]) ?></p></li>
    <li>Jika anda selesai mengisi silahkan tekan tombol <?= Html::button('Update', ['class' => 'btn btn-primary']) ?> di bagian bawah kotak</li>
    </ul>


<h5>▼ ---------------------------------------------------------------------------------------------------------------- ▼ <a href="#atas"> ▲ Ke Atas ▲ </a></h5>

<h3 id="So-er"><b>Panduan Second Opinion</b></h3>
<ul>
<li>Laman <i>second opinion</i> ada pada menu bagian atas <p><?= Html::img('@web/images/setkab/help/so-menu.png', ['alt' => 'so', 'width' => 600]) ?></p></li>
<li>So-er akan bekerja setelah asesor melakukan <i>submit</i> laporan</li>
<li>Terdapat 2 tombol di bawah nama assessee jika laporan sudah disubmit asesor, yakni
<ul><li><b><i>Selesai direview oleh SO</i></b></li>
<li><b><i>Dikembalikan ke assessor</i></b></li>
</ul>
<li>Langkah - langkah lainnya untuk edit uraian dsb, sama dengan langkah - langkah asesor mengisi uraian</li>
</ul>


<?php




?>
