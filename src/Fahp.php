<?php

namespace afrizalmy\FAHP;
use afrizalmy\FAHP\Base;
use afrizalmy\FAHP\Helper;
use afrizalmy\FAHP\ErrorHandling;

class Fahp extends Base
{
    protected $kriteria;
    protected $metrics;

    /**
     * Fungsi ini untuk menghitung fuzzy pair wise.
     * 
     * @param  array  $var adalah data array matriks dari langkah pembuatan matriks
     * 
     * @return array berupa array yang didalamnya terdapat data matriks tadi.
     */
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

    /**
     * Fungsi ini untuk menghitung geometric mean.
     * Silahkan lihat https://blog.pluang.com/cerdascuan/geometric-mean-adalah/
     * 
     * @param  array  $var adalah data array matriks dari langkah perhitungan FuzzyPairWise
     * 
     * @return array berupa array object seperti increase yang dimana memiliki object lagi seperti min, med, dan max
     */
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
    /**
    * Fungsi ini untuk menghitung bobot.
    * 
    * @param  array  $var adalah data array matriks dari langkah perhitungan geometricmean
    * 
    * @return array berupa array yang didalamnya adalah bobot setiap kriteria.
    */
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

    /**
    * Fungsi ini untuk menghitung semua bobot dari kriteria maupun tiap-tiap alternatif.
    * 
    * @param  array  $kriteria adalah data kriteria
    * @param  array  $arr adalah berupa array object seperti bobot_kriteria dan bobot_alternatif
    * @param  array  $alternatif adalah data alternatif

    * @return array berupa array object seperti array_bobot, best_alternatif dan worst_alternatif
    */
    public static function HitungSemuaBobot($kriteria, $arr, $alternatif)
    {
        ErrorHandling::checkHitungSemuaBobot($arr);
        /**
         * proses normalisasi matrix sesuai alternatif
         */
        $arr_alternatif=[];
        for ($i=0; $i < count($alternatif); $i++) { 
            $tmp=[];
            // $arr_alternatif[$i] = $arr["bobot_alternatif"][$i][$i];
            for ($j=0; $j < count($alternatif); $j++) { 
                // echo $arr["bobot_alternatif"][$i][$i];
                array_push($tmp,$arr["bobot_alternatif"][$i][$i]);
            }
            array_push($arr_alternatif,$tmp);
            unset($tmp);
        }
        // var_dump($arr_alternatif);

        /**
         * perhitungan bobot
         */
        $arr_hasil=[];
        for ($i=0; $i < count($kriteria); $i++) { 
            $tmp=[];
            for ($j=0; $j < count($alternatif); $j++) { 
                $tmp[$i][$j] = $arr["bobot_kriteria"][$j] * $arr_alternatif[$i][$j];
            }
            $arr_hasil[$i] = array_sum($tmp[$i]);
        }
        // var_dump($arr_hasil);

        $max = Helper::FindMaxIndex($arr_hasil); 
        $min = Helper::FindMinIndex($arr_hasil);
        $hasil_akhir=[];
        $hasil_akhir["array_bobot"] = $arr_hasil;
        $hasil_akhir["best_alternatif"] = array($alternatif[$max[0]] => $arr_hasil[$max[0]]);
        $hasil_akhir["worst_alternatif"] = array($alternatif[$min[0]] => $arr_hasil[$min[0]]);
        // var_dump($hasil_akhir);
        return $hasil_akhir;
    }
}
