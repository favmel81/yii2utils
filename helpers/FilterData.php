<?php


namespace yii2utils\helpers;


class FilterData {

    const SPLIT_PATTERN = '|\s+|';
    const DEFAULT_TRIM_CHARS = " \t\n\r\0\x0B";

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

    public static function pregSplit($str, $pattern = self::SPLIT_PATTERN, $trimChars = null) {
        $res = [];
        $trimChars = self::DEFAULT_TRIM_CHARS . ($trimChars?$trimChars:'');
        $str = preg_split($pattern, $str);
            foreach($str as $chunk) {
                $chunk = trim($chunk, $trimChars);
                if(!empty($chunk)) {
                    $res[] = $chunk;
                }
            }
        return array_unique($res);
    }



}