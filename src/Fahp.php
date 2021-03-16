<?php

namespace afrizalmy\FAHPVikor;
use afrizalmy\FAHPVikor\Base;
use afrizalmy\FAHPVikor\Helper;
use afrizalmy\FAHPVikor\ErrorHandling;

class Fahp extends Base
{
    protected $kriteria;
    protected $metrics;
    // function __construct(array $var)
    // {
    //     ErrorHandling::checkMatricsPairWise($var);
    //     $this->kriteria = $var["kriteria"];
    //     $this->nilai_pasti = $var["nilai_pasti"];
    //     $this->metrics = $var["matriks"];
    // }

    public function FuzzyPairWise(array $var = null)
    {
        $this->kriteria = $var["kriteria"];
        // $this->nilai_pasti = $var["nilai_pasti"];
        $this->metrics = $var["matriks"];
        for ($i=0; $i <= count($this->kriteria)-1 ; $i++) {
            $gate = 0;
            for ($j=0; $j < $i; $j++) { 
                // echo "$i | $gate"; // ini masuk hasil pair wise
                // echo "$gate | $i"; // ini kebalikan dari matriks, utk mencari nilai max, average, min
                $this->metrics[$i][$gate] = json_encode($this->GetMaxMedMin(json_decode($this->metrics[$gate][$i])));
                $gate++;
            }
            // echo "\n";
        }

        return $this->metrics;
    }

    protected function GetMaxMedMin($var)
    {
        $hasil = [];
        $hasil[0] = 1 / Helper::FindMax($var);
        $hasil[1] = 1 / Helper::FindMedian($var);
        $hasil[2] = 1 / Helper::FindMin($var);
        return $hasil;
    }

    public function HitungGeoMetricMean(array $var = null)
    {
        // var_dump($var);
        $hasil=[];
        $tmp_Increasing=[];
        for ($a=0; $a < 3; $a++) {
            $arr_tot=[]; 
            for ($i=0; $i < count($this->kriteria); $i++) {
                $tmp_array=[];
                for ($j=0; $j < count($var[$i]); $j++) { 
                    for ($k=0; $k < count(json_decode($var[$i][$j])); $k++) { 
                        # code...\
                        // var_dump(json_decode($var[$i][$j])[$a]);
                        array_push($tmp_array, json_decode($var[$i][$j])[$a]);
                        break;
                    }
                }
                $hasil["nilai"][$a][$i] = Helper::Geometric_mean($tmp_array);
                array_push($arr_tot,Helper::Geometric_mean($tmp_array));
                
            }
            $hasil["total"][$a] = array_sum($arr_tot);
            array_push($tmp_Increasing,1/array_sum($arr_tot));
            $hasil["reverse"][$a] = 1/array_sum($arr_tot);

        }
        $hasil["increase"]["min"] = Helper::FindMin($tmp_Increasing);
        $hasil["increase"]["med"] = Helper::FindMedian($tmp_Increasing);
        $hasil["increase"]["max"] = Helper::FindMax($tmp_Increasing);

        // var_dump($hasil);
        return $hasil;
    }

    public function FuzzyWeight(array $var)
    {
        ErrorHandling::checkArrayGM($var);
        // var_dump($var);
        $tmp_array=[];
        for ($a=0; $a < 3; $a++) {
            for ($i=0; $i < count($this->kriteria); $i++) {
                // var_dump($var["nilai"][$a][$i]);
                if ($a == 0) {
                    $tmp_array[$a][$i] = $var["nilai"][$a][$i] * $var["increase"]["min"];
                }
                if ($a == 1) {
                    $tmp_array[$a][$i] = $var["nilai"][$a][$i] * $var["increase"]["med"];
                }
                if ($a == 2) {
                    $tmp_array[$a][$i] = $var["nilai"][$a][$i] * $var["increase"]["max"];
                }
            }
        }
        // var_dump($tmp_array);

        /**
         * 
         *  PERHITUNGAN Mi
         * 
         */
        $arr_mi = [];
        for ($i=0; $i < count($this->kriteria); $i++) {
            $tmp_mi = [];
            for ($k=0; $k < 3; $k++) { 
                $tmp_mi[$i][$k] = $tmp_array[$k][$i];
            }
            $arr_mi[$i] = array_sum($tmp_mi[$i])/count($tmp_mi[$i]);

        }
        // var_dump($arr_mi);
        $mi_total = array_sum($arr_mi);

         /**
         * 
         *  PERHITUNGAN Normalized
         * 
         */
        $arr_normalized = [];
        for ($i=0; $i < count($this->kriteria); $i++) {
            $arr_normalized[$i] = $arr_mi[$i] / $mi_total;
        }
        $normalized_total = array_sum($arr_normalized);
        if ($normalized_total > 1) {
            throw new \InvalidArgumentException('Hasil tidak boleh lebih dari 1! Silahkan input ulang.');
        }
        // echo $normalized_total;
        return $arr_normalized;
    }
}
