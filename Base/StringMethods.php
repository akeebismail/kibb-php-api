<?php
/**
 * Created by PhpStorm.
 * User: kibb
 * Date: 3/23/18
 * Time: 4:57 PM
 */

namespace Kibb\Base;

class StringMethods{
    private static $_delimeter = "#";
    private function __construct()
    {
    }
    private function __clone()
    {
    }

    public static function _normalize($pattern){
        return self::$_delimeter.trim($pattern, self::$_delimeter).self::$_delimeter;
    }

    public static function getDelimeter(){
        return self::$_delimeter;
    }
    public static function setDelimeter($delimeter){
        self::$_delimeter = $delimeter;
    }

    public static function match($string, $pattern){
        preg_match_all(self::_normalize($pattern), $string,$matches,PREG_PATTERN_ORDER);

        if (!empty($matches[1])){
            return $matches[1];
        }
        if (!empty($matches[0])){
            return $matches[0];
        }

        return null;
    }

    public static function split($string, $pattern, $limit= null){
        $flags = PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE;
        return preg_split(self::_normalize($pattern),$string, $limit, $flags);
    }
}