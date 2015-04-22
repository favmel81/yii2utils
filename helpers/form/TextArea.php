<?php


namespace yii2utils\helpers\form;


class TextArea extends FieldAbstract {

    public function render() {
        if($this->error) {
            $this->addClass($this->errorClass);
        }
        $str = '<textarea name="'.$this->name.'" '.$this->renderAttributes().'>'.$this->renderValue().'</textarea>';
        return $str;
    }
}