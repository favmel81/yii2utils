<?php


namespace yii2utils\core\data;

use Yii;
use yii\base\Object;
use yii\web\Request;


class Pagination extends Object
{
    public $totalCount = 0;
    public $pageSize = 20;
    public $linksCount = 5;


    public $params;


    public $pageParam = 'page';
    public $pageValuePrefix = '';
    public $removeFirstPageParam = true;


    public $route;
    public $urlManager;
    public $absoluteUrls = false;




    protected $page = 1;
    protected $pagesCount = 1;


    protected $groupsCount;
    protected $group = 1;

    protected $first = 0;
    protected $last = 0;

    public function init() {
        parent::init();
        $this->pagesCount = ceil($this->totalCount / $this->pageSize);
        $this->groupsCount = ceil($this->pagesCount / $this->linksCount);
    }



    public function setAbsoluteUrls($value) {
        $this->absoluteUrls = (boolean)$value;
    }

    public function setPage($page)
    {
        $page = (int)$page;
        if($page <= 0) {
            $page = 1;
        }

        if($page > $this->pagesCount) {
            $page = $this->pagesCount;
        }

        $this->page = $page;
        $this->calcGroup();
        return $this;
    }

    public function setParams($name = null, $value = null) {
        if($name === null || is_array($name)) {
            $this->params = $name;
        } elseif(is_scalar($name) && is_scalar($value) && $value !== null) {
            if(!is_array($this->params)) {
                $this->params = [];
            }
            $this->params[$name] = $value;
        }
        return $this;
    }


    protected function calcGroup() {
        $this->group = ceil($this->page / $this->linksCount);
    }


    public function getPage() {
        return $this->page;
    }

    public function getGroup() {
        return $this->group;
    }

    public function getGroupsCount() {
        return $this->groupsCount;
    }

    public function getPagesCount() {
        return $this->pagesCount;
    }

    public function createUrl($page)
    {
        $page = (int) $page;
        if (($params = $this->params) === null) {
            $request = Yii::$app->getRequest();
            $params = $request instanceof Request ? $request->getQueryParams() : [];
        }

        if($page == 1 && $this->removeFirstPageParam) {
            unset($params[$this->pageParam]);
        } else {
            $params[$this->pageParam] = $this->pageValuePrefix.$page;
        }

        $params[0] = $this->route === null ? Yii::$app->controller->getRoute() : $this->route;
        $urlManager = $this->urlManager === null ? Yii::$app->getUrlManager() : $this->urlManager;
        if ($this->absoluteUrls) {
            return $urlManager->createAbsoluteUrl($params);
        } else {
            return $urlManager->createUrl($params);
        }
    }


    public function getPages()
    {
        if($this->pagesCount == 0) {
            return [];
        }

        $first = ($this->group - 1)*$this->linksCount + 1;
        $last = $first + $this->linksCount - 1;
        if($last > $this->pagesCount) {
            $last = $this->pagesCount;
        }
        $this->first = $first;
        $this->last = $last;
        return range($first, $last, 1);
    }


    public function first() {
        return $this->first;
    }

    public function last() {
        return $this->last;
    }

}
