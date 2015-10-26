<?php


namespace yii2utils\web;

use Yii;
use yii\web\Application as WebApplication;
use yii\base\InvalidRouteException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class Application extends WebApplication {

    const EVENT_RESOLVE_ROUTE = 'resolveRoute';

    public function handleRequest($request)
    {
        if (empty($this->catchAll)) {
            list ($route, $params) = $request->resolve();
        } else {
            $route = $this->catchAll[0];
            $params = $this->catchAll;
            unset($params[0]);
        }

        try {
            Yii::trace("Route requested: '$route'", __METHOD__);
            $this->requestedRoute = $route;
            $this->trigger(self::EVENT_RESOLVE_ROUTE);
            $result = $this->runAction($route, $params);
            if ($result instanceof Response) {
                return $result;
            } else {
                $response = $this->getResponse();
                if ($result !== null) {
                    $response->data = $result;
                }

                return $response;
            }
        } catch (InvalidRouteException $e) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'), $e->getCode(), $e);
        }
    }

}