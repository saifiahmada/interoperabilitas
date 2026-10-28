<?php
// Payload JSON fiktif untuk latihan lokal.
$json = '{
  "resourceType": "Observation",
  "status": "final",
  "code": "Gula darah sewaktu",
  "value": 110,
  "unit": "mg/dL"
}';

$data = json_decode($json, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    exit("JSON tidak valid: " . json_last_error_msg() . PHP_EOL);
}

$fieldWajib = ["resourceType", "status", "code", "value", "unit"];
$kurang = [];

foreach ($fieldWajib as $field) {
    if (!array_key_exists($field, $data)) {
        $kurang[] = $field;
    }
}

if ($data["resourceType"] !== "Observation") {
    $kurang[] = "resourceType harus Observation";
}

if (count($kurang) === 0) {
    echo "Struktur dasar valid untuk simulasi." . PHP_EOL;
} else {
    echo "Perlu diperbaiki: " . implode(", ", $kurang) . PHP_EOL;
}
?>