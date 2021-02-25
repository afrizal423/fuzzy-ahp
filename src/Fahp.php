<?php

namespace afrizalmy\FAHPVikor;
use afrizalmy\FAHPVikor\Base;
use afrizalmy\FAHPVikor\Helper;

class Fahp extends Base
{
    function __construct(array $var)
    {
        $this->kriteria = $var["kriteria"];
        $this->nilai_pasti = $var["nilai_pasti"];
        $this->metrics = $var["matriks"];
    }

    public function FuzzyPairWise(array $var = null)
    {
        if ($var == null) {
            # ERROR HANDLING
        }
        // var_dump($this->kriteria);
        for ($i=0; $i <= count($this->kriteria)-1 ; $i++) {
            $gate = 0;
            $tmpgate = $i + 1; 
            for ($j=0; $j < $i; $j++) { 
                // echo "$i | $gate"; // ini masuk hasil pair wise
                // echo "$gate | $i"; // ini kebalikan dari matriks, utk mencari nilai max, average, min
                $this->metrics[$i][$gate] = $this->GetMaxMedMin(json_decode($this->metrics[$gate][$i]));
                $gate++;
            }
            for ($j=$i; $j <= count($this->kriteria)-1; $j++) { 
                // echo "+ $j +";
            }
            echo "\n";
        }

        

        return $this->metrics;
    }

    protected function GetMaxMedMin($var)
    {
        $hasil = [];
        $hasil[0] = 1 / Helper::FindMax($var);
        $hasil[1] = 1 / Helper::FindMedian($var);
        $hasil[2] = 1 / Helper::FindMin($var);
        // var_dump($hasil);
        // echo json_encode($hasil);
        // echo "\nstop\n";
        return json_encode($hasil);
    }
}
