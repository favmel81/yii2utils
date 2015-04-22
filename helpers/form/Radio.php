<?php


namespace yii2utils\helpers\form;


class Radio extends FieldAbstract {

    public $items;

    public function init()
    {
        if(isset($this->attributes['items'])) {
            $this->items = $this->attributes['items'];
            unset($this->attributes['items']);
        }
        parent::init();
    }

    public function render() {
        if($this->error) {
            $this->addClass($this->errorClass);
        }
        $str = '';
        if(is_array($this->items)) {
            foreach($this->items as $item) {
                $value = isset($item['value'])?htmlspecialchars($item['value']):'';
                $before = isset($item['before'])?$item['before']:'';
                $after = isset($item['after'])?$item['after']:'';
                $checked = $this->value === $value || (empty($this->value) && (isset($item['checked']) || in_array('checked', $item)))?'checked':'';
                $str .= $before.'<input type="radio" name="'.$this->name.'" '.$this->renderAttributes().' value="'.$value.'" '.$checked.' />'.$after."\n";
            }
        }



        return $str;
    }
}