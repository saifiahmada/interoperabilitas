<?php
require 'watermark.php';
 
// Pendaftaran akun: simpan HASH kata sandi + salt, bukan kata sandinya
$salt   = random_bytes(16);
$simpan = hash_pbkdf2('sha256', 'Sandi!Rahasia123', $salt, 100000, 64);
baris('Hash tersimpan di database', $simpan);
 
// Fungsi login: hitung hash dari sandi yang diketik, lalu bandingkan
function login($sandi, $salt, $simpan) {
    $coba = hash_pbkdf2('sha256', $sandi, $salt, 100000, 64);
    return hash_equals($simpan, $coba);
}
echo "\n== Uji authentication ==\n";
foreach (['Sandi!Rahasia123', 'sandi123'] as $sandi) {
    echo login($sandi, $salt, $simpan)
        ? "Login '$sandi' : 200 OK (identitas terbukti)\n"
        : "Login '$sandi' : 401 Unauthorized (identitas ditolak)\n";
}
 
// Uji authorization: hak akses berbasis peran
$hak = ['dokter' => ['hasil_lab', 'resume'], 'kasir' => ['tagihan']];
echo "\n== Uji authorization ==\n";
foreach ([['dokter', 'hasil_lab'], ['kasir', 'hasil_lab']] as [$peran, $data]) {
    echo in_array($data, $hak[$peran])
        ? "$peran membuka $data : 200 OK\n"
        : "$peran membuka $data : 403 Forbidden (tidak punya izin)\n";
}