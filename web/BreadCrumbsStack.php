<?php


namespace yii2utils\web;

use Yii;
use yii\base\Object;


/**
 *
 * $homeTitle   main link title (by default it is translate key)
 * $homeUrl     main link url (if it is null or false it will be set to Yii::$app->homeUrl)
 *
 * Class BreadCrumbsStack
 *
 * @package web
 */
class BreadCrumbsStack extends Object
{


    public $homeTitle = 'Main page';
    public $homeUrl = null;
    public $homeLangCategory = 'app';

    protected $links = [];
    protected $enableHomeLink = true;


    public function addItem($title, $url = false)
    {
        $this->links[] = [
            'title' => $title,
            'url'   => $url
        ];
        return $this;
    }

    public function enableHome($enable = true)
    {
        $this->enableHomeLink = (boolean)$enable;
        return $this;
    }


    public function setHomeItem($title, $url = null, $doTranslate = false)
    {
        $this->homeTitle = $title;
        $this->homeUrl = $url;
        if ($doTranslate === false || is_scalar($doTranslate)) {
            $this->homeLangCategory = $doTranslate;
        }
        return $this;
    }


    public function getLinks() {
        if($this->enableHomeLink) {
            array_unshift($this->links, $this->getHomeItem());
        }


        $count = sizeof($this->links);
        foreach ($this->links as $i => $link) {
            $result = [
                'index' => $i++,
                'number' => $i,
                'count' => $count,
                'title' => $link['title'],
                'url'   => isset($link['url']) ? $link['url'] : false,
                'first' => $i == 1 ? true : false,
                'last'  => $i == $count ? true : false
            ];
            yield (object)$result;
        }
    }


    public function count() {
        return sizeof($this->links) + (int)$this->enableHomeLink;
    }


    protected function getHomeItem() {
        return [
            'title' => $this->homeLangCategory?Yii::t($this->homeLangCategory, $this->homeTitle):$this->homeTitle,
            'url' => $this->homeUrl?$this->homeUrl:Yii::$app->homeUrl
        ];
    }


}