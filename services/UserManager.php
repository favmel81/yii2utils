<?php


namespace yii2utils\services;


use Yii;
use yii\web\IdentityInterface;
use yii\base\Object;


class UserManager extends Object
{
    const REMEMBER_PERIOD_DAYS = 30;
    const MESSAGE_USER_BLOCKED = 'user blocked';
    const MESSAGE_INVALID_PASSWORD = 'invalid password';
    const MESSAGE_USER_IS_NOT_FOUND = 'user is not found';

    public $identityClass = null;



    public function authByLoginPassword($login, $password, $remember = false)
    {
        $identityClass = $this->getIdentityClass();
        $user = $identityClass::findByLogin($login);
        if ($user) {
            if ($user->password === md5($password . $user->password_salt)) {
                if ($user->ban == 0) {
                    return self::auth($user, $remember);
                }
                $errors['login'] = self::MESSAGE_USER_BLOCKED;
            } else {
                $errors['password'] = self::MESSAGE_INVALID_PASSWORD;
            }
        } else {
            $errors['login'] = self::MESSAGE_USER_IS_NOT_FOUND;
        }
        return $errors;
    }

    public function authById($id, $remember = false) {
        $identityClass = $this->getIdentityClass();
        $user = $identityClass::findOne($id);
        if($user) {
            return self::auth($user, $remember);
        }
        return false;
    }


    protected static function auth(IdentityInterface $identity, $remember = false)
    {
        return Yii::$app->user->login(
            $identity, $remember ? 3600 * 24 * self::REMEMBER_PERIOD_DAYS : 0
        );
    }

    protected function getIdentityClass() {
        if($this->identityClass !== null) {
            return $this->identityClass;
        }
        return Yii::$app->user->identityClass;
    }

    public function setIdentityClass($className) {
        $this->identityClass = $className;
        return $this;
    }

} 