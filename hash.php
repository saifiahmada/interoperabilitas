<?php
// SIMULASI PEMBELAJARAN — seluruh data bersifat fiktif.
$payloadKirim = [
    "resourceType" => "Observation",
    "status" => "final",
    "code" => "Gula darah sewaktu",
    "value" => 110,
    "unit" => "mg/dL"
];

// Simulasi data yang diterima; ubah 110 menjadi 410 untuk uji.
$payloadTerima = [
    "resourceType" => "Observation",
    "status" => "final",
    "code" => "Gula darah sewaktu",
    //"value" => 110,
    "value" => 110,
    "unit" => "mg/dL"
];

$kirim = json_encode($payloadKirim, JSON_UNESCAPED_UNICODE);
$terima = json_encode($payloadTerima, JSON_UNESCAPED_UNICODE);

$hashKirim = hash("sha256", $kirim);
$hashTerima = hash("sha256", $terima);

echo "Hash data kirim  : " . $hashKirim . PHP_EOL;
echo "<br>";
echo "Hash data terima : " . $hashTerima . PHP_EOL;
echo "<br>";
echo "Integritas utuh? : ";
echo hash_equals($hashKirim, $hashTerima) ? "YA" : "TIDAK";
echo PHP_EOL;
?>