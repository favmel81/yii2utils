<?php


namespace yii2utils\events;
use yii\base\Event;

class AfterUserMatchEvent extends Event
{

    public $errors = [];
    protected $resultSuccess = true;

    public function setErrors($errors) {
        if(is_array($errors)) {
            $this->errors = $errors;
        }
    }

    public function addError($name, $error) {
        $this->errors[$name] = $error;
        $this->resultSuccess = false;
        return $this;
    }


    public function success($success) {
        $this->resultSuccess = (boolean)$success;
        return $this;
    }

    public function isSuccess() {
        return $this->resultSuccess;
    }

} 