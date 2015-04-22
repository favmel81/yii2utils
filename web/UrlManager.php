<?php


namespace yii2utils\web;

use Yii;
use yii\web\UrlManager as CoreUrlManager;
use yii\caching\Cache;


class UrlManager extends CoreUrlManager {


    public function init()
    {

        if (!$this->enablePrettyUrl || empty($this->rules)) {
            return;
        }
        if (is_string($this->cache)) {
            $this->cache = Yii::$app->get($this->cache, false);
        }
        if ($this->cache instanceof Cache) {
            $cacheKey = __CLASS__;
            $hash = md5(json_encode($this->rules));
            if (($data = $this->cache->get($cacheKey)) !== false && isset($data[1]) && $data[1] === $hash) {
                $this->rules = $data[0];
                foreach($this->rules as $rule) {
                    if(isset($rule->alias)) {
                        Yii::setAlias('@'.$rule->alias, $rule->route);
                    }
                }
            } else {
                $this->rules = $this->buildRules($this->rules);
                $this->cache->set($cacheKey, [$this->rules, $hash]);
            }
        } else {
            $this->rules = $this->buildRules($this->rules);
        }
    }
}