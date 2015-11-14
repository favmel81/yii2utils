<?php


namespace yii2utils\services;


use Yii;
use yii\web\IdentityInterface;
use yii\base\Object;
use yii2utils\web\UserIdentity;
use yii2utils\events\AfterUserMatchEvent;


class UserManager extends Object
{
    const MESSAGE_USER_BLOCKED = 'user blocked';
    const MESSAGE_INVALID_PASSWORD = 'invalid password';
    const MESSAGE_USER_IS_NOT_FOUND = 'user is not found';

    public $identityClass = null;



    public function authByLoginPassword($login, $password, $remember = false)
    {
        $errors = [];
        $identityClass = $this->getIdentityClass();
        $user = $identityClass::findByLogin($login);

        if ($user) {
            $passwordError = false;
            try {
                if(Yii::$app->security->validatePassword($password, $user->password)) {
                    $event = new AfterUserMatchEvent();

                    $user->trigger(
                        UserIdentity::EVENT_AFTER_AUTH_MATCH_USER,
                        $event
                    );

                    if($event->isSuccess()) {
                        return self::auth($user, $remember);
                    }

                    $errors = $event->errors;
                } else {
                    $passwordError = true;
                }

            } catch (\Exception $e) {
                $passwordError = true;
            }

            if($passwordError) {
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


    /**
     * @param IdentityInterface $identity
     * @param bool|int|false $remember
     * @return bool
     */
    protected static function auth(IdentityInterface $identity, $remember = false)
    {
        if($remember > 0) {
            $remember = 3600 * 24 * (int)$remember;
        } else {
            $remember = 0;
        }

        return Yii::$app->user->login(
            $identity, $remember
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