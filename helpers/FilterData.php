<?php


namespace yii2utils\helpers;


class FilterData {

    static public function baseClean($data) {
        if(!is_scalar($data)) {
            return $data;
        }
        return strip_tags(trim($data));
    }

    static public function inputFilter($data) {
        if(!is_scalar($data)) {
            return $data;
        }
        return strip_tags(trim($data));
    }

    public static function preview($text, $length, $suffix = '...', $encoding = 'UTF-8') {
        $text = strip_tags($text);
        $text = mb_substr($text, 0, $length, $encoding);
        if($suffix !== false) {
            $text = trim($text). ' '.$suffix;
        }
        return $text;
    }



}