<?php


namespace yii2utils\events;
use yii\base\Event;

class AfterUserMatchEvent extends Event
{

    protected $errors = [];
    protected $resultSuccess = true;

    public function setErrors($errors) {
        if(is_array($errors)) {
            $this->errors = $errors;
        }
        $this->success(false);
    }

    public function addError($name, $error) {
        $this->errors[$name] = $error;
        $this->success(false);
        return $this;
    }


    public function success($success) {
        $this->resultSuccess = (boolean)$success;
        return $this;
    }

    public function isSuccess() {
        return $this->resultSuccess;
    }

    public function getErrors() {
        return $this->errors;
    }

} 