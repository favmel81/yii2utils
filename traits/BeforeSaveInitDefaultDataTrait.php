<?php


namespace yii2utils\traits;


trait BeforeSaveInitDefaultDataTrait {

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                if (isset($this->_initData)) {
                    foreach ($this->_initData as $attribute => $value) {
                        if (!isset($this->attributes[$attribute])) {
                            $this->setAttributes([$attribute => $value], false);
                        }
                    }
                }
            }
            return true;
        }
        return false;
    }
}