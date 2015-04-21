<?php

namespace favmel81\yii2utils\core\rest;


use Yii;
use yii\web\Response;
use yii\filters\auth\CompositeAuth;
use yii\filters\ContentNegotiator;
use yii\filters\RateLimiter;
use yii\filters\VerbFilter;
use favmel81\yii2utils\core\web\JsonResponseTrait as WebJsonResponse;


trait JsonResponseTrait
{
 use WebJsonResponse;


    public function behaviors()
    {
        return [
            'contentNegotiator' => [
                'class'   => ContentNegotiator::className(),
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    'application/xml'  => Response::FORMAT_XML,
                ],
            ],
            'verbFilter'        => [
                'class'   => VerbFilter::className(),
                'actions' => $this->verbs(),
            ],
            'authenticator'     => [
                'class' => CompositeAuth::className(),
            ],
            'rateLimiter'       => [
                'class' => RateLimiter::className(),
            ],
        ];
    }



    protected function verbs()
    {
        return [
            'index'  => ['GET', 'HEAD'],
            'view'   => ['GET', 'HEAD'],
            'create' => ['POST'],
            'update' => ['PUT', 'PATCH'],
            'delete' => ['DELETE'],
        ];
    }

    public function actionIndex()
    {
        $this->json->message('Index Action');
    }

    public function actionView($id = null)
    {
        $this->json->message('View Action');
    }

    public function actionCreate()
    {
        $this->json->message('Create Action');
    }


    public function actionUpdate($id = null)
    {
        $this->json->message('Update Action');
    }


    public function actionDelete($id = null)
    {
        $this->json->message('Delete Action');
    }

}