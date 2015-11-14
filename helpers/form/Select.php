<?php


namespace yii2utils\helpers\form;


class Select extends FieldAbstract {

    public $options;

    public function init()
    {
        if(isset($this->attributes['options'])) {
            $this->options = $this->attributes['options'];
            if(isset($this->attributes['firstOption']) && is_array($this->attributes['firstOption'])) {
                array_unshift($this->options, $this->attributes['firstOption']);
            }
            unset($this->attributes['options']);
            unset($this->attributes['firstOption']);
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
            foreach($this->options as $id => $option) {
                if($id !== 'optgroup') {
                    $str .= $this->renderOption($option);
                } else {
                    $str .= $this->renderOptionGroup($option);
                }
            }
        }
        $str .= '</select>';
        return $str;
    }

    protected function renderOption(&$option) {
        $value = isset($option['value'])?'value = "'.htmlspecialchars($option['value']).'"':'';
        $title = isset($option['title'])?htmlspecialchars($option['title']):'';
        $selected =  isset($option['selected']) || in_array($option['value'], $this->value)?'selected':'';
        $attributes = $this->extractAttributes($option);
        return '<option '.$value.' '.$selected.' '.$attributes.'>'.$title.'</option>'."\n";
    }

    protected function renderOptionGroup(&$group) {
        $attributes = $this->extractAttributes($group);
        $label = isset($group['label'])?'label="'.htmlspecialchars($group['label']).'"':'';
        $str = '<optgroup '.$label.$attributes.'>';

        if(isset($group['options']) && is_array($group['options'])) {
            foreach($group['options'] as $option) {
                    $str .= $this->renderOption($option);
            }
        }

        $str .= '</optgroup>';
        return $str;
    }

    private function extractAttributes(&$data) {
        $attributes = '';
        if(isset($data['attrs'])) {
            if(is_scalar($data['attrs'])) {
                $attributes = ' '.$data['attrs'];
            } elseif(is_array($data['attrs'])) {
                foreach($data['attrs'] as $name => $value) {
                    $attributes .= ' '.$name . '="'.htmlspecialchars($value).'"';
                }
            }
        }
        return $attributes;
    }
}