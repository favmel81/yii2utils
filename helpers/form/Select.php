<?php


namespace yii2utils\helpers\form;


class Select extends FieldAbstract {

    public $options;
    public $multiple;

    public function init()
    {
        if(isset($this->attributes['options'])) {
            $this->options = $this->attributes['options'];
            unset($this->attributes['options']);
        }
        parent::init();
    }

    public function render() {
        if($this->error) {
            $this->addClass($this->errorClass);
        }

        if(is_null($this->value)) {
            $this->value = [];
        }

        if(!is_array($this->value)) {
            $this->value = [$this->value];
        }

        $str = '<select name="'.$this->name.'" '.$this->renderAttributes().'>';
        if(is_array($this->options)) {
            foreach($this->options as $option) {
                $value = isset($option['value'])?'value = "'.htmlspecialchars($option['value']).'"':'';
                $title = isset($option['title'])?htmlspecialchars($option['title']):'';
                $selected =  isset($option['selected']) || in_array($option['value'], $this->value)?'selected':'';
                $str .= '<option '.$value.' '.$selected.'>'.$title.'</option>'."\n";
            }
        }
        $str .= '</select>';
        return $str;
    }
}