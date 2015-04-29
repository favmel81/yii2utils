<?php


namespace yii2utils\extjs;


class Helpers {

    public static function extractFormErrors($errors) {
        $result = [];
        if(is_array($errors) && sizeof($errors)) {
            foreach($errors as $field => $error) {
                if(is_array($error) && isset($error[0])) {
                    $result[] = ['id' => $field, 'msg' => $error[0]];
                }
            }

        }
        return $result;
    }

}