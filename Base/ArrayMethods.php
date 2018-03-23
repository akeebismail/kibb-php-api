<?php
/**
 * Created by PhpStorm.
 * User: kibb
 * Date: 3/23/18
 * Time: 5:07 PM
 */
namespace Kibb\Base;
class ArrayMethods{
    private function __construct()
    {
    }

    private function __clone()
    {

    }
    public static function clean($array){
        return array_filter($array, function ($item){
            return !empty($item);
        });
    }

    public static function trim($array){
        return array_map(function ($item){
            return trim($item);
        }, $array);
    }
}