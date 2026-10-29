<?php
require 'watermark.php';
 
$password = 'kunci-rahasia-rs';   // hanya untuk latihan
$data = '{"no_rm":"RM-2026-0001","nama":"Budi Santoso",'
      . '"diagnosis":"Hipertensi","hasil_lab":"TD 150/95"}';
file_put_contents('pasien.json', $data);
 
// Langkah 1: hash sebelum dikirim
$hash_awal = hash_file('sha256', 'pasien.json');
baris('1. Hash awal', $hash_awal);
 
// Langkah 2: enkripsi AES-256-CBC (kunci diturunkan dari kata sandi dengan PBKDF2)
$salt   = random_bytes(8);
$iv     = random_bytes(16);
$kunci  = hash_pbkdf2('sha256', $password, $salt, 10000, 32, true);
$cipher = openssl_encrypt($data, 'aes-256-cbc', $kunci, OPENSSL_RAW_DATA, $iv);
file_put_contents('pasien.enc', base64_encode($salt . $iv . $cipher));
baris('2. Ciphertext (base64)', file_get_contents('pasien.enc'));
 
// Langkah 3: dekripsi dengan kata sandi yang benar
$mentah = base64_decode(file_get_contents('pasien.enc'));
$salt2  = substr($mentah, 0, 8);
$iv2    = substr($mentah, 8, 16);
$cipher2 = substr($mentah, 24);
$kunci2 = hash_pbkdf2('sha256', $password, $salt2, 10000, 32, true);
$hasil  = openssl_decrypt($cipher2, 'aes-256-cbc', $kunci2, OPENSSL_RAW_DATA, $iv2);
baris('3. Hasil dekripsi', $hasil);
 
// Langkah 4: verifikasi keutuhan
baris('4. Hash setelah dekripsi', hash('sha256', $hasil));
echo hash('sha256', $hasil) === $hash_awal
    ? "STATUS: COCOK, berkas utuh\n" : "STATUS: TIDAK COCOK\n";
 
// Langkah 5: dekripsi dengan kata sandi SALAH
$kunci3 = hash_pbkdf2('sha256', 'kata-sandi-tebakan', $salt2, 10000, 32, true);
$gagal  = openssl_decrypt($cipher2, 'aes-256-cbc', $kunci3, OPENSSL_RAW_DATA, $iv2);
echo "\n5. Kata sandi salah: ";
echo ($gagal === $data) ? "terbuka (tidak seharusnya)\n"
                        : "GAGAL dibuka, data tetap rahasia\n";