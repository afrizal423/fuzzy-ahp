<?php

namespace afrizalmy\FAHPVikor;
use afrizalmy\FAHPVikor\Base;

class ErrorHandling extends Base
{
    public static function checkMatricsPairWise($var)
    {
        if (!$var["matriks"]) {
            throw new \InvalidArgumentException('MATRIKS Pair Wise HARUS TERISI !!!!!');
        }
    }
}
