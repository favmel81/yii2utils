<?php

/**
 * Usage example:
 * 1. Add route rule:
 *  [
 *      'class'      => 'yii\rest\UrlRule',
*       'controller' => [
*           'api' => 'module/api',
*            ...
*       ],
*       'pluralize' => false,
*       ['prefix'     => 'angular/rest',]
*       'tokens' => [
*           '{id}' => '<id:[0-9a-zA-Z_-][0-9a-zA-Z_,-]*>'
*       ]
*   ]
 *
 * 2. Add this trait to yii\web\Controller
 *
 * class ApiController extends Controller {
 *    use JsonResponseTrait;
 *    public function actionIndex() { ...
 *
 *
 *
 */

namespace yii2utils\rest;


use Yii;
use yii\filters\auth\CompositeAuth;
use yii\filters\RateLimiter;
use yii\filters\VerbFilter;
use yii2utils\web\JsonResponseTrait as WebJsonResponse;


trait JsonResponseTrait
{
 use WebJsonResponse;


    public function behaviors()
    {
        return [
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
        /*return [
            'index'  => ['GET', 'HEAD'],
            'view'   => ['GET', 'HEAD'],
            'create' => ['POST'],
            'update' => ['PUT', 'PATCH'],
            'delete' => ['DELETE'],
        ];*/

        return [
            'index'  => ['GET', 'HEAD'],
            'view'   => ['GET', 'HEAD'],
            'save' => ['POST', 'PUT', 'PATCH'],
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