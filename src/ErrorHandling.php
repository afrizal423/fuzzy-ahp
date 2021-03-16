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

    public static function checkArrayGM($var)
    {
        if (!$var["nilai"]) {
            throw new \InvalidArgumentException('ARRAY Nilai HARUS TERISI !!!!!');
        }
        if (!$var["total"]) {
            throw new \InvalidArgumentException('ARRAY total HARUS TERISI !!!!!');
        }
        if (!$var["reverse"]) {
            throw new \InvalidArgumentException('ARRAY reverse HARUS TERISI !!!!!');
        }
        if (!$var["increase"]) {
            throw new \InvalidArgumentException('ARRAY increase HARUS TERISI !!!!!');
        }
    }
}
