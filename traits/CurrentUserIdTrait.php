<?php


namespace yii2utils\traits;

use Yii;


trait CurrentUserIdTrait {

    public function getUserId()
    {
        $user = Yii::$app->user->identity;
        return $user ? $user->getId(): 0;
    }
}