<?php
require 'vendor/autoload.php';

use afrizalmy\FAHPVikor\Base;
use afrizalmy\FAHPVikor\Fahp;

$kriteria = ["Quality","Origin","Cost","Delivery","After Sales"];

$base = new Base();

// hitung bobot kriteria
$arr_kriteria = array();
for ($i=0; $i <= count($kriteria)-1 ; $i++) { 
    $gate = 0;
    $tmpgate = $i + 1;
    for ($j=$i; $j <= count($kriteria)-1; $j++) { 
        // printf($j);
        $tmp_arr= array();
        if ($gate != 0) {
            if ($i > 0) {
                // echo $i," | ",$tmpgate, " , ";
                echo "Masukkan bobot kriteria index " ,$i," kolom ", $tmpgate, "\n";
                for ($a=0; $a < 3; $a++) { 
                    array_push($tmp_arr,trim(fgets(STDIN)));
                }
                $arr_kriteria[$i][$tmpgate] = json_encode($tmp_arr); //inputan 
                $tmpgate++;
            } else {
                echo "Masukkan bobot kriteria index " ,$i," kolom ", $gate, "\n";
                for ($a=0; $a < 3; $a++) { 
                    array_push($tmp_arr,trim(fgets(STDIN)));
                }
                $arr_kriteria[$i][$gate] = json_encode($tmp_arr); //inputan 
            }
        } 
        $gate++;
        unset($tmp_arr);
    }
    // printf("\n");
}

// var_dump($arr_kriteria);

$metriks = $base->buat_metric($kriteria, $arr_kriteria, json_encode([1,1,1]));
// var_dump($metriks);

$fuzzy = new Fahp();
$gm_kriteria = $fuzzy->HitungGeoMetricMean($fuzzy->FuzzyPairWise($metriks));
$bobot_kriteria = $fuzzy->FuzzyWeight($gm_kriteria);
var_dump($bobot_kriteria);

?>