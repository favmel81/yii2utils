<?php


namespace yii2utils\core\helpers;

use Yii;
use yii\base\Object;


class RequestParams extends Object
{


    public $limit = 25;

    public function limit($default = null)
    {
        $default = $default === null?$this->limit:$default;
        $limit = (int)$this->getParam('limit', $default);
        if($limit <= 0) {
            $limit = $this->limit;
        }
        return $limit;
    }

    public function start($default = 0)
    {
        $start = (int)$this->getParam('start', $default);
        if($start < 0) {
            $start = 0;
        }
        return $start;
    }

    public function __call($name, $params)
    {
        $default = isset($params[0])?$params[0]:null;
        return $this->getParam($name, $default);
    }


    protected function getParam($name, $default = null)
    {
        $request = Yii::$app->request;
        $value = $request->getQueryParam($name, $default);
        if ($request->isPost) {
            $value = $request->post($name, $value);
        }
        return $value;
    }


}