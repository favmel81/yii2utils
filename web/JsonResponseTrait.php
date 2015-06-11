<?php

namespace yii2utils\web;

use Yii;
use yii\web\Response;
use yii2utils\helpers\JsonResultCollector;


trait JsonResponseTrait
{


    protected $cancelJsonResponse = false;
    /**
     *
     * @var bool send 500 status code if success == false
     */
    protected $sendErrorStatus = false;

    protected $errorStatusCode = 500;

    /**
     * @var JsonResultCollector
     */
    protected $json;

    public function init()
    {
        parent::init();
        $this->enableCsrfValidation = false;
        $this->json = new JsonResultCollector;
    }

    public function runAction($id, $params = [])
    {
        if(method_exists($this, 'preBeforeAction')) {
            $result = $this->preBeforeAction($id);
            if($result !== null && $result !== true) {
                return $result;
            }
        }

        try {
            return parent::runAction($id, $params);
        } catch (\Exception $e) {
            if ($this->cancelJsonResponse) {
                throw $e;
            }
            return $this->createResponse($e);
        }
    }

    public function afterAction($action, $result)
    {
        if(method_exists($this, 'preAfterAction')) {
            $this->preAfterAction();
        }
        if (!$this->cancelJsonResponse) {
            $result = $this->json;
        }
        $this->json = parent::afterAction($action, $result);
        if ($this->cancelJsonResponse) {
            return $this->json;
        }
        return $this->createResponse();
    }

    public function cancelJsonRespon($cancel = true)
    {
        $this->cancelJsonResponse = (boolean)$cancel;
    }

    public function sendErrorStatusCode($send = true) {
        $this->sendErrorStatus = (boolean)$send;
    }


    protected function createResponse($e = null)
    {
        if ($e instanceof \Exception) {
            $this->json->result(
                array(
                    'success' => false,
                    'message'     => $e->getMessage()
                )
            )->setStatusCode($this->errorStatusCode);
        }

        if(!$this->json->isSuccess() && $this->sendErrorStatus) {
            $statusCode = $this->errorStatusCode;
        } else {
            $statusCode = $this->json->getStatusCode();
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        Yii::$app->response->statusCode = $statusCode;
        Yii::$app->response->charset = 'UTF-8';
        return $this->json->getResult();
    }
}