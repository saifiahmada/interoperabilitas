<?php
require 'watermark.php';
 
echo "== 1. SHA-256 nomor rekam medis (data fiktif) ==\n";
baris('RM-2026-0001', hash('sha256', 'RM-2026-0001'));
baris('RM-2026-0002', hash('sha256', 'RM-2026-0002'));
 
echo "\n== 2. Cek keutuhan hasil lab ==\n";
$asli   = '{"no_rm":"RM-000123","hasil":126,"satuan":"mg/dL"}';
$diubah = '{"no_rm":"RM-000123","hasil":216,"satuan":"mg/dL"}';
$hash_asli   = hash('sha256', $asli);
$hash_diubah = hash('sha256', $diubah);
baris('Hash asli  ', $hash_asli);
baris('Hash diubah', $hash_diubah);
echo hash_equals($hash_asli, $hash_diubah)
    ? "STATUS: data UTUH\n"
    : "STATUS: data BERUBAH (integritas rusak)\n";
 
echo "\n== 3. HMAC-SHA256 (hash + kunci rahasia) ==\n";
$pesan = 'Diagnosis: Hipertensi';
baris('HMAC kunci benar', hash_hmac('sha256', $pesan, 'kunci-rahasia-rs'));
baris('HMAC kunci salah', hash_hmac('sha256', $pesan, 'kunci-tebakan'));