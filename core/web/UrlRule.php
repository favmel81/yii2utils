<?php


namespace yii2utils\core\web;

use Yii;
use yii\web\UrlRule as BaseUrlRule;


class UrlRule extends BaseUrlRule {

    public $alias;
    public $template;
    protected $_template;

    public function init() {
        if($this->alias) {
            Yii::setAlias('@'.$this->alias, $this->route);
        }
        parent::init();
    }

}