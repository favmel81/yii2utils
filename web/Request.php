<?php


namespace yii2utils\web;

use Yii;
use yii\web\Request as WebBaseRequest;
use yii\web\Cookie;
use yii\base\InvalidConfigException;


class Request extends WebBaseRequest
{

    public $safeCookies = [];


    public function setSafeCookies($cookies)
    {
        if (is_array($cookies) && sizeof($cookies)) {
            $this->safeCookies = $cookies;
        }
    }


    protected function loadCookies()
    {
        $cookies = [];

        foreach ($_COOKIE as $name => $value) {

            if ($this->enableCookieValidation && !in_array($name, $this->safeCookies)) {
                if ($this->cookieValidationKey == '') {
                    throw new InvalidConfigException(get_class($this) . '::cookieValidationKey must be configured with a secret key.');
                }
                if (!is_string($value)) {
                    continue;
                }
                $data = Yii::$app->getSecurity()->validateData($value, $this->cookieValidationKey);
                if ($data === false) {
                    continue;
                }
                $data = @unserialize($data);
                if (!(is_array($data) && isset($data[0], $data[1]) && $data[0] === $name)) {
                    continue;
                }
                $value = $data[1];
            }

            $cookies[$name] = new Cookie([
                'name' => $name,
                'value' => $value,
                'expire'=> null
            ]);
        }

        return $cookies;
    }

}