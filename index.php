<?php
require 'vendor/autoload.php';

use afrizalmy\FAHPVikor\Base;
use afrizalmy\FAHPVikor\Fahp;


$kriteria = ["C1","C2","C3","C4"];

$base = new Base();

$bobot_perkiraan = [];
$bobot_perkiraan[0][1]=json_encode([1, 1.26, 1.52]);
$bobot_perkiraan[0][2]=json_encode([1, 1.23, 1.55]);
$bobot_perkiraan[0][3]=json_encode([0.87, 1.12, 1.43]);

$bobot_perkiraan[1][2]=json_encode([0.66, 0.85, 1.15]);
$bobot_perkiraan[1][3]=json_encode([0.87, 1.08, 1.32]);

$bobot_perkiraan[2][3]=json_encode([0.76, 1.08, 1.52]);

// var_dump($bobot_perkiraan);
$metriks = $base->data_kriteria($kriteria, $bobot_perkiraan, json_encode([1,1,1]));
// var_dump($metriks);

$fuzzy = new Fahp($metriks);

// $fuzzy->FuzzyPairWise();

var_dump($fuzzy->FuzzyPairWise());
?>