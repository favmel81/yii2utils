<?php


namespace yii2utils\web;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;


abstract class UserIdentity extends ActiveRecord implements IdentityInterface
{

    const PASSWORD_MIN_LENGTH = 10;
    const EVENT_BEFORE_CHANGE_PASSWORD = 'beforeChangePassword';

    public function beforeSave($insert)
    {

        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->auth_key = Yii::$app->getSecurity()->generateRandomString();
                $this->password = self::generatePassword($this->password);
            }
            return true;
        }
        return false;
    }

    public static function  generatePassword($password = null, $length = self::PASSWORD_MIN_LENGTH)
    {

        if ($password == null) {
            $length = (int)$length;
            if ($length < self::PASSWORD_MIN_LENGTH) {
                $length = 10;
            }
            $password = Yii::$app->security->generateRandomString($length);
        }

        return Yii::$app->security->generatePasswordHash($password);
    }


    public function changePassword($password, $changeAuthKey = true) {
        $this->trigger(self::EVENT_BEFORE_CHANGE_PASSWORD);
        if($changeAuthKey) {
            $this->auth_key = Yii::$app->getSecurity()->generateRandomString();
        }
        $this->password = self::generatePassword($password);
        $this->save(false);
    }


    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

} 