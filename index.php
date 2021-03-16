<?php
require 'vendor/autoload.php';

use afrizalmy\FAHPVikor\Base;
use afrizalmy\FAHPVikor\Fahp;

header('Content-Type: application/json');


$kriteria = ["Quality","Origin","Cost","Delivery","After Sales"];

$base = new Base();

$bobot_perkiraan = [];
$bobot_perkiraan[0][1]=json_encode([1, 1, 1]);
$bobot_perkiraan[0][2]=json_encode([4, 5, 6]);
$bobot_perkiraan[0][3]=json_encode([6, 7, 8]);
$bobot_perkiraan[0][4]=json_encode([4, 5, 6]);

$bobot_perkiraan[1][2]=json_encode([4, 5, 6]);
$bobot_perkiraan[1][3]=json_encode([6, 7, 8]);
$bobot_perkiraan[1][4]=json_encode([6, 7, 8]);

$bobot_perkiraan[2][3]=json_encode([1/4, 1/3, 1/2]);
$bobot_perkiraan[2][4]=json_encode([2, 3, 4]);

$bobot_perkiraan[3][4]=json_encode([1/6, 1/5, 1/4]);

// var_dump($bobot_perkiraan);
$metriks = $base->buat_metric($kriteria, $bobot_perkiraan, json_encode([1,1,1]));
// var_dump($metriks);

$fuzzy = new Fahp();
$gm_kriteria = $fuzzy->HitungGeoMetricMean($fuzzy->FuzzyPairWise($metriks));
$bobot_kriteria = $fuzzy->FuzzyWeight($gm_kriteria);

$kandidat_ke_quality = [];
$kandidat_ke_quality[0][1]=json_encode([1, 1, 1]);
$kandidat_ke_quality[0][2]=json_encode([2, 6, 6]);
$kandidat_ke_quality[0][3]=json_encode([2, 3, 3]);
$kandidat_ke_quality[0][4]=json_encode([2, 5, 2]);

$kandidat_ke_quality[1][2]=json_encode([9, 7, 8]);
$kandidat_ke_quality[1][3]=json_encode([3, 3, 2]);
$kandidat_ke_quality[1][4]=json_encode([2, 2, 2]);

$kandidat_ke_quality[2][3]=json_encode([1/4, 1/3, 1/2]);
$kandidat_ke_quality[2][4]=json_encode([2, 3, 4]);

$kandidat_ke_quality[3][4]=json_encode([1/6, 1/5, 1/4]);

// var_dump($bobot_perkiraan);
$kandidat = ["P1","P2","P3","P4","P5"];
$metriks_QUALITY = $base->buat_metric($kandidat, $kandidat_ke_quality, json_encode([1,1,1]));
$q_kriteria = $fuzzy->HitungGeoMetricMean($fuzzy->FuzzyPairWise($metriks_QUALITY));
$bobot_q = $fuzzy->FuzzyWeight($q_kriteria);
var_dump($bobot_q);
?>