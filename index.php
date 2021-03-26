<?php
require 'vendor/autoload.php';

use afrizalmy\FAHPVikor\Base;
use afrizalmy\FAHPVikor\Fahp;

header('Content-Type: application/json');


$kriteria = ["Quality","Origin","Cost","Delivery","After Sales"];
$jumlah_alternatif = 5;
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

/**
 * 
 * Hitung tiap kandidat sesuai dengan kriteria
 * 
 */

$kandidat = ["P1","P2","P3","P4","P5"];

// perhitungan kandidat dengan kriteria quality

$kandidat_ke_quality = [];
$kandidat_ke_quality[0][1]=json_encode([1, 1, 1]);
$kandidat_ke_quality[0][2]=json_encode([4, 5, 6]);
$kandidat_ke_quality[0][3]=json_encode([6, 7, 8]);
$kandidat_ke_quality[0][4]=json_encode([4, 5, 6]);

$kandidat_ke_quality[1][2]=json_encode([4, 5, 6]);
$kandidat_ke_quality[1][3]=json_encode([6, 7, 8]);
$kandidat_ke_quality[1][4]=json_encode([6, 7, 8]);

$kandidat_ke_quality[2][3]=json_encode([1/4, 1/3, 1/2]);
$kandidat_ke_quality[2][4]=json_encode([2, 3, 4]);

$kandidat_ke_quality[3][4]=json_encode([1/6, 1/5, 1/4]);

$metriks_QUALITY = $base->buat_metric($kandidat, $kandidat_ke_quality, json_encode([1,1,1]));
$q_kriteria = $fuzzy->HitungGeoMetricMean($fuzzy->FuzzyPairWise($metriks_QUALITY));
$bobot_q = $fuzzy->FuzzyWeight($q_kriteria);
// var_dump($bobot_q);


// perhitungan kandidat dengan kriteria origin

$kandidat_ke_origin = [];
$kandidat_ke_origin[0][1]=json_encode([1, 1, 1]);
$kandidat_ke_origin[0][2]=json_encode([4, 5, 6]);
$kandidat_ke_origin[0][3]=json_encode([6, 7, 8]);
$kandidat_ke_origin[0][4]=json_encode([4, 5, 6]);

$kandidat_ke_origin[1][2]=json_encode([4, 5, 6]);
$kandidat_ke_origin[1][3]=json_encode([6, 7, 8]);
$kandidat_ke_origin[1][4]=json_encode([6, 7, 8]);

$kandidat_ke_origin[2][3]=json_encode([1/4, 1/3, 1/2]);
$kandidat_ke_origin[2][4]=json_encode([2, 3, 4]);

$kandidat_ke_origin[3][4]=json_encode([1/6, 1/5, 1/4]);

$matrix_ORIGIN = $base->buat_metric($kandidat, $kandidat_ke_origin, json_encode([1,1,1]));
$origin_kriteria = $fuzzy->HitungGeoMetricMean($fuzzy->FuzzyPairWise($matrix_ORIGIN));
$bobot_origin = $fuzzy->FuzzyWeight($origin_kriteria);
// var_dump($bobot_origin);


// perhitungan kandidat dengan kriteria cost

$kandidat_ke_cost = [];
$kandidat_ke_cost[0][1]=json_encode([1, 1, 1]);
$kandidat_ke_cost[0][2]=json_encode([4, 5, 6]);
$kandidat_ke_cost[0][3]=json_encode([6, 7, 8]);
$kandidat_ke_cost[0][4]=json_encode([4, 5, 6]);

$kandidat_ke_cost[1][2]=json_encode([4, 5, 6]);
$kandidat_ke_cost[1][3]=json_encode([6, 7, 8]);
$kandidat_ke_cost[1][4]=json_encode([6, 7, 8]);

$kandidat_ke_cost[2][3]=json_encode([1/4, 1/3, 1/2]);
$kandidat_ke_cost[2][4]=json_encode([2, 3, 4]);

$kandidat_ke_cost[3][4]=json_encode([1/6, 1/5, 1/4]);

$matrix_COST = $base->buat_metric($kandidat, $kandidat_ke_cost, json_encode([1,1,1]));
$cost_kriteria = $fuzzy->HitungGeoMetricMean($fuzzy->FuzzyPairWise($matrix_COST));
$bobot_cost = $fuzzy->FuzzyWeight($cost_kriteria);
// var_dump($bobot_cost);


// perhitungan kandidat dengan kriteria delivery

$kandidat_ke_delivery = [];
$kandidat_ke_delivery[0][1]=json_encode([1, 1, 1]);
$kandidat_ke_delivery[0][2]=json_encode([4, 5, 6]);
$kandidat_ke_delivery[0][3]=json_encode([6, 7, 8]);
$kandidat_ke_delivery[0][4]=json_encode([4, 5, 6]);

$kandidat_ke_delivery[1][2]=json_encode([4, 5, 6]);
$kandidat_ke_delivery[1][3]=json_encode([6, 7, 8]);
$kandidat_ke_delivery[1][4]=json_encode([6, 7, 8]);

$kandidat_ke_delivery[2][3]=json_encode([1/4, 1/3, 1/2]);
$kandidat_ke_delivery[2][4]=json_encode([2, 3, 4]);

$kandidat_ke_delivery[3][4]=json_encode([1/6, 1/5, 1/4]);

$matrix_DELIVERY = $base->buat_metric($kandidat, $kandidat_ke_delivery, json_encode([1,1,1]));
$delivery_kriteria = $fuzzy->HitungGeoMetricMean($fuzzy->FuzzyPairWise($matrix_DELIVERY));
$bobot_delivery = $fuzzy->FuzzyWeight($delivery_kriteria);
// var_dump($bobot_delivery);

// perhitungan kandidat dengan kriteria after sales

$kandidat_ke_afterSales = [];
$kandidat_ke_afterSales[0][1]=json_encode([1, 1, 1]);
$kandidat_ke_afterSales[0][2]=json_encode([4, 5, 6]);
$kandidat_ke_afterSales[0][3]=json_encode([6, 7, 8]);
$kandidat_ke_afterSales[0][4]=json_encode([4, 5, 6]);

$kandidat_ke_afterSales[1][2]=json_encode([4, 5, 6]);
$kandidat_ke_afterSales[1][3]=json_encode([6, 7, 8]);
$kandidat_ke_afterSales[1][4]=json_encode([6, 7, 8]);

$kandidat_ke_afterSales[2][3]=json_encode([1/4, 1/3, 1/2]);
$kandidat_ke_afterSales[2][4]=json_encode([2, 3, 4]);

$kandidat_ke_afterSales[3][4]=json_encode([1/6, 1/5, 1/4]);

$matrix_AFSAl = $base->buat_metric($kandidat, $kandidat_ke_afterSales, json_encode([1,1,1]));
$afterSales_kriteria = $fuzzy->HitungGeoMetricMean($fuzzy->FuzzyPairWise($matrix_AFSAl));
$bobot_afterSales = $fuzzy->FuzzyWeight($afterSales_kriteria);
// var_dump($bobot_afterSales);

$tampung_bobot = array(
    "bobot_kriteria" => $bobot_kriteria,
    "bobot_alternatif" => array(
        $bobot_q,
        $bobot_origin,
        $bobot_cost,
        $bobot_delivery,
        $bobot_afterSales,
    )
);

// var_dump($tampung_bobot);


$hasil_akhir = Fahp::HitungSemuaBobot($kriteria, $tampung_bobot, $kandidat);
echo json_encode($hasil_akhir);
?>