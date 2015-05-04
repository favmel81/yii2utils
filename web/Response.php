<?php


namespace yii2utils\web;

use Yii;
use yii\web\Response as WebBaseResponse;

class Response extends  WebBaseResponse {



    protected function sendCookies()
    {
        $cookies = $this->getCookies();
        if ($cookies === null) {
            return;
        }
        $request = Yii::$app->getRequest();
        if ($request->enableCookieValidation) {
            if ($request->cookieValidationKey == '') {
                throw new InvalidConfigException(get_class($request) . '::cookieValidationKey must be configured with a secret key.');
            }
            $validationKey = $request->cookieValidationKey;
        }
        foreach ($cookies as $cookie) {
            $value = $cookie->value;
            if (!in_array($cookie->name, $request->safeCookies) && $cookie->expire != 1  && isset($validationKey)) {
                $value = Yii::$app->getSecurity()->hashData(serialize([$cookie->name, $value]), $validationKey);
            }
            setcookie($cookie->name, $value, $cookie->expire, $cookie->path, $cookie->domain, $cookie->secure, $cookie->httpOnly);
        }
    }





}