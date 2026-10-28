<?php
/**
 * DEMO ENKRIPSI PHP
 * Mata Kuliah: Keamanan dan Perlindungan Data
 * Algoritma: AES-256-CBC
 * Tujuan: Memahami proses enkripsi dan dekripsi.
 */

// ==========================
// 1. DATA ASLI (PLAINTEXT)
// ==========================
$dataAsli = json_encode([
    "nama" => "Budi Santoso",
    "no_rm" => "RM001234",
    "diagnosis" => "Demonstrasi Praktikum"
], JSON_PRETTY_PRINT);

// ==========================
// 2. KUNCI RAHASIA
// ==========================
// Pada dunia nyata, kunci disimpan dengan aman.
$secretKey = "PraktikumD3RMIK2026";

// Ubah menjadi kunci 32 byte
$key = hash('sha256', $secretKey, true);

// IV harus selalu acak setiap enkripsi
$iv = random_bytes(16);

// ==========================
// 3. ENKRIPSI
// ==========================
$ciphertext = openssl_encrypt(
    $dataAsli,
    'AES-256-CBC',
    $key,
    OPENSSL_RAW_DATA,
    $iv
);

// Gabungkan IV + Ciphertext
$hasilEnkripsi = base64_encode($iv . $ciphertext);

// ==========================
// 4. DEKRIPSI
// ==========================
$dataGabungan = base64_decode($hasilEnkripsi);

$ivTerima = substr($dataGabungan, 0, 16);
$ciphertextTerima = substr($dataGabungan, 16);

$hasilDekripsi = openssl_decrypt(
    $ciphertextTerima,
    'AES-256-CBC',
    $key,
    OPENSSL_RAW_DATA,
    $ivTerima
);

// ==========================
// 5. UJI KUNCI YANG SALAH
// ==========================
$keySalah = hash('sha256', 'KunciYangSalah', true);

$dekripsiSalah = openssl_decrypt(
    $ciphertextTerima,
    'AES-256-CBC',
    $keySalah,
    OPENSSL_RAW_DATA,
    $ivTerima
);

// ==========================
// TAMPILKAN HASIL
// ==========================
echo "=====================================<br>";
echo " DEMO ENKRIPSI AES-256-CBC DI PHP<br>";
echo "=====================================<br><br>";

echo "1. DATA ASLI (PLAINTEXT)<br>";
echo "-------------------------<br>";
echo $dataAsli . "<br><br>";

echo "2. HASIL ENKRIPSI (CIPHERTEXT)<br>";
echo "-------------------------------<br>";
echo $hasilEnkripsi . "<br><br>";

echo "3. HASIL DEKRIPSI<br>";
echo "-----------------<br>";
echo $hasilDekripsi . "<br><br>";

echo "4. UJI KUNCI SALAH<br>";
echo "------------------<br>";

if ($dekripsiSalah === false) {
    echo "Dekripsi gagal karena menggunakan kunci yang salah.<br>";
} else {
    echo $dekripsiSalah . "<br>";
}

echo "<br>=====================================<br>";
echo "KESIMPULAN<br>";
echo "=====================================<br>";
echo "- Data asli dapat dibaca manusia.<br>";
echo "- Setelah dienkripsi menjadi ciphertext.<br>";
echo "- Ciphertext hanya dapat dibuka dengan kunci yang benar.<br>";
echo "- Kunci yang salah menyebabkan dekripsi gagal.<br>";