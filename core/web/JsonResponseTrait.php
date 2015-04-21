<?php

namespace favmel81\yii2utils\core\web;

use Yii;
use yii\web\Response;
use favmel81\yii2utils\core\helpers\JsonResultCollector;


trait JsonResponseTrait
{


    protected $cancelJsonResponse = false;
    /**
     *
     * @var bool send 500 status code if success == false
     */
    protected $send500 = true;

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

    public function sendStatus403($send = true) {
        $this->send403 = (boolean)$send;
    }


    protected function createResponse($e = null)
    {
        if ($e instanceof \Exception) {
            $this->json->result(
                array(
                    'success' => false,
                    'message'     => $e->getMessage()
                )
            )->setStatusCode(400);
        }

        if(!$this->json->isSuccess() && $this->send500) {
            $statusCode = 500;
        } else {
            $statusCode = $this->json->getStatusCode();
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        Yii::$app->response->statusCode = $statusCode;
        Yii::$app->response->charset = 'UTF-8';
        return $result = $this->json->getResult();
    }
}