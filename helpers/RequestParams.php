<?php


namespace yii2utils\helpers;

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

    public function sortExt() {
        $sort = json_decode($this->getParam('sort'), true);
        if(is_array($sort) && isset($sort[0])) {
            $sort = $sort[0];
            $property = isset($sort['property'])?$sort['property']:null;
            $direction = isset($sort['direction'])?$sort['direction']:null;

            if($direction == 'ASC') {
                $direction = SORT_ASC;
            } elseif($direction == 'DESC') {
                $direction = SORT_DESC;
            } else {
                $direction = null;
            }

            if($direction && $property) {
               $sort = [
                    'property' => $property,
                    'direction' => $direction
                ];
            } else {
                $sort = null;
            }

        } else {
            $sort = null;
        }
        return $sort?(object)$sort:null;
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