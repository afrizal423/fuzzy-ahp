<?php

namespace afrizalmy\FAHPVikor;
use afrizalmy\FAHPVikor\Base;

class Helper extends Base{

    public static function FindMax(array $var)
    {
        return max($var);
    }
    public static function FindMedian($arr) {
        $count = count($arr); //total numbers in array
        $middleval = floor(($count-1)/2); // find the middle value, or the lowest middle value
        if($count % 2) { // odd number, middle is the median
            $median = $arr[$middleval];
        } else { // even number, calculate avg of 2 medians
            $low = $arr[$middleval];
            $high = $arr[$middleval+1];
            $median = (($low+$high)/2);
        }
        return $median;
    }

    public static function FindMin(array $var)
    {
        return min($var);
    }

    public static function Geometric_mean(array $a)
    {
        array_walk($a, function (&$i) {
            $i = log($i);
        });
        return exp(array_sum($a)/count($a));
    }

}