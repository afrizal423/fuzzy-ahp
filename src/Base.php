<?php

namespace afrizalmy\FAHPVikor;

class Base
{

    protected $kriteria = [];
    protected $nilai_pasti;
    protected $metrics = [];

    private function create_matric(array $data){
        // $this->nilai_pasti = json_encode([1,1,1]);
        $pair_wise = array();
        for ($i=0; $i <= count($this->kriteria)-1 ; $i++) { 
            $gate = 0;
            $tmpgate = $i + 1;
            for ($j=$i; $j <= count($this->kriteria)-1; $j++) { 
                // printf($j);
                if ($gate == 0) {
                    $pair_wise[$i][$i] = $this->nilai_pasti;
                } else {
                    if ($i > 0) {
                        // echo $i," | ",$tmpgate, " , ";
                        $pair_wise[$i][$tmpgate] = $data[$i][$tmpgate];
                        $tmpgate++;
                    } else {
                        $pair_wise[$i][$gate] = $data[$i][$gate];
                    }
                }
                $gate++;
                
            }
            // printf("\n");
        }
        $this->metrics = $pair_wise;
        return $this->metrics;
    }

    public function data_kriteria(array $inputan, array $data_array, $nilai)
    {
        $this->kriteria = $inputan;
        $this->sum_kriteria = count($inputan);
        $this->nilai_pasti = $nilai;
        $array_kosong = $this->create_matric($data_array);
        $parsing = [];
        $parsing["kriteria"] = $this->kriteria;
        $parsing["nilai_pasti"] = $this->nilai_pasti;
        $parsing["matriks"] = $this->metrics;
        // var_dump($parsing);
        return $parsing;
    }

    public function FuzzyPairWise(array $var = null)
    {
        if ($var == null) {
            # ERROR HANDLING
        }
        // var_dump($var);
        for ($i=0; $i <= count($this->kriteria)-1 ; $i++) { 
            for ($j=$i; $j <= count($this->kriteria)-1; $j++) { 
            }
        }

        

        return $var;
    }
}