<?php


namespace favmel81\yii2utils\core\helpers\form;


class TextField extends FieldAbstract {

    protected $tag = 'input';
    protected $type = 'text';

    public function render() {
        if($this->error) {
            $this->addClass($this->errorClass);
        }
        $str = '<'.$this->tag.' type="'.$this->type.'" name="'.$this->name.'" '.$this->renderAttributes().' value="'.$this->renderValue().'" />';
        return $str;
    }
}