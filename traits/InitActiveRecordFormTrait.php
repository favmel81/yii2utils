<?php


namespace yii2utils\traits;


trait InitActiveRecordFormTrait {

    public static function initData($attributes, $keyFieldName = 'id', $createNewEntityIfException = false) {
        $id = isset($attributes[$keyFieldName])?(int)$attributes[$keyFieldName]:null;
        $data = null;
        if($id) {
            $data = self::findOne([$keyFieldName => $id]);
            if(!$data && !$createNewEntityIfException) {
                throw new \Exception('The item with field '.$keyFieldName.' = '.$id .' is not found !');
            }
        }

        if(!$data) {
            $data = new self();
        }

        $data->setAttributes($attributes, false);
        return $data;
    }

}