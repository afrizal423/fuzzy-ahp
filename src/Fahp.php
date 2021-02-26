<?php

namespace afrizalmy\FAHPVikor;
use afrizalmy\FAHPVikor\Base;
use afrizalmy\FAHPVikor\Helper;
use afrizalmy\FAHPVikor\ErrorHandling;

class Fahp extends Base
{
    function __construct(array $var)
    {
        ErrorHandling::checkMatricsPairWise($var);
        $this->kriteria = $var["kriteria"];
        $this->nilai_pasti = $var["nilai_pasti"];
        $this->metrics = $var["matriks"];
    }

    public function FuzzyPairWise(array $var = null)
    {
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
        

        for ($a=0; $a < 3; $a++) {
            $arr_tot=[]; 
            for ($i=0; $i < count($this->kriteria); $i++) {
                $indeks_array=0; 
                $tmp_array=[];
                for ($j=0; $j < count($var[$i]); $j++) { 
                    # code...
                    // echo "indeks array = ",$indeks_array,"\n";
                    // if ($indeks_array == 3) {
                    //     break;
                    // }
                    // var_dump(json_decode($var[$i][$j])[0]);
                    // echo "\n";
                    for ($k=0; $k < count(json_decode($var[$i][$j])); $k++) { 
                        # code...\
                        // echo "a = ",$a,"\n";
                        // var_dump(json_decode($var[$i][$j])[$a]);
                        array_push($tmp_array, json_decode($var[$i][$j])[$a]);
                        break;
                        // echo "\n";
                    }
                   
                    // echo "spasi 1111 \n";
                    $indeks_array++;
                }
                // var_dump($tmp_array);
                echo "hasil geometric = ", Helper::Geometric_mean($tmp_array);
                array_push($arr_tot,Helper::Geometric_mean($tmp_array));
                echo "\n spasi \n";
                // echo count($var[$i]);
                
            }
            echo "hasil total =", array_sum($arr_tot);
            echo "\n spasi akhir \n";
        }
    }
}
