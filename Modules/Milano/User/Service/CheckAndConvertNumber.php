<?php

namespace Milano\User\Service;

class CheckAndConvertNumber
{
    public static function CheckNationalCodeNum($code){
        $code = self::ConvertPerNumToEn($code);
        if(!preg_match('/^[0-9]{10}$/',$code))
            return false;
        for($i=0;$i<10;$i++)
            if(preg_match('/^'.$i.'{10}$/',$code))
                return false;
        for($i=0,$sum=0;$i<9;$i++)
            $sum+=((10-$i)*intval(substr($code, $i,1)));
        $ret=$sum%11;
        $parity=intval(substr($code, 9,1));
        if(($ret<2 && $ret==$parity) || ($ret>=2 && $ret==11-$parity))
            return true;
        return false;
    }

    public static function ConvertPerNumToEn($string) {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $arabic = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];

        $num = range(0, 9);
        $convertedPersianNums = str_replace($persian, $num, $string);
        $englishNumbersOnly = str_replace($arabic, $num, $convertedPersianNums);

        return $englishNumbersOnly;
    }

    public static function CheckMobileNumber($value){
        $value = self::ConvertPerNumToEn($value);
        if (substr($value, 0, 2) == '09'){ if (strlen($value) == 11){return true;} }
        else if (substr($value, 0, 2) == '+98'){ if (strlen($value) == 13){return true;} }
        else if (substr($value, 0, 2) == '98'){ if (strlen($value) == 12){return true;} }
        return false;
    }
}
