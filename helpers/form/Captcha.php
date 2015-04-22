<?php


namespace yii2utils\helpers\form;

use yii\helpers\Html;


class Captcha  extends FieldAbstract {

    public $template = '{image}{input}';
    public $imageClass = 'captcha-image';
    public $inputClass = 'captcha-input';
    public $captchaAction = 'site/captcha';


    public function init()
    {
        $this->addSkipAttributes(
            [
                'template',
                'imageClass',
                'inputClass',
                'captchaAction'
            ]
        );
        parent::init();
    }

    public function render() {
        if($this->error) {
            $this->addClass($this->errorClass);
        }

        if($this->inputClass != '') {
            $this->addClass($this->inputClass);
        }

        $route = $this->captchaAction;
        if (is_array($route)) {
            $route['v'] = uniqid();
        } else {
            $route = [$route, 'v' => uniqid()];
        }

        $input = '<input type="text" name="'.$this->name.'" '.$this->renderAttributes().' value="'.$this->renderValue().'" />';
        $image = Html::img($route, ['class' => $this->imageClass]);
        return strtr($this->template, [
            '{input}' => $input,
            '{image}' => $image,
        ]);
    }
}