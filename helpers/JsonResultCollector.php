<?php

namespace yii2utils\helpers;

class JsonResultCollector
{

    /**
     * @var array
     */
    protected $result = array();

    /**
     * @var bool
     */
    protected $success;

    /**
     * @var bool
     */
    protected $invoked = false;


    protected $statusCode = 200;

    public function __construct($success = true)
    {
        $this->success($success);
    }

    /**
     * @return $this
     */
    public function __invoke()
    {
        return $this;
    }


    /**
     * @return bool
     */
    public function isInvoked()
    {
        return $this->invoked;
    }


    public function  __call($name, $arguments)
    {
        if (isset($arguments[0])) {
            $this->result[$name] = $arguments[0];
        }
        return $this;
    }


    /**
     * @param bool $success
     * @return $this
     */
    public function success($success = true)
    {
        $this->invoked = true;
        $this->success = (boolean)$success;
        return $this;
    }


    /**
     * @param      $key
     * @param null $value
     * @return $this
     */
    public function result($key, $value = null)
    {
        $this->invoked = true;
        if (is_array($key)) {
            if(isset($key['success'])) {
                $this->success($key['success']);
            }
            unset($key['success']);
            $this->result = $key;
        } elseif ($value !== null) {
            if($key == 'success') {
                $this->success($value);
            } else {
              $this->result[$key] = $value;
            }
        }
        return $this;
    }


    /**
     * @param $total
     *
     * @return $this
     */
    public function total($total)
    {
        $this->invoked = true;
        $this->result['total'] = (int)$total;
        return $this;
    }


    /**
     * @param      $message
     * @param null $success
     *
     * @return $this
     */
    public function message($message, $success = null)
    {
        $this->invoked = true;
        if ($success !== null) {
            $this->success($success);
        }
        $this->result['message'] = $message;
        return $this;
    }


    /**
     * @param      $key
     * @param null $value
     *
     * @return $this
     */
    public function data($key, $value = null)
    {
        $this->invoked = true;
        if (!isset($this->result['data'])) {
            $this->result['data'] = array();
        }

        if (is_array($key)) {
            $this->result['data'] = array_merge($this->result['data'], $key);
        } elseif ($value !== null) {
            $this->result['data'][$key] = $value;
        }
        return $this;
    }


    /**
     * @param      $key
     * @param null $value
     *
     * @return $this
     */
    public function errors($key, $value = null)
    {
        $this->invoked = true;
        if (!isset($this->result['errors'])) {
            $this->result['errors'] = array();
        }

        if (is_array($key)) {
            $this->result['errors'] = array_merge(
                $this->result['errors'],
                $key
            );
        } elseif ($value !== null) {
            $this->result['errors'][$key] = $value;
        }
        return $this->success(false);
    }


    /**
     * @return array
     */
    public function getResult()
    {
        $this->result['success'] = $this->success;
        return $this->result;
    }

    public function setStatusCode($code = 200) {
        $this->statusCode = (int)$code;
        return $this;
    }

    public function getStatusCode() {
        return $this->statusCode;
    }

    public function isSuccess() {
        return $this->success;
    }
}