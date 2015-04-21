<?php


namespace yii2utils\core\helpers;

use Yii;

class I18n {

    public static $category = 'app';

    public static function t($message, $params = [], $language = null) {
        return Yii::t(self::$category, $message, $params, $language);
    }

    public static function setCategory($name) {
        self::$category = $name;
    }



}