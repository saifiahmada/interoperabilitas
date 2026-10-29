<?php
// GANTI dengan nama dan NIM Anda. Tampil sebagai watermark di semua halaman.
$nama = "NAMA LENGKAP - NIM";
 
echo '<style>body{font-family:Arial;margin:20px}
.wm{position:fixed;top:35%;left:5%;font-size:46px;color:rgba(0,0,0,.13);
transform:rotate(-20deg);z-index:9;pointer-events:none}</style>';
echo "<div class='wm'>$nama</div>";
echo "<h3>Praktikum Pertukaran Informasi Kesehatan - $nama</h3><pre>";
 
function baris($label, $isi) {
    echo htmlspecialchars("$label: $isi") . "\n";
}