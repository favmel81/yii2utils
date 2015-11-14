<?php


namespace yii2utils\helpers\form;


class Checkbox extends FieldAbstract {

    protected $valueAttribute = null;

    public function init()
    {
        if(isset($this->attributes['value'])) {
            $this->valueAttribute = $this->attributes['value'];
            unset($this->attributes['value']);
        }
        parent::init();
    }


    public function render() {
        if($this->error) {
            $this->addClass($this->errorClass);
        }

        $value = '';
        if($this->valueAttribute !== null) {
            $value = ' value="'.htmlspecialchars($this->valueAttribute).'"';
        }

        $checked = '';
        if($this->value || ($this->valueAttribute !== null && $this->value === $this->valueAttribute)) {
            $checked = ' checked';
        }

        $str = '<input type="checkbox" name="'.$this->name.'" '.$this->renderAttributes().' '.$value.' '.$checked.'/>';
        return $str;
    }
}