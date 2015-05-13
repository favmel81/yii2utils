<?php


namespace yii2utils\web;


trait InitActiveRecordFormTrait {

    public static function initData($attributes, $keyFieldName = 'id') {
        $id = isset($attributes[$keyFieldName])?(int)$attributes[$keyFieldName]:null;
        if($id) {
            $data = self::findOne($id);
            if(!$data) {
                throw new \Exception('The item with field '.$keyFieldName.' = '.$id .' is not found !');
            }
        } else {
            $data = new self();
        }
        $data->setAttributes($attributes, false);
        return $data;
    }

}