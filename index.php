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
$metriks = $base->data_kriteria($kriteria, $bobot_perkiraan, json_encode([1,1,1]));
// var_dump($metriks);

$fuzzy = new Fahp($metriks);

// $fuzzy->FuzzyPairWise();
// echo json_encode($fuzzy->FuzzyPairWise());
// var_dump($fuzzy->FuzzyPairWise());

$fuzzy->HitungGeoMetricMean($fuzzy->FuzzyPairWise());
?>