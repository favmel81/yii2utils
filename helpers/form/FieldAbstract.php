<?php

namespace yii2utils\helpers\form;

use yii\base\Object;


abstract class FieldAbstract extends Object
{

    public $name;
    public $value;
    public $errorClass = 'field-error';
    public $error = false;
    public $attributes = [];
    public $skipValue = false;

    protected $skipAttributes = [
        'name',
        'value'
    ];


    public function init()
    {
        parent::init();
        $this->extractClasses();
    }

    public function setSkipValue($value) {
        $this->skipValue = (boolean)$value;
    }

    public function setName($value) {
        $this->name = $value;
    }

    public function setValue($value) {
        $this->value = $value;
    }

    public function setErrorClass($value) {
        $this->errorClass = $value;
    }

    public function setError($value) {
        $this->error = (boolean)$value;
    }

    public function setAttributes($value) {
        $this->attributes = $value;
    }

    protected function extractClasses()
    {
        $classes_ = [];
        $classes = isset($this->attributes['class']) ? $this->attributes['class']: null;
        if ($classes) {
            if (is_array($classes)) {
                $classes_ = $classes;
            } else {
                $classes = preg_split('/\s+/', $classes);
                foreach ($classes as $class) {
                    $class = trim($class);
                    if ($class) {
                        $classes_[] = $class;
                    }
                }
            }
            $classes_ = array_unique($classes_);
        }
        $this->attributes['class'] = $classes_;
    }

    protected function renderAttributes() {
        $attr = [];
        foreach($this->attributes as $name => $value) {
            if((is_array($value) && $name != 'class')
            || in_array($name, $this->skipAttributes)) {
                continue;
            }

            if ($name != 'class') {
                $attr[] = $name . '="' . htmlspecialchars($value) . '"';
            } elseif ($value) {
                $attr[] = 'class="' . implode(' ', $value) . '"';
            }
        }
        return implode(' ', $attr);
    }

    protected function renderValue()
    {
        if (!$this->skipValue) {
            return htmlspecialchars($this->value);
        }

    }

    protected function addClass($class)
    {
        if(is_scalar($class) && !empty($class) && !in_array($class, $this->attributes['class'])) {
            $this->attributes['class'][] = $class;
        }
        return $this;
    }

    protected function addSkipAttributes($attributes) {
        if(!is_array($attributes)) {
            $attributes = [$attributes];
        }
        $this->skipAttributes = array_merge($this->skipAttributes, $attributes);
        $this->skipAttributes = array_unique($this->skipAttributes);
    }

    abstract function render();

}