<?php


namespace yii2utils\core\rest;

use Yii;
use yii\filters\auth\CompositeAuth;
use yii\filters\ContentNegotiator;
use yii\filters\RateLimiter;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii2utils\core\helpers\JsonResultCollector;


class JsonResponseController extends \yii\web\Controller
{

    public $enableCsrfValidation = false;


    /**
     * @var JsonResultCollector
     */
    protected $json;


    /**
     * @inheritdoc
     */
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

    public function init()
    {
        parent::init();
        $this->json = new JsonResultCollector;
    }

    /**
     * @inheritdoc
     */
    public function afterAction($action, $result)
    {
        $result = parent::afterAction($action, $this->json);
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        Yii::$app->response->statusCode = $result->getStatusCode();
        return $result->getResult();

    }

    /**
     * Declares the allowed HTTP verbs.
     * Please refer to [[VerbFilter::actions]] on how to declare the allowed verbs.
     *
     * @return array the allowed HTTP verbs.
     */
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
